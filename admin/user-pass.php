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

$pageTitle = 'Update User Pass';

if (isset($_POST['update_pass'])) {
	$mobile = $_POST['mobile'];
	$pwd = md5($_POST['pwd']);
	$sql = "UPDATE users SET password = '$pwd' WHERE mobile = '$mobile'";
	$result = $conn -> query($sql);
	
	if ($result === TRUE) {
		snack ("success", "Success");
    } else {
    	snack ("error", "Failed");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User Password - Admin Dashboard</title>
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
		    


		    
			<section class="fr-container fr-sm pb-0">
				<div class="col-sm">
					<form action="" autocomplete="off" method="POST">
						<h4 class="py-2">Update User Password</h4>
						<div class="form-group">
							<label>User Mobile</label>
							<input name="mobile" type="number" class="form-control" required value="<?php if (isset($_GET['user'])) {
							    echo $_GET['user'];
							} ?>">
						</div>
						<div class="form-group">
							<label>New Password</label>
							<input name="pwd" type="text" autocorrect="off" autocapitalize="none" class="form-control" required>
						</div>
						<div class="form-group">
							<button type="submit" name="update_pass" class="btn btn-primary btn-block material-icons py-1" style="font-size: 22px">check</button>
						</div>
					</form>
				</div>
			</section>
		</main>
		<?php include('footer.php') ?>
	</body>
</html>