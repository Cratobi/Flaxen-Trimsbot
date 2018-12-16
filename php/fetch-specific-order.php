<?php require('common.php');
if($_POST && !empty($_POST['idx'])){
	$idx = strip_tags($_POST['idx']);
	$data['data'] = $db->fetch_specific_order($idx);
}
echo json_encode($data);
