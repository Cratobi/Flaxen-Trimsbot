<?php require('common.php'); session_start();
if($_SESSION["privillege"] == 2 || $_SESSION["privillege"] == 3){
	if ($db->check_ref_permission() == 0) {
		sleep(3);
		$db->set_ref(1);
		$data['status'] = 1;
		$data['code'] = $db->fetch_ref_code();
	} else {
		$db->set_ref(0);
		$data['status'] = 0;
		$data['code'] = '';
	}
	echo json_encode($data);
}
?>