<?php require('common.php');
if($_POST && !empty($_POST['idx'])){
	$result = $db->checkout_order(strip_tags($_POST['idx']));
}?>