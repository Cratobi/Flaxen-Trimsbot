<?php require('php/common.php'); session_start();
if(!empty($_SESSION["username"]) && !empty($_SESSION["privillege"])){
	header('Location: index.php');
	exit();
}
?>
<!doctype html>
<html>
<head>
	<title>Sign up - Trimsbot</title>
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
	<!-- Signup JS -->
	<script src="js/signup.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".se-pre-con").delay(1000).fadeOut(1000);
		});
	</script>
	<script src="js/wallpaper.js"></script>
	?>
</head>
<body>
<div class="se-pre-con"></div>
<section class="container signin-container">
	<div class="signin-form">
		<a href="index.php">Go back</a><br>
		<h6>Trimsbot</h6>
		<h3>Sign up</h3>
		<form method="POST" id="signupForm" action="php/user-signup.php">
			<div id="error-header-msg" class="error-msg"></div><br>
			<input type="text" name="name" class="form-control" placeholder="Full Name" minlength="3" required>
			<div id="error-username-msg" class="error-msg"></div><br>
			<input type="text" name="username" id="input-username" class="form-control" placeholder="Username" required><br>
			<input type="password" name="password" class="form-control" placeholder="Password" minlength="8" required>
			<div id="error-ref-msg" class="error-msg"></div><br>
			<input type="number" name="ref" class="form-control" placeholder="Reference Code" minlength="4" maxlength="4" required><br>
			<input type="checkbox" name="privillege" value="1" checked disabled>&nbsp; Local account
			<input type="submit" class="btn btn-blue btn-signin" value="SIGN UP"><br><br>
			<a href="signin.php" class="float-right mr-2">or Sign in</a>
		</form>
	</div>
</section>
<div class="footer-txt"></div>
</body>
</html>