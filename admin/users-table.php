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

$pageTitle = 'Users Table';

if (isset($_GET['block'])) {
	$id = $_GET['id'];
	$sql = "UPDATE users SET i_click = $invalid_limit + 1 WHERE id = $id";
	if ($conn -> query($sql) === TRUE) {
		snack ("success", "Success");
	}
}

if (isset($_GET['unblock'])) {
	$id = $_GET['id'];
	$sql = "UPDATE users SET i_click = 0 WHERE id = $id";
	if ($conn -> query($sql) === TRUE) {
		snack ("success", "Success");
	}
}

$sql = "SELECT * FROM users WHERE NOT (mobile = '1234') ORDER BY id ASC";
$data = mysqli_query($conn, $sql);
$rows = [];
while($row = mysqli_fetch_array($data))
{
    $rows[] = $row;
}
$index = 1;
$sql2 = "SELECT
		( SELECT COUNT(1) FROM users WHERE id > 1) AS payment_count,
		( SELECT SUM(amount) FROM payments WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM payments WHERE status = 'Pending') AS pending_amount
		FROM dual";
		
$result2 = $conn -> query($sql2);
$data2 = $result2 -> fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Users Table</title>
		<meta name="theme-color" content="#f9fbfd">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link defer rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style>
			main {
				padding: 1em;
			}
			.table > tbody > tr > td {
				vertical-align: middle;
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
							<th>Name</th>
							<th>Mobile</th>
							<th>Balance</th>
							<th>Referral</th>
							<th>Invalid Click</th>
							<th>Task</th>
							<th>Action</th>
						</tr></thead>
				<tbody>
				<?php foreach ($rows as $row) : ?>
				<tr>
					<td><?= $index ?></td>
					<td><?= $row['fname'] ?></td>
					<td class="align-middle"><?= $row['mobile'] ?></td>
					<td><?= $row['balance'] ?></td>
					<td><?= $row['t_ref'] ?></td>
					<td><?= $row['i_click'] ?></td>	
					<td><?php if ( $multi_task == 1) {
                      $multi_click = $row['today_task1']+$row['today_task2']+$row['today_task3']+$row['today_task4'];
                     } else { 
                     $multi_click = $row['today_task'];
                        } echo $multi_click ?></td>
					<td>
						<a href="user-profile.php?mobile=<?= $row['mobile'] ?>" class="btn btn-primary"><span class="material-icons">person</span></a>
					
						<?php if ( $row['i_click'] <= $invalid_limit ) : ?>
							<a href="?block&id=<?= $row['id'] ?>" class="btn btn-danger"><span class="material-icons">block</span></a>
						<?php else : ?>
							<a href="?unblock&id=<?= $row['id'] ?>" class="btn btn-success"><span class="material-icons">check</span></a>
						<?php endif ?>
					</td>
				</tr>
				<?php $index++ ?>
				<?php endforeach ?>
				</tbody>
    		</table>
    		</div>
    <section/>
		</main><?php include('footer.php') ?>
		
	</body>
</html>