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

$pageTitle = 'App Urls';

$data_file = "app-data.json";

if ( isset($_POST['submit']) ) {
	$data = json_decode(file_get_contents($data_file), true) ?? array();
	$data = array_merge($data, $_POST);
	file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
	snack ("success", "Success");
}

$app_data = json_decode(file_get_contents($data_file), true);

foreach( $app_data as $key => $val ) {
	$$key = $val;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>App Urls</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no"><link rel="shortcut icon" href="icon.ico">

		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
<body class="bg-gray-200">
		<?php include("header.php") ?>
		<main>
	<div class="fr-container fr-lg pb-0">
		<section>
			<form class="row mb-1" action="" autocomplete="off" method="POST">
			   <div class="mx-1 col-sm">
    				<div class="alert alert-info mt-1" role="alert">
        					    <i class="material-icons" style="font-size: 24px; vertical-align: -6px">info</i>
        					    For Multi Task App
                    </div>
                            
                    <section class="row">
                        <div class="form-group col-sm">
							<label>Task 1</label>
							<input name="task1_url" value="<?= $task1_url ?? '' ?>" type="text" class="form-control">
						</div>
						<div class="form-group col-sm">
							<label>Task 2</label>
							<input name="task2_url" value="<?= $task2_url ?? '' ?>" type="text" class="form-control">
						</div>
							</section>
					<section class="row">
						<div class="form-group col-sm">
							<label>Task 3</label>
							<input name="task3_url" value="<?= $task3_url ?? '' ?>" type="text" class="form-control">
						</div>
						<div class="form-group col-sm">
							<label>Task 4</label>
							<input name="task4_url" value="<?= $task4_url ?? '' ?>" type="text" class="form-control">
						</div>
							</section>
							<button name="submit" type="submit" class="fab bg-primary material-icons border-0">check</button>
					
				</div>
				</form>
			</div>
		</section></div>
	</main>	<?php include("footer.php") ?>
</body>	