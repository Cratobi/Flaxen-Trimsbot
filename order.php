<?php require('php/common.php'); session_start();
if(empty($_SESSION["username"]) || empty($_SESSION["privillege"])){
	header('Location: signin.php');
	exit();
}
?>
<!doctype html>
<html>
<head>
<title>Order - Trimsbot</title>
	<!-- Bootstrap 4 CSS -->
	<link rel="stylesheet" href="style/css/bootstrap.min.css" media="screen">
	<!-- Google Material icon -->
	<link href="style/css/material-icons.css" rel="stylesheet">
	<!-- StyleSheet -->
	<link rel="stylesheet" type="text/css" href="style/css/style.css" media="screen">
	<!-- jQuery library 3.2.1 -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<!-- Bootstrap 4 JS -->
	<script src="js/bootstrap.bundle.min.js"></script>
	<!-- Moment JS -->
	<script src="js/moment.min.js"></script>
	<!-- Bootstrap Datepicker CSS -->
	<link rel="stylesheet" href="style/css/bootstrap-datepicker3.min.css" />
	<!-- Bootstrap Datepicker JS -->
	<script src="js/bootstrap-datepicker.min.js"></script>
	<!-- Clipboard JS -->
	<script src="js/clipboard.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".se-pre-con").delay(1000).fadeOut(1000);
		});
	</script>
	<!-- Blur JS -->
	<script src="js/blur.js"></script>
	<!-- Search JS -->
	<script src="js/search.js"></script>
	<!-- Wallpaper Changer JS -->
	<?php 
	if($_SESSION["privillege"] == 3){
		echo '<script src="js/wallpaper-alt.js"></script>';
	} else {
		echo '<script src="js/wallpaper.js"></script>';
	}
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		datepicker();
		set_current_date();
	});
	function datepicker(){
		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			todayHighlight: true,
			autoclose: true
		});
	}
	function set_current_date(){
		$('#add_order .datepicker').datepicker("setDate", new Date());
	}
	</script>
</head>
<body>
<div class="se-pre-con"></div>
<div class="bg-darken"></div>
<header class="d-flex justify-content-between align-items-center">
	<span id="logo">Trimsbot</span>
	<span class="px-2">
		<span class="pr-2"><?php echo $db->fetch_name($_SESSION["username"]);?></span>
		<span class="pr-2"><a href="php/user-signout.php" class="btn btn-signout">SIGN OUT</a></span>
	</span>
</header><br><br><br>
<div class="container-fluid">
	<div class="row justify-content-between">
		<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
			<div class="col-md-4 col-lg-4 col-xl-4 utility text-center">
				<h1 id="clock"></h1>
				<p id="net-status" style="color:white">Network Status is <span id="oi" stle="color:red">offline</span></p>
				<?php
					if($_SESSION["privillege"] == 2 || $_SESSION["privillege"] == 3){
						echo '<div class="btn btn-glass for-lg" data-toggle="modal" data-target="#signup_code">Get registration key</div>';
					}
				?>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
			<div id="blur-element" class="table-container">
				<div class="table-header p-3">
					<div class="d-flex justify-content-between">
						<div class="text-left d-inline">
							<select id="sortBuyer" name="buyer_id" class="form-sort">
								<option value="">All buyers</option>
								<?php echo $db->fetch_buyer_name_sort(); ?>
							</select>
						</div>
						<div class="text-right d-inline">
							<input type="search" name="search" id="search" class="form-control d-inline-block pl-3 m-1" onkeyup="search()" placeholder="Search...">
							<button class="btn btn-icon" onclick="toaster('Orders Refreshed')"><i class="material-icons">refresh</i></button>
							<?php
								if($_SESSION["privillege"] == 2 || $_SESSION["privillege"] == 3){
									echo '<button class="btn btn-icon" data-toggle="modal" data-target="#add_order"><i class="material-icons">add</i></button>';}
							?>
						</div>
					</div>
				</div>
					<table id="table-order" class="table table-hover  m-4" data-counter="<?php echo $db->check_changes_orders();?>">
						<thead class="sticky-thead" >
								<th scope="col">Buyer</th>
								<th scope="col">Style No</th>
								<th scope="col">Order No</th>
								<th scope="col">Quantity (pcs)</th>
								<th scope="col">Shipment Date</th>
								<th scope="col">Status</th>
								<th scope="col">Remarks</th>
								<?php
								if($_SESSION["privillege"] == 2 || $_SESSION["privillege"] == 3){
									echo '<th scope="col"></th>';}
								?>
							</thead>
							<tbody>
								<?php echo $db->fetch_orders();?>
							</tbody>
						</table>
					<div class="table-footer"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
if($_SESSION["privillege"] == 2 || $_SESSION["privillege"] == 3){
if ($db->check_ref_permission() == 0) {
	$permission = "";
	$status = "on";
} else {
	$permission = " checked";
	$status = "off";
	echo '
	<script>
		$(document).ready(function(){
			$(".ref-icon i").removeClass("disabled");
			$("#ref-form").show();
			$("#ref-form").find("input[name=ref]").val($("#ref_code").val());
		});
	</script>';
}
echo '<script src="js/ref-code.js"></script>
	<script src="js/order-menu.js"></script>
	<script src="js/signup.js"></script>';

echo '
<!-- Signup Code -->
<div class="modal fade" id="signup_code">
	<div class="modal-dialog">
		<div class="modal-content modal-glass">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Sign up approval</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<!-- ORDER FORM -->
				<div class="d-flex flex-between">
					<div>
						<div class="flatCheckbox">
							<input id="ref_permission" type="checkbox" name="permission"'.$permission.'>
							<label for="ref_permission"></label>
							<div></div>
						</div>
						<div class="ref-btn-txt">Turn '.$status.' sign up</div>
					</div>
					<div>
						<input id="ref_code" type="text" name="code" class="form-code" value="'.$db->fetch_ref_code().'" placeholder="****" disabled>
							
						</span>
					</div>
					<div class="ref-icon">
								<span><i class="material-icons disabled" data-toggle="tooltip" data-placement="top" title="Generate new key" onclick="ref_code_new()">autorenew</i></span>
								<span><i id="copy-btn" class="material-icons disabled" data-toggle="tooltip" data-placement="top" title="Copy to clipboard" data-clipboard-target="#ref_code" onclick="toaster(\'Key Copied\')">content_copy</i></span>
					</div>
				</div>
			</div>
			<section id="ref-form" style="display: none">
				<h3>Sign up form</h3>
				<form method="POST" id="signupForm" action="php/user-signup.php">
					<div id="error-header-msg" class="error-msg"></div><br>
					<input type="text" name="name" class="form-control" placeholder="Full Name" minlength="3" required>
					<div id="error-username-msg" class="error-msg"></div><br>
					<input type="text" name="username" id="input-username" class="form-control" placeholder="Username" required><br>
					<input type="password" name="password" class="form-control" placeholder="Password" minlength="8" required>
					<div id="error-ref-msg" class="error-msg"></div><br>
					<input type="number" name="ref" class="form-control" placeholder="Reference Code" minlength="4" maxlength="4" required><br>

					<input type="radio" id="priv_local" name="privillege" value="1" checked><label for="priv_local">&nbsp; Local</label>
					<input type="radio" id="priv_admin" name="privillege" value="2"><label for="priv_admin">&nbsp; Admin</label><br>
					<input type="submit" class="btn btn-blue btn-signin" value="SIGN UP">
				</form>
			</section>
		</div>
	</div>
</div>
<!-- Add order modal -->
<div class="modal fade" id="add_order">
	<div class="modal-dialog">
		<div class="modal-content modal-glass">
			<!-- Modal header -->
			<div class="modal-header">
				<h4 class="modal-title">Add a new order</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<form id="order_form" method="POST" action="php/order-add.php" onsubmit="add_order(event)">
					<div class="form-group row ">
						<div class="col">
							<select id="selectBuyer" name="buyer_id" class="form-control" required>
								<option value="">choose a buyer</option>
								'.$db->fetch_buyer_name().'
							</select>
						</div>
						<div id="btn_add_buyer" class="col-auto">
							<div class="btn btn-primary btn-dark"  data-toggle="modal" data-target="#add_buyer">Add buyer</div>
						</div>
					</div>
					<div class="form-group">
						<label>Style Number</label>
						<input type="text" class="form-control" name="style_no" autocomplete="off">
					</div>
					<div class="form-group">
						<label>Order Number <span class="require">*</span></label>
						<input type="text" class="form-control" name="order_no" autocomplete="off" required>
					</div>
					<div class="row">
						<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<label>Quantity (Pcs) <span class="require">*</span></label>
							<input type="number" class="form-control" name="quantity" required placeholder="0" autocomplete="off">
							<small class="form-text text-muted">Only Numbers</small>
						</div>
						<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<label>Shipment Date <span class="require">*</span></label>
							<input type="text" class="form-control datepicker" name="shipment_date" autocomplete="off" required>
						</div>
						

					</div>
					<div class="form-group">
						<label>Status</label>
						<input type="text" class="form-control" name="status" autocomplete="off">
					</div>
					<div class="form-group">
						<label>Remarks</label>
						<input type="text" class="form-control" name="remarks" autocomplete="off">
					</div>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<a class="btn btn-lg btn-grey" onclick="javascript:clear_form()">Clear</a>
				<input type="submit" class="btn btn-lg btn-dark" value="Confirm">
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Remove order promt modal -->
<div class="modal fade" id="remove_form">
	<div class="modal-dialog">
		<div class="modal-content modal-glass">
			<!-- Modal body -->
			<div class="modal-body p-2 pb-4 text-center">
				<h5 class="modal-title pt-3">Are you sure you want to remove this order?</h5><br>
				<button class="btn btn-secondary btn-grey" data-dismiss="modal">Cancel</button>
				<span class="p-3"></span>
				<button id="remove_order" class="btn btn-primary btn-dark">Yes, I\'m sure</button>
			</div>
		</div>
	</div>
</div>
<!-- Edit order modal -->
<div class="modal fade" id="edit_order">
	<div class="modal-dialog">
		<div class="modal-content modal-glass">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Edit Order</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<!-- ORDER FORM -->
				<form id="edit_order_form" method="POST" action="php/edit-order.php" onsubmit="javascript:edit_order(event)"></form>
			</div>
		</div>
	</div>
</div>
<!-- Add Buyer -->
<div class="modal fade" id="add_buyer">
	<div class="modal-dialog">
		<div class="modal-content modal-glass">
			<!-- Modal body -->
			<form method="POSt" action="php/buyer-add.php">
				<div class="modal-body p-4 text-center row">
					<div class="col">
					<input type="text" name="buyer_name" class="form-control" placeholder="Enter buyer name">
					</div>
					<div class="col-auto">
					<input type="submit" class="btn btn-dark" value="Add" autocomplete="off">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Right Click Menu -->
<div class="hide" id="rmenu">
    <div id="redirect_item_rclick">Enter</div>
    <div id="order_checkout_rclick">Check</div>
    <div data-toggle="modal" data-target="#edit_order">Edit</div>
    <div data-toggle="modal" data-target="#remove_form">Remove</div>
</div>';}?>
<div class="footer-txt">Version 4</div>
<script type="text/javascript">
/* AJAX request to checker */
function check(){
	$.ajax({
		type: 'POST',
		url: 'php/order-check.php',
		dataType: 'json',
		data: {
			counter: $('#table-order').data('counter')
		},
		success: function(response){
			$('#table-order').data('counter', response.current);
			if (response.update == true){
				$('#table-order tbody').html(response.data);
				set_background();
				search();
				order_menu();
			}
		}
	});
}
setInterval(check, 10000);
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("body").on( "click", ".clickable-row", function(){
		$(this).addClass("anim-click");
	});
	$("body").on( "dblclick", ".clickable-row", function(){
		$id = $(this).data("id");
		window.location = "item.php?order_id="+$id+"";
	});
});
</script>
<script type="text/javascript">
function toaster(txt){
	check();
	$("#toast-msg").hide();
	$("#toast-msg").text(txt).show().delay(800).fadeOut(400);
}
</script>
<div id="toast-msg" class="toast"></div>
<script type="text/javascript">
		setInterval(function() {
		    var date = new Date();
		    var h = ("0" + date.getHours()).slice(-2);
		    var m = ("0" + date.getMinutes()).slice(-2);
		    $('#clock').html(
		        h + ":" + m);
		}, 500);
		setInterval(function() {
			var oi = document.getElementById("oi");
			if(navigator.onLine) {
				oi.style.color = "#58ef5b";
				oi.innerText = "online";
			}
			else{
				oi.style.color = "#f45a5a";
				oi.innerText = "offline";
			}
		}, 1200);
</script>
<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>
<div class="footer-txt"></div>
</body>
</html>