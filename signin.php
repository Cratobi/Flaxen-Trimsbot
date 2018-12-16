<?php require('php/common.php'); session_start();
if(!empty($_SESSION["username"]) && !empty($_SESSION["privillege"])){
	header('Location: index.php');
	exit();
}
?>
<!doctype html>
<html	>
<head>
	<title>Sign in - Trimsbot</title>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(".se-pre-con").delay(4000).fadeOut(1000);
		});
	</script>
	<script src="js/wallpaper.js"></script>
</head>
<body>
<div class="se-pre-con"></div>
<div class="container signin-container">
	<div class="signin-form">
		<h6>Trimsbot</h6>
		<h3>Sign in</h3><br><br>
		<div id="error-msg"></div>
		<br>
		<form method="POST" id="signinForm" action="php/user-signin.php">
			<input type="text" name="username" class="form-control" placeholder="Username" required="required"><br>
			<input type="password" name="password" class="form-control" placeholder="Password" required="required"><br>
			<a href="#" onclick="javascript:alert('Contact the admin')">Forgot Password</a>
			<span> | </span>
			<a href="signup.php">Register</a>
			<input type="submit" class="btn btn-blue btn-signin" value="SIGN IN"><br>
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$form = $("#signinForm");
	$form.submit(function(event){
		event.preventDefault();	// Prevent form submission
		$.ajax({
			type: 'POST',
			url: $form.attr('action'),
			dataType: 'json',
			data: {
				username: $form.find('input[name="username"]').val(),
				password: $form.find('input[name="password"]').val()
			},
			success: function(response){
				if (response.update == false){
					if (response.state == 0){
						$form.find('input[name="username"]').addClass("txt-error").focus();
						$form.find('input[name="password"]').val('');
						$("#error-msg").text(response.status);
					}
					else if(response.state == 1){
						$form.find('input[name="password"]').val('').focus();
						$("#error-msg").text(response.status);
					}
				}
				else{
					window.location.href="index.php";
					$('#error-msg').text('');
				}
			}
		});
	});
});
</script>
<div class="footer-txt"></div>
</body>
</html>