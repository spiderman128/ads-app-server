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

$pageTitle = 'User Profile';

if (isset($_POST['id'])) {
	
	$id = $_POST['id'];
	$did = $_POST['did'];
	$pending = $_POST['pending'];
	$fname = $_POST['fname'];
	$balance = $_POST['balance'];
	$i_click = $_POST['i_click'];
	$today_task = $_POST['today_task'];
	
	if($spin == 1){
	    $bp = 'today_spin';
	}
	else{
	     $bp = 'today_task';
	}
	
	$sql = "UPDATE users SET fname = '$fname', balance = $balance, i_click = $i_click, $bp = $today_task, did = '$did', pending = '$pending' WHERE id = $id";
	$result = $conn ->query($sql);
	
	if ($result === TRUE) {
		snack ("success", "Success");
    } else {
    	snack ("error", "Failed");
    	echo $conn->error;
    }
}

if ( isset($_GET['delete']) ) {
	$id = $_GET['delete'];
	$sql = "DELETE FROM users WHERE id = $id";
	$result = $conn -> query($sql);
	
	if ($result === TRUE) {
		snack ("success", "Success");
    } else {
    	snack ("error", "Failed");
    	echo $conn->error;
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
				<div class="mb-1">
				<?php if (isset($_GET['mobile'])) : ?>
					<!-- Profile Update Form -->
					<?php
					$mobile = $_GET['mobile'];
					$sql = "SELECT * FROM users WHERE mobile = '$mobile'";
					$res = $conn->query($sql);
					?>
					<?php if (mysqli_num_rows($res) == 1) : ?>
						<?php while ($user = mysqli_fetch_assoc($res)) : ?>
							<form class="mb-3" method="POST">
								<h4 class="py-2">Profile : <?= $user['mobile'] ?></h4>
								<div class="form-group">
									<label>Name</label>
									<input name="fname" value="<?= $user['fname'] ?>" type="text" class="form-control" required>
								</div>
								<div class="form-row mb-3">
									<div class="col">
									<label>Balance</label>
									<input name="balance" value="<?= $user['balance'] ?>" type="number" class="form-control" required>
								</div>
								<div class="col">
									<label>Invalid Click</label>
									<input name="i_click" value="<?= $user['i_click'] ?>" type="number" class="form-control" required>
								</div>
								</div>
								<div class="form-row mb-3">
								     <?php if( $spin == 1 ) : ?>
									<div class="col">
									<label>Today Spin</label>
									<input name="today_task" value="<?= $user['today_spin'] ?>" type="number" class="form-control" required>
								</div>
								<?php else : ?>
								<div class="col">
									<label>Today Task</label>
									<input name="today_task" value="<?= $user['today_task'] ?>" type="number" class="form-control" required>
								</div>
								<?php endif ?>
								<div class="col">
									<label>Device ID</label>
									<input name="did" value="<?= $user['did'] ?>" type="text" class="form-control" required>
								</div>
								</div>
								
							<div class="form-row px-1">
									<div class="col">
										<label>Pending</label>
									<input name="pending" value="<?= $user['pending'] ?>" type="text" class="form-control" readonly required>
									</div>
									<div class="col">
									    <br>
										<button name="id" value="<?= $user['id'] ?>" type="submit" class="btn btn-primary btn-block material-icons py-1" style="font-size: 22px">check</button>
									</div>
								</div>
								<hr/>
								<div class="row px-3">
									<a href="user-pass.php?user=<?= $user['mobile'] ?>" class="btn btn-info col mr-2"><i>security</i>Password</a>
									<a href="?delete=<?= $user['id'] ?>" class="btn btn-danger col" onclick="return confirm('Are you sure?')"><i>delete</i>Delete User</a>
								</div>
							</form>
						<?php endwhile ?>
					<?php else : ?>
						<div class="alert alert-danger" role="alert">
							User not found
						</div>
						<form action="" method="GET">
							<h4 class="py-2">Enter correct mobile</h4>
							<div class="form-group">
								<label>User Mobile</label>
								<input name="mobile" value="<?= @$_GET['mobile'] ?>" type="number" class="form-control" required>
							</div>
							<div class="form-group text-right">
								<button type="submit" class="btn btn-success"><i>search</i>Search User</button>
							</div>
							
						</form>
					<?php endif ?>
				<?php else : ?>
				
					<!-- Search Form -->
					<form action="" method="GET">
						<h4 class="py-2">Search Profile</h4>
						<div class="form-group">
							<label>User Mobile</label>
							<input name="mobile" type="number" class="form-control" required>
						</div>
						<div class="form-group text-right">
							<button type="submit" data-icon="search" class="btn btn-success"><i>search</i>Search User</button>
						</div>
					</form>
				
				<?php endif ?>
				</div>
			</section>
		</main>	<?php include("footer.php") ?>
	</body>
</html>