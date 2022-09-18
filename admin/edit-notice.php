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

$pageTitle = 'Edit Notice';

$data_file = "app-data.json";

if ( isset($_POST['submit']) ) {
	$data = json_decode(file_get_contents($data_file), true) ?? array();
	$data = array_merge($data, $_POST);
	file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
	snack ("success", "Success");
}

$app_data = json_decode(file_get_contents($data_file), true);

foreach( $app_data as $key => $val ) {
	$$key = $val;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin Panel</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body class="bg-gray-200">
		<?php include 'header.php' ?>
		<main class="container">
			<section class="fr-container fr-lg pb-0">
				<section>
					<form data-submit="true" id="form" class="mb-1" action="" autocomplete="off" method="POST">
					    <div class="form-group">
						<h4 class="py-2"><i>notifications</i>Important Notice</h4>
						
					    <textarea rows=8 name="important_notice" class="form-control"><?= $important_notice ?? '' ?></textarea>
						</div>
					    <div class="form-group">
						<h4 class="py-2"><i>home</i>Home Notice</h4>
						
					    <textarea rows=8 name="home_notice" class="form-control"><?= $home_notice ?? '' ?></textarea>
						</div>
						<div class="form-group">
						<h4 class="py-2"><i>payments</i>Wallet Notice</h4>
							<textarea rows=8 name="wallet_notice" class="form-control"><?= $wallet_notice ?? '' ?></textarea>
						</div>
						<button id="btn-form-submit" name="submit" value="1" type="submit" class="fab bg-primary material-icons border-0 d-nonex">check</button>
					</form>
			</section></section>
		</main>
		
		<div id="ajax-div"></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>