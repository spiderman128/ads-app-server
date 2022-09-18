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

$pageTitle = 'Blocked Users';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sql = "UPDATE users SET i_click = 0 WHERE id = $id";
	
	if ($conn -> query($sql) === TRUE) {
		//snack ("success", "Success");
		header('location: blocked-users.php?success');
	}
	
}

$sql = "SELECT * FROM users WHERE i_click > $invalid_limit ORDER BY id ASC";
$data = mysqli_query($conn, $sql);

$index = 1;

$sql2 = "SELECT
		( SELECT COUNT(1) FROM users WHERE i_click > $invalid_limit) AS payment_count,
		( SELECT SUM(amount) FROM payments WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM payments WHERE status = 'Pending') AS pending_amount
		FROM dual";
		
$result2 = $conn -> query($sql2);
$data2 = $result2 -> fetch_assoc();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Blocked Users</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style>
			.main {
				padding: 1em;
			}
			.select {
				user-select: all;
			}
			th, td {
				overflow: hidden;
				white-space:nowrap;
			}
			tbody > tr:nth-child(even) {
				background: #F8F8F8;
			}
		</style>
	</head>
	<body class="bg-gray-200">
		<?php include("header.php") ?>
	<main>
			<section class="fr-container fr-xl table-fr-wrapper">
				<div class="table-wrapper">
					    
						<table class="table table-divo">
						<thead><tr>
							<th scope="col"><i class="material-icons" style="vertical-align: -3px">insights</i> <?= $data2['payment_count'] ?? '0' ?></th>
					<th scope="col">Mobile</th>
					<th scope="col">Balance</th>
					<th scope="col">Invalid Clicks</th>
					<th scope="col">Action</th>
				</tr></thead>
				<tbody>
					<?php
					if (mysqli_num_rows($data) > 0) {
						while($row = mysqli_fetch_assoc($data)) {
							echo "<tr><td>{$index}</td><td>{$row['mobile']}</td><td>{$row['balance']}</td><td>{$row['i_click']}</td><td><a href='user-profile.php?mobile={$row['mobile']}' class='btn btn-primary'><span class='material-icons'>person</span></a><a href='?id={$row['id']}' class='btn btn-success'><span class='material-icons'>check</span></a></td></tr>\n";
							$index++;
						}
					} else {
					}
					?>
				</tbody>
			</table>
		</main>
		<?php if (isset($_GET['success'])) : ?>
			<p class="snackbar success">Success</p>
		<?php endif ?>
		<?php include('footer.php') ?>
	</body>
</html>
	