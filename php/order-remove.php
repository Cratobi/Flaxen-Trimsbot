<?php require('common.php');
if($_POST && !empty($_POST['idx'])){
	$result = $db->remove_order(strip_tags($_POST['idx']));
}?>