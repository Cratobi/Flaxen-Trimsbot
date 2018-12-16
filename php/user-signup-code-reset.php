<?php require('common.php'); session_start();
if($_SESSION["privillege"] == 2 || $_SESSION["privillege"] == 3){
	if ($db->check_ref_permission() == 0) {
		$db->set_ref(0);
		$data['code'] = '';
	} else {
		sleep(2);
		$db->set_ref(1);
		$data['code'] = $db->fetch_ref_code();
	}
	echo json_encode($data);
}
?>