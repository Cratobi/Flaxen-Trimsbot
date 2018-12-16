<?php
class db{
	public $db;

	function __construct(){
		$this->db_connect('localhost','adminbot','letmeinplz','sysdb');
	}

	function db_connect($host,$user,$pass,$database){
		$this->db = new mysqli($host, $user, $pass, $database);

		if($this->db->connect_errno > 0){
			die('Unable to connect to database [' . $this->db->connect_error . ']');
		}
	}
	function add_col(){
		if($this->db->query('ALTER TABLE items
			ADD `booking_quantity` INT(7) NULL AFTER `booking_date`,
			ADD `delivery_quantity` INT(7) NULL AFTER `delivery_date`')){
		}
	}
}
