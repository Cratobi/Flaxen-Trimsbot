<!DOCTYPE html>
<html>
<head>
	<title>Install</title>
	<!-- jQuery library 3.2.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script type="text/javascript">
	function posting(event, value) {
		event.preventDefault();
		$val = value;
		$url = "backend.php";

		$posting = $.post($url, {
			cmd: $val
		});

		$posting.done(function(data) {
			$("#console .txt").append(data);
		});
	};
	</script>
	<style type="text/css">
		.btn{
			display: inline-block;
			background-color: #222;
			border: 2px solid #000000;
			padding: 5px 10px;
			border-radius: 3px;
			color: #FFFFFF;
		}
		.container{
			text-align: center;
			padding: 10px;
		}
		#console{
			font-family: Courier;
			background-color: #EEEEEE;
			color: #222222;
			margin: 20px auto;
			padding: 20px;
			width: 50%;
			height: 300px;
			border-radius: 5px;
			overflow-y: scroll;
		}
		.txt{
			font-size: 12px;
			margin-top: 5px;
		}
		.header{
			width: 50%;
			background-color: #EEEEEE;
			padding: 20px 0;
			margin-top: -20px;
			margin-left: -5px;
			border-bottom: 1px solid #999;
			position: fixed;
		}
	</style>
</head>
<body>
	<div class="container">
		<button class="btn" onclick="javascript:posting(event, 1)">Update Database</button>
		<!-- <button class="btn" onclick="javascript:posting(event, 2)">Mock Data</button> -->
		<!-- <button class="btn" onclick="javascript:posting(event, 3)">Reset</button> -->
	</div>
		<div id="console">
		<span class="header">console_</span><br><br>
		<div class="txt"></div>
		</div>
</body>
</html>