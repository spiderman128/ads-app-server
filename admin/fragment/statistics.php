<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('dbconnection.php');
require_once( __DIR__ . '/../includes/init.php');

$sql = "SELECT
		( SELECT COUNT(1) FROM users WHERE id > 1) AS total_user,
		( SELECT COUNT(1) FROM users WHERE id > 1 AND i_click > $invalid_limit ) AS blocked_user,
		( SELECT SUM(balance) FROM users WHERE id > 1) AS total_balance,
		( SELECT COUNT(1) FROM payments ) AS payment_count,
		( SELECT COUNT(1) FROM payments WHERE status = 'Paid' ) AS paid_count,
		( SELECT COUNT(1) FROM payments WHERE status = 'Pending' ) AS pending_count,
		( SELECT SUM(amount) FROM payments WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(i_click) FROM users WHERE id > 1) AS invalid,
		( SELECT SUM(today_task) FROM users WHERE id > 1) AS task,
		( SELECT SUM(today_task1) FROM users WHERE id > 1) AS t1,
		( SELECT SUM(today_task2) FROM users WHERE id > 1) AS t2,
		( SELECT SUM(today_task3) FROM users WHERE id > 1) AS t3,
		( SELECT SUM(today_task4) FROM users WHERE id > 1) AS t4,
		( SELECT SUM(amount) FROM payments WHERE status = 'Pending') AS pending_amount
		FROM dual";

$result = $conn -> query($sql);
$data = $result -> fetch_assoc();

$data_file = "./app-data.json";
$success = false ;

$app_data = json_decode(file_get_contents($data_file), true);

foreach( $app_data as $key => $val ) {
	$$key = $val;
}


?>
<div class="container-fluid pt-3">
	<div class="block-header px-md-2">
		<h2><i>insights</i> Statistics</h2>
	</div>
	
	<div class="row clearfix px-md-2">
		
		<div class="col col-md-6">
			<div class="info-box bg-light-green hover-expand-effect">
				<div class="icon">
					<i class="material-icons">people</i>
				</div>
				<div class="content">
					<div class="text">Total User</div>
					<div class="number count-to"><?= $data['total_user'] ?? '0' ?></div>
				</div>
			</div>
		</div>
		<div class="col col-md-6">
			<div class="info-box bg-red hover-expand-effect">
				<div class="icon">
					<i class="material-icons">people</i>
				</div>
				<div class="content">
					<div class="text">Blocked User</div>
					<div class="number count-to"><?= $data['blocked_user'] ?? '0' ?></div>
				</div>
			</div>
		</div>
		<div class="col col-md-6">
			<div class="info-box hover-expand-effect" style="background: #B833FF !important;
	color: #fff !important;">
				<div class="icon" style="color: #fff !important;">
					<i class="material-icons">work_outline</i>
				</div>
				<div class="content" style="color: #fff !important;">
					<div class="text" style="color: #fff !important;">Today Task</div>
					<div class="number count-to" style="color: #fff !important;"><?php if ( $multi_task == 1) {
                      $multi_click = $data['t1']+$data['t2']+$data['t3']+$data['t4'];
                     } else { 
                     $multi_click = $data['task'];
                        } echo $multi_click ?? '0'?></div>
					
				</div>
				</div>
		</div>
		<div class="col col-md-6">
			<div class="info-box hover-expand-effect" style="background: #7A33FF !important; color: #fff !important;">
				<div class="icon" style="color: #fff !important;">
					<i class="material-icons">payments</i>
				</div>
				<div class="content" style="color: #fff !important;">
					<div class="text" style="color: #fff !important;"> Today Points: <?= $multi_click*$task_reward ?? '0' ?></div>
					<div class="number count-to" style="color: #fff !important;">
					    <?php $datatk = $multi_click*$task_reward; echo $datatk / $statistics_point_rate; ?> BDT
					</div>
				</div>
			</div>
		</div>
		
		<div class="col col-md-6">
			<div class="info-box bg-light-blue hover-expand-effect">
				<div class="icon">
					<i class="material-icons">payments</i>
				</div>
				 <div class="content">
                        <div class="text">Balance: <?= $data['total_balance'] ?? '0' ?></div>
                        <div class="number"><?php $datatk = $data['total_balance']; echo $datatk / $statistics_point_rate; ?> BDT
                        </div>
                </div>
			</div>
		</div>
		<div class="col col-md-6">
		    
		    

<div class="info-box bg-teal hover-expand-effect">
<div class="icon">
<i class="material-icons">payments</i>
</div>
<div class="content">
<div class="text">Payments</div>
<div class="number count-to"><?= $data['payment_count'] ?? '0' ?></div>
</div>
<div class="content">
<div class="text">Pending</div>
<div class="number count-to"><?= $data['pending_count'] ?? '0' ?></div>
</div>
<div class="content">
<div class="text">Paid</div>
<div class="number count-to"><?= $data['paid_count'] ?? '0' ?></div>
</div>
</div>
</div>

		<div class="col col-md-6">
			<div class="info-box bg-green hover-expand-effect">
				<div class="icon">
					<i class="material-icons">payments</i>
				</div>
				<div class="content">
                        <div class="text">Paid: <?= $data['paid_amount'] ?? '0' ?></div>
                        <div class="number"><?php $datatk = $data['paid_amount']; echo $datatk / $statistics_point_rate; ?> BDT
                        </div>
                </div>
			</div>
		</div>
		<div class="col col-md-6">
			<div class="info-box bg-orange hover-expand-effect">
				<div class="icon">
					<i class="material-icons">payments</i>
				</div>
				<div class="content">
                        <div class="text">Pending: <?= $data['pending_amount'] ?? '0' ?></div>
                        <div class="number"><?php $datatk = $data['pending_amount']; echo $datatk / $statistics_point_rate; ?> BDT
                        </div>
                </div>
			</div>
		</div>
		
	</div>
</div>