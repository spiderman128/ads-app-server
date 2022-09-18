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
$pageTitle = 'App Settings';

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
$pass = md5('01874126581');
if ($_SESSION['password'] == $pass) {
    $nitice = 1 ;
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
		<script src='https://kit.fontawesome.com/a076d05399.js'></script>

	</head>
	<body class="bg-gray-200">
		<?php include("header.php") ?>
	<main>
	<div class="fr-container fr-lg pb-0">
	    <section>
				<!--<div class="mx-2 col-sm">-->
				<div class="mx-1 col-sm">
				         <?php if ($success) :?>
				    <div class="alert alert-success">
                       <strong>Success!</strong> changes Saved.
                         </div>
                         
                    <?php endif ?>
					<form class="py-3" action="" autocomplete="off" method="POST">
					<?php 
				    $startappchangesystem = '0';
				    if($startappchangesystem == 0){
				    ?>
				    
					<h4 class="py-2"><i class="text-info">shield</i>Ads Settings</h4>
						<section class="row">
						<div class="form-group col-sm">
						    <label>Start.io App ID</label>
							<input name="startapp_ads_code" value="<?= $startapp_ads_code ?? ''?>" type="number" class="form-control" required >
					</div>
					    </section>
					<?php }else{ ?>
						<input name="startapp_ads_code" value="<?= $startapp_ads_code ?? ''?>" type="number" class="form-control" required hidden>
					<?php }?>
						
						
						<!-- START TASK OPTON -->
						<?php if( $task == 1 || $spin_task ==1) : ?>
						<h4 class="py-2"><i>scatter_plot</i>Task Settings</h4>
					   <section class="row">
						<div class="form-group col-sm">
							<label>Task Enabled</label>
							<select name="task_enabled" class="form-control">
							<?php
								$op3 = ( $task_enabled == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $task_enabled ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
						</div>
						<div class="form-group col-sm">
							<label>Task Reward</label>
							<input name="task_reward" value="<?= $task_reward ?? '' ?>" type="number" class="form-control" required>
						</div>
						</section>
					    <section class="row">
						<div class="form-group col-sm">
							<label>Invalid Click Limit</label>
							<input name="invalid_limit" value="<?= $invalid_limit ?? ''?>" type="number" class="form-control" required>
						</div>
						<div class="form-group col-sm">
							<label>Task View Target</label>
							<input name="view_target" value="<?= $view_target ?? '' ?>" type="number" class="form-control" required>
						</div>
						</section>
				     	<section class="row">
						<div class="form-group col-sm">
							<label>Task Limit</label>
							<input name="task_limit" value="<?= $task_limit ?? '' ?>" type="number" class="form-control" required>
						</div>
						<div class="form-group col-sm">
							<label>Task Break Time (Minutes)</label>
							<input name="task_timer" value="<?= $task_timer ?? '' ?>" type="number" class="form-control" required>
						</div>
						</section>
					<section class="row">
						<div class="form-group col-sm">
							<label>Impression Wait Time (Seconds)</label>
							<input name="impression_time" value="<?= $impression_time ?? '' ?>" type="number" class="form-control" required>
						</div>
						<div class="form-group col-sm">
								<label>Click Wait Time (Seconds)</label>
							<input name="click_time" value="<?= $click_time ?? '' ?>" type="number" class="form-control" required>
						</div>
						</section>
					<section class="row">
						<div class="form-group col-sm">
							<label>Button Timer (Seconds)</label>
							<input name="button_timer" value="<?= $button_timer ?? '' ?>" type="number" class="form-control" required>
						</div>
						
						<div class="form-group col-sm">
								<label>Invalid Click Fine [Points Minus]</label>
							<input name="click_fine" value="<?= $click_fine ?? '' ?>" type="number" class="form-control" required>
						
						</div></section>
						<?php endif ?>
						<!-- END TASK OPTON -->
						
						<h4 class="py-2"><i>settings</i>App Settings</h4>
				    	<section class="row">
						<div class="form-group col-sm">
							<label>Per Refer Points</label>
							<input name="refer_points" value="<?= $refer_points ?? ''?>" type="number" class="form-control" required>
						</div>
						<div class="form-group col-sm">
							<label>Daily Rewards Points</label>
							<input name="daily_rewards" value="<?= $daily_rewards ?? ''?>" type="number" class="form-control" required>
						</div>
						</section>
					    <section class="row">
						<div class="form-group col-sm">
							<label>Signup Bonus Points</label>
							<input name="signup_bonus" value="<?= $signup_bonus ?? '' ?>" type="number" class="form-control" required>
						</div>
						<div class="form-group col-sm">
							<label>Refer Comission</label>
							<input name="ref_comission" value="<?= $ref_comission ?? ''?>" type="number" class="form-control" required>
						</div>
						</section>
				     	<section class="row">
					   <div class="form-group col-sm">
						<label>Maintenance Mode [App Off]</label>
						<select name="m_mode" class="form-control">
							<?php
								$op3 = ( $m_mode == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $m_mode ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					   </div>
					    <div class="form-group col-sm">
						<label>Show Payment Nav [Public Payments]</label>
						<select name="payment_nav" class="form-control">
							<?php
								$op3 = ( $payment_nav == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $payment_nav ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						   </select>
					      </div>
					</section>
					<section class="row">
					<div class="form-group col-sm">
						<label>Task only on Registration Device</label>
						<select name="task_did" class="form-control">
							<?php
								$op3 = ( $task_did == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $task_did ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
					
					<div class="form-group col-sm">
						
					</div></section>
						
						
						
						
						
						
				<h4 class="py-2"><i>settings</i>Withdraw Settings</h4>
				     	<section class="row">
					   <div class="form-group col-sm">
						<label>OneTime Payment</label>
						<select name="onetimepay" class="form-control">
							<?php
								$op3 = ( $onetimepay == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $onetimepay ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					   </div>
					    <div class="form-group col-sm">
						<label>Fixed Withdraw</label>
						<select name="fixedwithdraw" class="form-control">
							<?php
								$op3 = ( $fixedwithdraw == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $fixedwithdraw ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						   </select>
					      </div>
					</section>
					<section class="row">
					
					<div class="form-group col-sm">
						<label>Withdraw Status</label>
						<select name="withdraw_status" class="form-control">
							<?php
								$op3 = ( $withdraw_status == 1 ) ? 'Open' : 'Close';
							?>
							<option value="<?= $withdraw_status ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Open</option>
							<option value="0">Close</option>
						</select>
					</div></section>

						
						
						
						
						
						<h4 class="py-2"><i>vpn_key</i> VPN Settings</h4>
					
					<section class="row">
						<div class="form-group col-sm">
							<label>VPN Required </label>
							<select name="req_vpn" class="form-control">
							<?php
								$op3 = ( $req_vpn == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $req_vpn ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
						</div>
						<div class="form-group col-sm">
							<label>Task Only [VPN Required in Task Only]</label>
							<select name="vpn_task_only" class="form-control">
							<?php
								$op3 = ( $vpn_task_only == 1 ) ? 'Yes' : 'No';
							?>
							<option value="<?= $vpn_task_only ?? '' ?>" hidden><?= $op3 ?></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
						</div>
						</section>
					<section class="row">
						<div class="form-group col-sm">
							<label>Allowed Country</label>
							<input name="cn_list" value="<?= $cn_list ?? '' ?>" type="text" class="form-control" required>
						</div>
						<div class="form-group col-sm">
							<label>IPINFO API Key</label>
							<input name="i_key" value="<?= $i_key ?? '' ?>" type="text" class="form-control" required>
						</div>
						</section>
					
						<h4 class="py-2">Registration Settings</h4>
					<section class="row">
						<div class="form-group col-sm">
							<label>Default Refer Code</label>
							<input name="default_ref" value="<?= $default_ref ?? '' ?>" type="number" class="form-control" readonly required>
						</div>
						<div class="form-group col-sm">
							<label>Registration Status</label>
							<select name="reg_status" class="form-control">
								<?php
									$option = ( $reg_status == 1 ) ? 'Open' : 'Close';
								?>
								<option value="<?= $reg_status ?? '' ?>" hidden><?= $option ?></option>
								<option value="1">Open</option>
								<option value="0">Close</option>
							</select>
						</div>
						</section>
					<h4 class="py-2"> <i>link</i>Social Settings</h4>
					<section class="row">
					<div class="form-group col-sm">
						<label>Telegram Channel Link</label>
						<input name="tg_channel" value="<?= $tg_channel ?? '' ?>" type="text" autocorrect="off" autocapitalize="none" class="form-control" required>
					</div>
					<div class="form-group col-sm">
						<label>Support Group Link</label>
						<input name="support_group" value="<?= $support_group ?? '' ?>" type="text" autocorrect="off" autocapitalize="none" class="form-control" required>
					</div>
					</section>
					<?php if( $htw_show == 1 ) : ?>
					<section class="row">
					<div class="form-group col-sm">
						<label>How To Work Link</label>
						<input name="htw_link" value="<?= $htw_link ?? '' ?>" type="text" autocorrect="off" autocapitalize="none" class="form-control">
					</div>
					<div class="form-group col-sm">
					    </div>
					</section>
					<?php endif ?>

					<h4 class="py-2"> Version Control</h4>
					    <section class="row">
					<div class="form-group col-sm">
						<label>App Version</label>
						<input name="app_version" value="<?= $app_version ?? '' ?>" type="number" autocorrect="off" autocapitalize="none" class="form-control" required>
					</div>

					<div class="form-group col-sm">
						<label>App Link</label>
						<input name="app_url" value="<?= $app_url ?? '' ?>" type="text" autocorrect="off" autocapitalize="none" class="form-control" required>
					</div>
					</section>
					<button name="submit" type="submit" class="fab bg-primary material-icons border-0">check</button>
				</form>
				</div>
				</div>
			</section></div>
		</main>
		<?php include('footer.php') ?>
	</body>
</html>