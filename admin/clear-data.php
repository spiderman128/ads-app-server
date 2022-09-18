<?php
session_start();

require_once('functions.php');
require_once('dbconnection.php');
require_once('includes/init.php');

$password = $_SESSION['password'];
$admin_data = get_admin($conn, $password);
if ($password != $admin_data['password']) {
	header('location: login.php');
}
if ( !isset($_SESSION['password']) ) {
	header('location: login.php');
}
if ( empty( $admin_data ) ) header('location: login.php');

$pageTitle = 'Clear Data';

if(isset($_GET['confirm'])) {
	$sql1 = "DELETE FROM users WHERE NOT mobile='1234'";
	$sql2 = "DELETE FROM payments";

	if ($conn->query($sql1) == TRUE && $conn->query($sql2) === TRUE) {
       
     header('location : index.php');
        
    }else {
    	snack ("error", "Failed");
    	echo $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Clear Data - Admin Dashboard</title>
		<meta name="theme-color" content="#f9fbfd">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link defer rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		<style>
			main {
				padding: 1em;
			}
			.action-box {
				max-width: 420px;
				margin: auto;
				padding: 1em;
				background: #FFF;
				color: #020202;
			}
		</style>
	</head>
	<body class="bg-gray-200">
		<?php include("header.php") ?>
				<main>
			<section class="fr-container fr-lg">
				<div class="col-sm bg-danger col-white py-3">
					<h2>Read Carefully</h2>
					<hr/>
					<p>Clearing database will delete the following data :</p>
					<p>• All users data</p>
					<p>• All payment records</p>
				</div>
				<div class="alert alert-warning" role="alert">
					This action cannot be undone.
				</div>
				<form action="" class="m-0 pb-1" method="GET">
					<div class="custom-control custom-checkbox my-1 mr-sm-2">
    					<input type="checkbox" class="custom-control-input" id="customControlInline" required>
    					<label class="custom-control-label" for="customControlInline">Check this box to confirm your action.</label>
 	 			  </div>
					<button name="confirm" type="submit" class="btn btn-danger btn-block btn-lg mt-3">Clear Data</button>
				</form>
			</section>
		</main>
		<?php include('footer.php') ?>
	</body>
</html>