<?php
require_once ('db.php'); //get our database class
$db = new db();

if($_POST && !empty($_POST['cmd']) && $_POST['cmd'] == 1){
	$db->add_col();
	$db->alt_col();
	echo "DONE!";
}?>