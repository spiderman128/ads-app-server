<?php 
if (!isset($_SESSION['password']) ) {
    echo 
    '<style>
    b {display: none};
    </style>
    <p><br>Not Access!</p>
    ';
    error_reporting(0);
	exit();
}
?>

<?php 
$data_file = file_get_contents('app-data.json');
$dd = json_decode($data_file);

?>
	
		<style>
		    .bg-primary{background-color: <?php echo $dd->primary_color; ?> !important;}
		    .fr-container{border-top-color: <?php echo $dd->primary_color; ?> !important;}
		    .btn-primary{background-color: <?php echo $dd->primary_color; ?> !important; border-color: <?php echo $dd->primary_color; ?> !important;}
		    
		    th{background-color: <?php echo $dd->primary_color; ?> !important;}
		    th{background-color: <?php echo $dd->primary_color; ?> !important;}
		    
		</style>
		
		
		<header><head><link rel="shortcut icon" href="icon.ico"></head>

			<nav class="navbar navbar-dark bg-primary shadow-sm">
			    <a href="index.php"><span class="material-icons col-white" style="font-size: 24px">assistant</span></a>
				<a class="navbar-brand" href="#"><?= $pageTitle ?? 'Admin Panel' ?></a>
				<button class="navbar-toggler" style="border: 0; padding: 0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				</button>
					<div class="collapse navbar-collapse col-white" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" data-icon="dashboard" href="index.php">Dashboard</a>
						</li>
						
						<div class="col-xs-12 col-sm-6 col-md-3 m-0 p-0">
							<li class="nav-item dropdown">
								<a data-icon="done_all" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Pay Users
								</a>
								<div class="dropdown-menu my-2" aria-labelledby="navbarDropdown">
									<a data-icon="check" class="dropdown-item" href="pay-users.php">Pay All</a>
									<div class="dropdown-divider"></div>
									<a data-icon="check" class="dropdown-item" href="pay-recharge.php">Pay Recharge</a>
								    <div class="dropdown-divider"></div>
									<a data-icon="check" class="dropdown-item" href="pay-bkash.php">Pay Bkash</a>
								</div>
							</li>
						</div>

						<div class="col-xs-12 col-sm-6 col-md-3 m-0 p-0">
							<li class="nav-item dropdown">
								<a data-icon="settings" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Settings
								</a>
								<div class="dropdown-menu my-2" aria-labelledby="navbarDropdown">
									<a data-icon="app_settings_alt" class="dropdown-item" href="app-settings.php">App Settings</a>
									<div class="dropdown-divider"></div>
									<a data-icon="campaign" class="dropdown-item" href="edit-notice.php">Edit Notice</a>
									<div class="dropdown-divider"></div>
									<a data-icon="payments" class="dropdown-item" href="payment-methods.php">Payment Methods</a>
									<div class="dropdown-divider"></div>
									<?php if( $admob == 1 ) : ?>
									<a data-icon="insights" class="dropdown-item" href="ad-units.php">Ad Units</a>
									<div class="dropdown-divider"></div>
									<?php endif ?>
									<?php if( $multi_task == 1 ) : ?>
									<a data-icon="link" class="dropdown-item" href="app-links.php">App Links</a>
									<div class="dropdown-divider"></div>
									<?php endif ?>
									<a data-icon="settings" class="dropdown-item" href="extra-settings.php">  Extra Settings</a>
									
								</div>
							</li>
						</div>

						<div class="col-xs-12 col-sm-6 col-md-3 m-0 p-0">
							<li class="nav-item dropdown">
								<a data-icon="group" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Users
								</a>
								<div class="dropdown-menu my-2" aria-labelledby="navbarDropdown">
									<a data-icon="person" class="dropdown-item" href="user-profile.php">User Profile</a>
									<div class="dropdown-divider"></div>
									<a data-icon="list" class="dropdown-item" href="users-table.php">Users Table</a>
									<div class="dropdown-divider"></div>
									<a data-icon="security" class="dropdown-item" href="user-pass.php">Update Password</a>
									<div class="dropdown-divider"></div>
									<a data-icon="block" class="dropdown-item" href="blocked-users.php">Blocked Users</a>
								</div>
							</li>
						</div>

						<div class="col-xs-12 col-sm-6 col-md-3 m-0 p-0">
							<li class="nav-item dropdown">
								<a data-icon="payments" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Payments
								</a>
								<div class="dropdown-menu my-2" aria-labelledby="navbarDropdown">
									<a data-icon="done_all" class="dropdown-item" href="payments.php">All Payments</a>
									<div class="dropdown-divider"></div>
									<a data-icon="refresh" class="dropdown-item" href="payments.php?list=Pending">Pending</a>
									<div class="dropdown-divider"></div>
									<a data-icon="check" class="dropdown-item" href="payments.php?list=Paid">Paid</a>
								</div>
							</li>
						</div>

						<div class="col-xs-12 col-sm-6 col-md-3 m-0 p-0">
							<li class="nav-item dropdown">
								<a data-icon="local_police" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Admin
								</a>
								<div class="dropdown-menu my-2" aria-labelledby="navbarDropdown">
									<a data-icon="security" class="dropdown-item" href="admin-pass.php">Edit Password</a>
									<div class="dropdown-divider"></div>
									<a data-icon="delete" class="dropdown-item" href="clear-data.php">Clear Data</a>
									<div class="dropdown-divider"></div>
									<a data-icon="exit_to_app" class="dropdown-item" href="logout.php">Log Out</a>
								</div>
							</li>
						</div>
					</ul>
				</div
			</nav>
		</header>


