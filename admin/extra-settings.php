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

$pageTitle = 'Extra Settings';

$data_file = "app-data.json";
$success = false ;

if ( isset($_POST['submit']) ) {
	$data = json_decode(file_get_contents($data_file), true) ?? array();
	$data = array_merge($data, $_POST);
	file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));
	snack ("success", "Success");
	$success = true ;
}

$app_data = json_decode(file_get_contents($data_file), true);

foreach( $app_data as $key => $val ) {
	$$key = $val;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>App Settings</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body class="bg-gray-200">
		<?php include("header.php") ?>
	<main>
	<div class="fr-container fr-lg pb-0">
	    <section>
				<div class="mx-1 col-sm">
				         <?php if ($success) :?>
				    <div class="alert alert-success">
                       <strong>Success!</strong> changes Saved.
                         </div>
                    <?php endif ?>
					<form class="py-3" action="" autocomplete="off" method="POST">
						<h4 class="py-2"><i>style</i>Color Setting</h4>
						<section class="row">
						<div class="form-group col-sm">
							<label>Main Color</label>
							<input name="primary_color" value="<?= $primary_color ?? ''?>" type="color" class="form-control" required>
						</div>
						
						<div class="form-group col-sm">
							<label>Gradient Color</label>
							<input name="gradient_color_end" value="<?= $gradient_color_end ?? ''?>" type="color" class="form-control" required>
						</div>
						</section>
					<h4 class="py-2"><i>settings</i>Other Setting</h4>
					<section class="row">
						<div class="form-group col-sm">
						<label>Statistics Point Rate <i class="material-icons float-right ml-1" data-notice-button data-bs-toggle="modal" data-bs-target="#exampleModal">info_outline</i></label>
						<input name="statistics_point_rate" value="<?= $statistics_point_rate ?? ''?>" type="number" class="form-control" required>
						</div>
						<div class="form-group col-sm">
							<label>Show View Wait Time</label>
							<select name="im_ttimer" class="form-control">
							<?php
								$op3 = ( $im_ttimer == 1 ) ? 'Enabled' : 'Disabled';
							?>
							<option value="<?= $im_ttimer ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Enabled</option>
							<option value="0">Disabled</option>
						</select>
						</div>
						</section>
					<section class="row">
					    
						<div class="form-group col-sm">
						    	<label>Auto Back</label>
							<select name="auto_back" class="form-control">
							<?php
								$op3 = ( $auto_back == 1 ) ? 'Enabled' : 'Disabled';
							?>
							<option value="<?= $auto_back ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Enabled</option>
							<option value="0">Disabled</option>
						</select> 
						</div>
						<div class="form-group col-sm">

						<label>Show Click Wait Time</label>
							<select name="click_ttimer" class="form-control">
							<?php
								$op3 = ( $click_ttimer == 1 ) ? 'Enabled' : 'Disabled';
							?>
							<option value="<?= $click_ttimer ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Enabled</option>
							<option value="0">Disabled</option>
						</select>	
						</div>
						</section>
					<button name="submit" type="submit" class="fab bg-primary material-icons border-0">check</button>
				</form>
				
				</div>
		</main>
		
		
		
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 280px; margin: auto;">
      
      <div class=" modal-header" style="border-bottom: none">
            <h5 class="modal-title pt-3 w-100 d-flex align-items-center justify-content-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modal" style="width: 50px; height: 50px; background: rgba(140, 20, 252, 0.1);">
                    <i class="material-icons pr-0">info_outline</i>
                </div>
            </h5>
        </div>
      
      <div class="modal-body" style="text-align: center;" >
        কত পয়েন্টে ১টাকা দেন? সেটা এখানে লিখুন।
      </div>
      <div class="modal-footer" style="border-top: 0px;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

		
		
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
		
		<?php include('footer.php') ?>
	</body>
</html>