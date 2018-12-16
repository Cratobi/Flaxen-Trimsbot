<?php require('php/common.php'); session_start();
	if(empty($_SESSION["username"]) && empty($_SESSION["privillege"])){
		header('Location: index.php');
		exit();
	}
	if(isset($_GET) && !empty($_GET['order_id']) && $db->existence_item($_GET['order_id']) == $_GET['order_id']){
	} else{
		header('Location: index.php');
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Items - Trimsbot</title>

	<!-- Bootstrap 4 CSS -->
	<link rel="stylesheet" href="style/css/bootstrap.min.css" media="screen">
	<!-- Google Material icon -->
	<link rel="stylesheet" href="style/css/material-icons.css">
	<!-- StyleSheet -->
	<link rel="stylesheet" type="text/css" href="style/css/style.css" media="screen">
	<!-- Print StyleSheet -->
	<link rel="stylesheet" type="text/css" href="style/css/print.css" media="print">
	<!-- jQuery library 3.2.1 -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".se-pre-con").delay(1000).fadeOut(1000);
		});
	</script>
	
	<!-- Bootstrap 4 JS -->
	<script src="js/bootstrap.bundle.min.js"></script>
	
	<!-- Poshytip -->
	<script src="js/jquery.poshytip.min.js"></script>
	<!-- X-editable -->
	<link href="style/css/jquery-editable.css" rel="stylesheet"/>
	<script src="js/jquery-editable-poshytip.min.js"></script>
	<!-- Blur JS -->
	<script src="js/blur.js"></script>
	<!-- Search JS -->
	<script src="js/search.js"></script>
	<!-- Wallpaper JS -->
	<script src="js/wallpaper.js"></script>
	<!-- Bootstrap Datepicker CSS -->
	<link rel="stylesheet" href="style/css/bootstrap-datepicker3.min.css" />
	<!-- Bootstrap Datepicker JS -->
	<script src="js/bootstrap-datepicker.min.js"></script>
	<!-- Wallpaper Changer JS -->
	<?php 
	if($_SESSION["privillege"] == 3){
		echo '<script src="js/wallpaper-alt.js"></script>';

	} else {
		echo '<script src="js/wallpaper.js"></script>';
	}
	?>
	<!-- Items main JS -->
	<?php
	if($db->fetch_check($_GET['order_id']) != 1){
		echo '<script src="js/items.js"></script>';
	}
	if($db->fetch_check($_GET['order_id'])){
		echo '<script>
			$(document).ready(function(){
				$("td").css({"background-color": "rgba(76, 175, 80, 0.3)"});
			});
			</script>';
	}
	?>
</head>
<body>
<div class="se-pre-con"></div>
<div class="bg-darken"></div>
<header class="d-flex justify-content-between align-items-center">
	<span id="logo">Trimsbot</span>
	<span>
		<span class="pr-2"><?php echo $db->fetch_name($_SESSION["username"]);?></span>
		<span><a href="php/user-signout.php" class="btn btn-signout">SIGN OUT</a></span>
	</span>
</header><br><br><br>
<div class="container-fluid">
	<div id="blur-element">
	<div class="table-container table-items table-responsive-sm">
		<div id="print-header-txt" style="display: none">
			<img src="style/img/logo.png" style="margin-bottom: -2px" width="30px"><span>Flaxen Trims</span>
			<div id="print-header-txt-sm">Powered by Trimsbot</div>
			
		</div>
		<div id="print-order-txt" style="display: none"><?php echo($db->fetch_order_info($_GET['order_id'])); ?></div>
		<div class="table-header p-3">

		<div class="d-flex justify-content-between">
			<div class="text-left d-inline">
				<a href="order.php" class="btn btn-glass"> Back </a>
				<span id="order-txt"><?php echo($db->fetch_order_no($_GET['order_id'])); ?></span>
			</div>
			<div class="text-right d-inline">
				<input type="search" name="search" id="search" class="form-control d-inline-block pl-3 m-1" onkeyup="search()" placeholder="Search...">
				<button class="btn btn-icon" onclick="javascript:toaster('Items Refreshed')"><i class="material-icons">refresh</i></button>
				<button class="btn btn-icon m-1" onclick="javascript:window.print();"><i class="material-icons">print</i></button>
			</div>
		</div>
		</div>
		<table id="table-items" class="table table-hover m-4" data-counter="<?php echo $db->check_changes_items();?>" data-order_id="<?php echo $_GET['order_id']; ?>">
			<thead class="sticky-thead">
					<th scope="col">Item</th>
					<th scope="col">Description</th>
					<th scope="col">Price ($)</th>
					<th scope="col">Booking Date</th>
					<th scope="col">Booking Quantity</th>
					<th scope="col">Delivery Date</th>
					<th scope="col">Delivery Quantity</th>
					<th scope="col">Delivery Chalan No</th>
					<th scope="col">Bill No</th>
					<th scope="col">Bill Date</th>
				</thead>
				<tbody>
					<?php echo $db->fetch_items($_GET['order_id']);?>
				</tbody>
			</table>
		</div>
	</div>
	</div>
</div>
<script type="text/javascript">
function toaster(txt){
	check();
	$("#toast-msg").hide();
	$("#toast-msg").text(txt).show().delay(800).fadeOut(400);
}
</script>
<div id="toast-msg" class="toast"></div>
<div class="footer-txt"></div>
</body>
</html>
