<?php require('common.php');
if(isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
	$username = strtoupper($_POST['username']);
	$password = $_POST['password'];
	if($db->check_username($username) == true){
		if($db->check_password($password) == true){
			$data['update'] = true;
			$data['state'] = null;
			// Start session
			session_start();
			$_SESSION["username"] = $username;
			$_SESSION["privillege"] = $db->fetch_privillege($username);
		}
		else{
			$data['update'] = false;
			$data['state'] = 1;
			$data['status'] = "Wrong password";
		}
	}
	else{
		$data['update'] = false;
		$data['state'] = 0;
		$data['status'] = "Wrong username";
	}
}
else{
	$data['update'] = false;
}
echo json_encode($data);
?>