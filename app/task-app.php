 <?php
session_start();
require_once('includes/init.php');

if(!empty($_GET['cp']) && !empty($_GET['cge'])) {
    $_SESSION['cp'] = $_GET['cp'];
    $_SESSION['cge'] = $_GET['cge'];
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
	<link rel="stylesheet" href="css/style.css" >
	<link defer rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" >
	<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <!-- modal -->
	 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<style>
		<?php include 'css/custom-style.php' ?>
	</style>
</head>
<body class="bg-primary">
	<section class="block-main">
		
			
			<center>
            
                
              	<div class="items" style="font-family: 'Hind Siliguri', sans-serif;text-align: left; ">
		<?= nl2br( text2link($home_notice) ) ?>
	</div></center><center>
               <?php if ( $task_enabled == 0 ) : ?>
               <div class="items">
                   <i class="material-icons icons">assistant</i> <br>
                   <span id="">Task Closed!</span>
                   </div>
               	<?php else : ?>
               <div id="vpn" onclick="Android.taskActivity()" class="items">
                   <i class="material-icons icons">assistant</i> <br>
                   <span id="off">Start Task</span>
               </div>
               <?php endif ?>
           </center>
       </section>
			
		
			
	</section>
	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<p class="lead">
		<?= nl2br( text2link($home_notice) ) ?></p>
				</div>
				<div class="modal-footer">
					<p class="btn btn-dialog" data-dismiss="modal" style="font-family: 'Hind Siliguri', sans-serif;text-align: left; color : black  ">Close</p>
					
				</div>
			</div>
		</div>
	</div>
	<script>
		Android.setUserAccount('<?= base64_encode(get_user_by_did($conn, $_GET['did'])['token']) ?? '' ?>');
	</script>
    <script> 
    	let allowedLocations = "<?= $cn_list ?>";

$.get("https://ipinfo.io?token=<?= $i_key ?>", function(response) {
  if(!allowedLocations.includes(response.country)) {
    $('#task-btn').prop('disabled', true);
    $('#task-btn').html('Connect VPN');
    $('#task-btn').prop("onclick", null).off("click");
   
  };
}, "jsonp")
    	</script>	
</body>
</html>
