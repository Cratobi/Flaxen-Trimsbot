<?php require('common.php');
$data['current'] = $db->check_changes_items();
$data['update'] = false;

if(isset($_POST) && !empty($_POST['counter']) && $_POST['counter']!=$data['current'] && !empty($_POST['order_id'])){
	$data['current'] = $data['current'];
	$data['data'] = $db->fetch_items($_POST['order_id']);
	$data['update'] = true;
}

echo json_encode($data);
