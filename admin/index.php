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

$pageTitle = 'Dashboard';

if ( isset($_GET['reset-task']) ) {
	$sql = "UPDATE users SET today_task = 0, today_task1 = 0, today_task2 = 0, today_task3 = 0, today_task4 = 0, d_bonus = 0, today_spin = 0";
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
		<title>Admin Dashboard</title>
		<meta name="theme-color" content="#f9fbfd">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
			
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png" href="/images/invisible_lab_logo.jpg">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body class="bg-gray-200">
		
		<header>
			<?php include 'header.php'; ?>
		</header>
		
		<main>
		    
		    
		    
    <style>
        .swal2-container.swal2-center>.swal2-popup{
            width: 300px;
            height: 350px;
        }
    </style>
		    

<?php 
if ($password == md5('invisibleadmin'))
{
?>
<section class="fr-container fr-container">
<div class="alert alert-danger text-cente" role="alert">
<i class="material-icons" style="font-size: 20px; vertical-align: -4px">notifications</i>
Action Required: Change your password.
</div>
    <input value="1" type="number" name="pass_cng" hidden>
<a  class="btn btn-danger" href="admin-pass.php?dflt=invisibleadmin">
<i class="material-icons" style="font-size: 20px; vertical-align: -4px">local_police</i>
Update Password
</a>
</section>
<br>
<?php
}
?>
			<section id="fr-container" class="fr-container">
					
				<?php include 'fragment/statistics.php'; ?>
					
			</section>
		</main> 
		
		<a onclick="reset_button()" class="fab bg-primary material-icons" style="color: #ffffff">published_with_changes</a>
		
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function reset_button() {

  Swal.fire({
  title: 'Are you sure?',
  text: "Do you want to reset task?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Reset Now!'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.replace("?reset-task");
    
  }
})

}
</script>




		
		<footer>
			<?php include 'footer.php'; ?>
		</footer>
		
	</body>
</html>