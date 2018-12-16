<?php require('php/common.php'); session_start();
	if(empty($_SESSION["username"]) && empty($_SESSION["privillege"])){
		header('Location: signin.php');
		exit();
	}
	else{
		header('Location: order.php');
		exit();
	}
?>