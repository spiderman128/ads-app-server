<?php 
session_start();
require_once('includes/init.php');

if (!isset($_SESSION['token'])) {
	header('location: login-required.php');
}

$token = $_SESSION['token'];

$user_data = get_user_by_token($conn, $token);

if ( empty( $user_data ) ) header('location: login-required.php');

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/style.css" >
  <style>
	<?php include 'css/custom-style.php' ?>
	.list-group{
	    text-align: left;
	}
  </style>
</head>
<body class="bg-primary">  
<section class="topbar">
   <br><br><br><br><br><br>
</section>
<div class="notice-bg">
<div class="notice-block">
	 <div class="user-block">
               <div class="icon">
                   <img src="https://invisiblelab.xyz/images/user.png" height="100px" width="100px"/>
               </div>
               <div class="userinfo"><br>
                   <h4> <?= $user_data['fname'] ?? '' ;?></h4>
                   <h4> <?= $user_data['mobile'] ?? '' ;?></h4>
               </div>
     </div>
	<div class="list-group">
    <a href="#" class="list-group-item disabled">Balance: <?= $user_data['balance'] ?? '' ;?></a>
    <a href="#" class="list-group-item disabled">Mobile: <?= $user_data['mobile'] ?? '' ;?></a>
    <a href="#" class="list-group-item disabled">User id: <?= $user_data['id'] ?? '' ;?></a>
    <a href="#" class="list-group-item disabled">Invalid Click: <?= $user_data['i_click'] ?? '' ;?></a>
    <a href="#" class="list-group-item disabled">Refer Code: <?= $user_data['mobile'] ?? '' ;?></a>
    <a href="#" class="list-group-item disabled">Total Refer: <?= $user_data['t_ref'] ?? '' ;?></a>
    <?php if( $spin == 1 ) : ?>
    <a href="#" class="list-group-item disabled">Today Spin: <?php if($multi_task == 1){ 
        $task = $user_data['today_spin1']+$user_data['today_spin2']+$user_data['today_spin4']+$user_data['today_spin4'];
} else { $task = $user_data['today_spin'];} echo $task ?? '0' ;?></a>
    <?php endif ?>
    <?php if( $task == 1 ) : ?>
    <a href="#" class="list-group-item disabled">Today Task: <?php if($multi_task == 1){ 
        $task = $user_data['today_task1']+$user_data['today_task2']+$user_data['today_task3']+$user_data['today_task4'];
} else { $task = $user_data['today_task'];} echo $task ?? '0' ;?></a>
<?php endif ?>
    <a href="#" class="list-group-item disabled">Registration Date: <?= $user_data['reg_time'] ?? '' ;?></a>
  </div>
	
	
	
	
	
	
	<!--
	
	<section class="profile-wrapper">
		
		<div class="user-info">
			<h2 class="masque"><?= $user_data['fname'] ?></h2>
			<strong><?= $user_data['mobile'] ?></strong>
		</div>
		
		<div id="userData">
		
		<table class="user-data">
			<tr>
				<td>Balance<p><?= $user_data['balance'] ?></p>
				<td rowspan="2" class="divider"><p></p></td>
				<td>Invalid Click<p><?= $user_data['i_click'] ?></p></td>
			</tr>
			<tr>
				<td>Total Refer<p><?= $user_data['t_ref'] ?></p>
				<td>Refer Code<p><?= $user_data['mobile'] ?></p></td>
			</tr>
		</table>
		
		<div class="task-count">
			<p>Today Task<br/><?= $user_data['today_task'] ?></p>
		</div>
		
		</div>
	</section>-->
	</div></div>
	<?php include 'developer.php'; ?>
</body>
</html>