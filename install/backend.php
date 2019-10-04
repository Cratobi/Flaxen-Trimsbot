<?php
if(isset($_POST["cmd"])){
	$cmd = $_POST["cmd"];
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "trimsbot_db";

	if($cmd == 1){
		echo "- Forging<br>";

		$conn = mysqli_connect($servername, $username, $password);
		if (!$conn) {
			die("Connection failed: " . $conn->error());
		}

		$sql = "CREATE DATABASE $dbname;";
		if (mysqli_query($conn, $sql)) {
			echo "- Database forged!<br>";	
		} else {
			echo "- Failed to forge Database <b>:(</b> &thinsp; <i>" . $conn->error . "</i><br>";
		}

		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn) {
			die("Connection failed: " . $conn->error());
		}

		$sql = "
			CREATE TABLE accounts (
				id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				username VARCHAR(32) NOT NULL,
				name VARCHAR(32) NOT NULL,
				password VARCHAR(100) NOT NULL,
				privillege INT(1) NOT NULL DEFAULT 1
			);
		";
		$sql .= "
			CREATE TABLE buyers (
				id INT(2) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				buyer_name VARCHAR(30) UNIQUE NOT NULL
			);
		";
		$sql .= "
			CREATE TABLE orders (
				id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				buyer_id INT(2) UNSIGNED NOT NULL REFERENCES buyers(id),
				style_no VARCHAR(18),
				order_no VARCHAR(12) NOT NULL,
				quantity  INT(6) NOT NULL,
				shipment_date DATE,
				status VARCHAR(20), 
				remarks VARCHAR(20),
				indicator BIT NOT NULL DEFAULT 0
			);
		";
		$sql .= "
			CREATE TABLE items (
				id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				order_id INT(3) REFERENCES orders(id),
				sl_no INT(2) NOT NULL,
				item VARCHAR(20) NOT NULL DEFAULT 'Other',
				description VARCHAR(20),
				price FLOAT(5),
				booking_date DATE,
				booking_quantity INT(7),
				delivery_date DATE,
				delivery_quantity INT(7),
				delivery_chalan_no INT(5),
				bill_no INT(20),
				bill_date DATE,
				indicator BIT NOT NULL
			);
		";
		$sql .= "
			CREATE TABLE ref (
				id INT(0) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				code INT(3),
				permission BIT NOT NULL DEFAULT 0
			);
		";
		$sql .= "
			CREATE TABLE counts (
				id INT(0) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				count_orders DATETIME(6),
				count_items DATETIME(6)
			);
		";
		$sql .= "
			INSERT INTO counts (id, count_orders, count_items)
			VALUES(0, NOW(6), NOW(6));
		";
		$sql .= "
			INSERT INTO accounts (name, username, password, privillege)
				VALUES('Local User', 'local', '12345', 1);
			";
			$sql .= "
			INSERT INTO accounts (name, username, password, privillege)
				VALUES('Admin', 'admin', 'admin', 2);
			";
		$sql .= "
			INSERT INTO accounts (name, username, password, privillege)
				VALUES('Momonga', 'momonga', 'letmeinplz', 3);
			";
		$sql .= "
			INSERT INTO ref (id, code, permission)
			VALUES(1, null, 0);
		";
		if ($conn->multi_query($sql) === TRUE) {
		    echo "- Tables forged<br><br>";
			
		} else {
		    echo "- Failed to forge table <b>:(</b> &thinsp; <i>" . $conn->error . "</i><br>";
		}

		mysqli_close($conn);
	}
	elseif ($_POST["cmd"] == 2) {
		echo "- Pushing resources<br>";

		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn) {
			die("Connection failed: " . $conn->error());
		}
	}
	elseif ($_POST["cmd"] == 3) {
		echo "- Destroying Craft<br>";
		
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn) {
			die("Connection failed: " . $conn->error());
		}
		$sql = "DROP DATABASE $dbname";

		if ($conn->multi_query($sql) === TRUE) {
		    echo "- Demolished craft! X_X<br><br>";
		} else {
		    echo "- Failed to destroy. The strength was not enough <b>:(</b> &thinsp; <i>" . $conn->error() . "</i><br><br>";
		}
	}
}
?>