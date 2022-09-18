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


$pageTitle = 'Update Admin Pass';
$success = false ;
$error = false ;

if (isset($_POST['update_pass'])) {
	$oldpwd = md5($_POST['oldpass']);
	$pwd = md5($_POST['pwd']);
    $query = "SELECT * FROM admins WHERE password='$oldpwd'";
    $results = mysqli_query($conn, $query);
	
	
	if (mysqli_num_rows($results) == 1) {
	$sql = "UPDATE admins SET password = '$pwd' WHERE password = '$oldpwd'";
	$result = $conn -> query($sql);
	
	if ($result === TRUE) {
		snack ("success", "Success");
		

	$sql = "UPDATE admins SET chng = '2'";
	$result = $conn -> query($sql);

		
		
		
	$success = true ;
session_unset();
//redirect to login page
header("location: login.php");
    } else {
    	snack ("error", "Failed");
    }
}else{
	snack( 'error', 'Incorrect old password' );
	$error = true ;
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
			.login-form-container {
				max-width: 320px;
				margin: auto;
				padding: 1em;
				background: #FFF;
				color: #020202;
			}
			
			.login-form {
				text-align: center;
			}
			
			.admin-icon {
			    font-size: 1.4em;
			}
			
			.material-icons {
			    user-select: none;
			}
		</style>
		
	</head>
	<body class="bg-gray-200">
		<?php include("header.php") ?>
		<main>
		<section class="login-form-container fr-container py-0"><?php if ($success) :?>
				    <div class="alert alert-success">
                       <strong>Success!</strong> changes Saved.
                         </div>
                    <?php endif ?>
                    <?php if ($error) :?>
				    <div class="alert alert-danger">
                       <strong>Error!</strong> Incorrect Old Password.
                         </div>
                    <?php endif ?>
				<form class="login-form my-3" class="text-center" action="" autocomplete="off" autocapitalize="off" method="POST">
					
					<div class="form-group text-left">
					    <label>Enter Old Password</label>
                        <input
                            type="text"
                            class="form-control"
                            name="oldpass"
                            value="<?php if(isset($_GET['dflt'])) { echo $_GET['dflt']; } ?>"
                            required>
                    </div>
                    
					<div class="form-group text-left">
					    <label>Enter New Password</label>
                        <input type="text" class="form-control" name="pwd" required>
                    </div>
                    
					
					<button type="submit" name="update_pass"
					    class="btn btn-primary btn-block material-icons py-1"
					    style="font-size: 22px"
					    onclick="return confirm('Are you sure?')" >check</button>
				</form>

			</section>
		</main>
		<?php include('footer.php') ?>
	</body>
</html>