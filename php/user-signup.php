<?php require('common.php');
if($_POST && !empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['privillege']) && !empty($_POST['ref'])){
	$name = $_POST['name'];
	$username = strtoupper($_POST['username']);
	$password = $_POST['password'];
	$privillege = $_POST['privillege'];
	$ref = $_POST['ref'];
	$len_name = strlen($name);
	$len_username = strlen($username);
	$len_password = strlen($password);

	if($len_name < 3 && $len_username < 6 && $len_password < 8) {
		echo "error";
		exit();
	} elseif($len_username > 32) {
		echo "error";
		exit();
	} else {
		if($db->check_username($username) == false){
			if ($db->check_ref_permission() == 1) {
				if($db->fetch_ref_code() == $ref){
					$data['update'] = true;

				session_start();
				if(!empty($_SESSION["username"]) || !empty($_SESSION["privillege"])){
					if($_SESSION["privillege"] == 1){
						$privillege = 1;
						$data['state'] = 3;
						$_SESSION["username"] = $username;
						$_SESSION["privillege"] = $privillege;
					} else{
						$data['state'] = 4;
					}
				} else {
					$privillege = 1;
					$data['state'] = 3;
					$_SESSION["username"] = $username;
					$_SESSION["privillege"] = $privillege;
				}
					$result = $db->add_user(
						strip_tags($name),
						strip_tags($username),
						strip_tags($password),
						strip_tags($privillege));
					
				} else {
					$data['update'] = false;
					$data['state'] = 2;
					$data['status'] = "Wrong refernce code";
				}
			} else {
				$data['update'] = false;
					$data['state'] = 1;
					$data['status'] = "Signout is not allowed by admin";
			}
		} else {
			$data['update'] = false;
			$data['state'] = 0;
			$data['status'] = "Wrong username";
		}
	}
	echo json_encode($data);
}?>
