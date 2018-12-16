<?php require('common.php');
if($_POST && !empty($_POST['buyer_name'])){
	$result = $db->add_buyer(
		strip_tags($_POST['buyer_name']));
	header('Location: ../order.php');
}?>