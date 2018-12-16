<?php require('common.php');
$data['current'] = $db->check_changes_orders();
$data['update'] = false;
if(isset($_POST) && !empty($_POST['counter']) && $_POST['counter']!=$data['current']){
	$data['current'] = $db->check_changes_orders();
	session_start();
	$data['data'] = $db->fetch_orders();
	$data['update'] = true;
}

echo json_encode($data);
