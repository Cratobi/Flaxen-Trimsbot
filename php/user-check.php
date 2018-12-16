<?php require('common.php');
if(isset($_POST) && !empty($_POST['username'])){
	$username = strtoupper($_POST['username']);
	$len = strlen($username);
	if($len < 6){
		$data['update'] = false;
		$data['status'] = "Too small! (min: 6 letters)";
	}
	elseif($len > 32){
		$data['update'] = false;
 		$data['status'] = "Too large!";
	}
	else{
		if($db->check_username($username) == true){
			$data['update'] = false;
			$data['status'] = "Username taken";
		} else{
			$data['update'] = true;
		}
	}
}
echo json_encode($data);
