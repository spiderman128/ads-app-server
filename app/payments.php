<?php 
session_start();
require_once('includes/init.php');

if ( !isset($_SESSION['token']) ) {
	header('location: login-required.php');
}

$token = $_SESSION['token'];

$mobile = get_user_by_token($conn, $token)['mobile'];

$records = get_payment_records( $conn, $mobile, $_GET['status'] );

?>
<!DOCTYPE html>
<html>
<head>
	<title>Payments</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=false">
    <link rel="stylesheet" href="css/style.css" >
    <style>
		<?php include 'css/custom-style.php' ?>
	</style>
</head>
<body class="bg-primary">  
<section class="topbar">
   <br><br><br><br><br><br>
</section>
<div class="notice-bg">
<div class="notice-block">
	<section class="payments">
		
		<?php if ( $payment_nav == 1 ) : ?>
			
			<div align="center" class="cul bg-main">
				<a href="?self">History</a>
				<a href="?status=Pending">Pending</a>
				<a href="?status=Paid">Paid</a>
			</div>
		<br />
		
		<?php endif ?>
		
		<?php if ( count($records) == 0 ) : ?>
			
			<center>
				<p class="message kalpurush gray">No records found.</p>
			</center>
			
		<?php else : ?>
		
			<div style="overflow-x:auto">
				<table class="payments-table">
				
					<tr class="table-head bg-primary" style="color : black">
						<th>Date</th>
						<th>Mobile</th>
						<th>Amount</th>
						<th>Method</th>
						<th>Status</th>
					</tr>
					
					<!-- Payment Records -->
						
					<?php foreach ($records as $record) : ?>
						
						<tr>
							<td><?= preg_replace( '/-/', '/', $record['date']) ?></td>
							<td><?= isset($_GET['status']) ? substr( $record['number'], 0, 8 ) . '***' : $record['number'] ?></td>
							<td><?= $record['amount'] ?></td>
							<td><?= $record['method'] ?></td>
							<td class="<?= $record['status'] ?>"><?= $record['status'] ?></td>
						</tr>
						
					<?php endforeach ?>
					
			</table>
		</div>
		
		
		<?php endif ?>
		
		
	</section></div></div>
	<?php include 'developer.php'; ?>
</body>
</html>