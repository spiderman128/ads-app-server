<?php
session_start();
require_once('includes/init.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login Required!</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
		<link rel="stylesheet" href="css/style.css" >
		<style>
			<?php include 'css/custom-style.php' ?>

			p, .notify {
				background: #FFF !important;
				color: #888 !important;
			}
		</style>
	</head>
	<body class="bg-primary">
		<p class="notify masque">Login Required</p>
		<script>Android.errorAlert("Login Required!", false)</script>
	</body>
</html>