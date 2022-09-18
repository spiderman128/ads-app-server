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

$pageTitle = "Payments";


if (isset($_GET['delete_all']))
{
    
$sql = "DELETE FROM payments";



if ($conn->query($sql) === TRUE) {
  snack ("success", "Success");
  $sql = "ALTER TABLE payments AUTO_INCREMENT = 1";
}

}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM payments WHERE id = $id";
	$result = $conn -> query($sql);
    if ($result === TRUE) {
		snack ("success", "Success");
    } else {
    	snack ("error", "Failed");
    	echo $conn->error;
    }
}

$list = 'all';

$sql = "SELECT * FROM payments ORDER BY date DESC";

if (isset($_GET['list'])) {
	$list = $_GET['list'];
	$pageTitle = $pageTitle . ' - ' . $list;
	$sql = "SELECT * FROM payments WHERE status='$list' ORDER BY date DESC";
}

$data = mysqli_query($conn, $sql);

$rows = [];
while($row = mysqli_fetch_array($data))
{
    $rows[] = $row;
}

$index = 1 ;

$sql2 = "SELECT
		( SELECT COUNT(1) FROM payments) AS payment_count,
		( SELECT SUM(amount) FROM payments WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM payments WHERE status = 'Pending') AS pending_amount
		FROM dual";
if (isset($_GET['list'])) {
	$list = $_GET['list'];
	$sql2 = "SELECT
		( SELECT COUNT(1) FROM payments WHERE status = '$list') AS payment_count,
		( SELECT SUM(amount) FROM payments WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM payments WHERE status = 'Pending') AS pending_amount
		FROM dual";
}		
$result2 = $conn -> query($sql2);
$data2 = $result2 -> fetch_assoc();






?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageTitle ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style>
			*, .select {
				user-select: text !important;
			}
			main {
				overflow: auto;
				padding: 1em;
			}
			table {
				white-space: nowrap;
			}
			tbody > tr:nth-child(even) {
				background: #F8F8F8;
			}
			.Paid {
				color: green;
			}
			.Pending {
				color: red;
			}
		</style>
	</head>
	<body class="bg-gray-200">
		<?php include("header.php") ?>
		<main>
			<section class="fr-container fr-lg">
									<section class="table-wrapper">
						<table class="table table-divo">
							<thead><tr>
								<th><i class="material-icons" style="vertical-align: -3px">insights</i> <?= $data2['payment_count'] ?? '0' ?></th>
					<th scope="col">Date</th>
					<th scope="col">Mobile/Email</th>
					<th scope="col">Amount</th>
					<th scope="col">Method</th>
					<th scope="col">Status</th>
					<th scope="col">Action</th>
				</tr></thead>
				<tbody>
				<?php foreach ($rows as $row) : ?>
				<tr>
					<td><?php echo $index ?></td>
					<td><?php echo date("d F y @ H:i", strtotime($row['date']) + 10*3600 ) ?></td>
					<td><?php echo $row['number'] ?></td>
					<td><?php echo $row['amount'] ?></td>
					<td><?php echo $row['method'] ?></td>
					<td class="<?php echo $row['status'] ?>"><?php echo $row['status'] ?></td>
					<td class="">
						<a href="payments.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-block"><span class="material-icons">delete</span></a>
					</td>
				</tr>
				<?php $index++ ?>
				<?php endforeach ?>
				</tbody>
			</table>
		</main>
		
<a onclick="delete_all()" class="fab bg-primary material-icons" style="color: #ffffff; cursor: pointer">delete</a>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<script>
		function delete_all() {
		    
  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.replace("?delete_all");
  }
})

}
		</script>
		
		<?php if (isset($_GET['success'])) : ?>
			<p class="snackbar success">Success</p>
		<?php endif ?>
		<?php include('footer.php') ?>
	
	</body>
</html>
	