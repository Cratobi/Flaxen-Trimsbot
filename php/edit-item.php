k<?php require('common.php');
	$id = $_POST['id'];
	$header = $_POST['header'];
	$value = $_POST['value'];

	if(isset($_POST) && !empty($id) && !empty($header)) {
		$db->edit_items($id, $header, $value);
	} else {
		header('HTTP/1.0 400 Bad Request', true, 400);
		echo "Something went wrong!";
	}
?>