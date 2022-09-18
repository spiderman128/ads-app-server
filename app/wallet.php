<?php
session_start();
require_once('includes/init.php');

if (!isset($_SESSION['token'])) {
	header('location: login-required.php');
}

$token = $_SESSION['token'];

$user_data = get_user_by_token($conn, $token);

$mobile = $user_data['mobile'];
$balance = 0;

$available = true;
$withdraw_success = false;
$method = "";

/*
 *
 * Edit this line to add payment methods
 * 
*/

$payment_methods = ['Recharge','Bkash','Nagad','Roket','PHP','BTC','Paypal'];

$errors = array();

$sql = "SELECT balance, pending FROM users WHERE mobile='$mobile'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    while($user = mysqli_fetch_assoc($result)) {
        $balance = $user["balance"];
        if ($user["pending"] == 1) {
        	$available = false;
if($onetimepay == 0){
    $available = true;
}else{

        	array_push($errors, "Payment Pending");}
        }
    }
} else {
	array_push($errors, "User not found");
}

if (isset($_POST['req']))
{
	if (isset($_POST['method'])) {
		$method = compactify($conn, $_POST['method']);
	}
	$point = compactify($conn, $_POST['point']);
	$point = (int) preg_replace('/\D/', '', $point);
	$withdraw_mobile = compactify($conn, $_POST['withdraw_mobile']);
	
	# VALIDATE
	
	if (!is_int($point)) {
		array_push($errors, "Point is not valid" . $point);
	}

	if (empty($point)) {
		array_push($errors, "Point is required");
	}
	
	if ($point < $_POST['point_minimum']) {
		array_push($errors, "Minimum point is " . $_POST['point_minimum']);
	}
	
	if (empty($withdraw_mobile)) {
		array_push($errors, "Account is required");
	}
	if (strlen($withdraw_mobile) != 11) {
	    array_push($errors, "Invalid Mobile");
    }
	if (!$method || empty($method)) {
		array_push($errors, "Method is required");
	}
	
	if (!empty($point) && $point > $balance) {
		array_push($errors, "Not enough point");
	}

	
	
	//if (!empty($point) && $method == "Recharge" && $point < $min_recharge) {
	//	array_push($errors, "Minimum withdraw for Recharge is " . $min_recharge);
//	}
	
	//if (!empty($point) && $method == "Bkash" && $point < $min_bkash) {
	//	array_push($errors, "Minimum withdraw for Bkash is " . $min_bkash);
//	}

	/*
	 *
	 * Remove comment (//) and Edit code below to add payment methods
	 * 
	*/
	
	// if (!empty($point) && $method == "Nagad" && $point < 5000) {
	// 	array_push($errors, "Minimum withdraw for Nagad is " . $min_bkash);
	// }
	
	if (count($errors) == 0) {
	
	  $sql = "UPDATE users SET balance = balance - $point, pending = 1 WHERE mobile='$mobile';";
	  $sql .= "INSERT INTO payments (mnumber, number, amount, method) VALUES ('$mobile', '$withdraw_mobile', $point, '$method')";
	  if ($conn->multi_query($sql) === TRUE) {
		array_push($errors, "Withdrawal successful");
		$balance = $balance - $point;
		$available = false;
if($onetimepay == 0){
    $available = true;
}
        
		$withdraw_success = true;
	  } else {
		array_push($errors, "Failed");
	  }
    } else {
  	array_push($errors, "Failed");
    }
	
}

$errors = array_slice($errors, 0, 1);
$sql = "SELECT * FROM methods ORDER BY amount ASC";
$data = mysqli_query($conn, $sql);
$index = 1;
mysqli_close($conn);

?>
<html>
	<head>
		<title>Wallet</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
    <link rel="stylesheet" href="css/style.css">
    <link defer rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <link href="https://fonts.googleapis.com/css?family=Nunito:600,700,900" rel="stylesheet">
		<style>
		<?php include 'css/custom-style.php' ?>
		#body {
  font-family: 'Nunito';
background-color:  #5d8fc9;
}
#login-card{
    width:350px;
    border-radius: 25px;
    margin:150px auto;
  
}

#amount-input{
    border-radius:25px;
    background-color: #ebf0fc;
    border-color: #ebf0fc;
    color: #9da3b0;
    width: 60%;
}
#account-input{
    border-radius:25px;
    background-color: #ebf0fc;
    border-color: #ebf0fc;
    color: #9da3b0;
    width: 60%;
}
#button{
    border-radius:25px;
    width: 60%;
    color:white;

}

#btn{
   position: absolute; 
   bottom: -35px; 
   padding: 25px;
   margin: 0px 55px;
   align-items: center;
   border-radius: 5px"
}
#container{
    margin-top:25px;
}

.btn-circle.btn-sm { 
            width: 40px; 
            height: 40px; 
            padding: 2px 0px; 
            border-radius: 25px; 
            font-size: 14px; 
            text-align: center;
            
            margin: 8px;
        }
.logoicon{
    position: absolute; 
   top: -50px; 
   margin: 0;
   align-items: center;
   display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}    
.logoicon img{
   margin: 0;
   align-items: center;
   border-radius: 50%;
   border: 3px solid white;
   display: flex;
    justify-content: center;
    align-items: center;
}

	</style>
	</head>
<body class="bg-primary">  
<section class="topbar">
   <div class="main-balance">
			<h5 class="title">YOUR BALANCE</h5>
			<span class="balance-text"><?php echo $balance ?></span>
		</div><br><br><br>
</section>
<div class="notice-bg">
<div class="notice-block">
		
		

<!-- PHP SCRIPT -->

<?php 
if($onetimepay == '0'){
    $available = true;
}
?>
<?php if (!$available) : ?>
<center>	<p id="button" class="btn bg-main deep-purple btn-block">Payment Pending</p></center>
<?php elseif (!$payment) : ?>
<center>	<p id="button" class="btn bg-main deep-purple btn-block">Payment Close</p>
<?php endif ?></center>
	
<?php if ($withdraw_success) : ?>
	<script>
		Android.successAlert("Withdrawal Successful!", false)
	</script>
<?php endif ?>
		
		<!-- Withdraw Form -->
<?php if ($payment && $available) : ?>
	
		<form autocomplete="off" action="" method="POST">
			<div align="center">

				<div class="radio-main">
				   <?php
					if (mysqli_num_rows($data) > 0) {
						while($row = mysqli_fetch_assoc($data)) {
							echo "<label class='radio-container' data-amount='{$row['amount']}' data-type='{$row['type']}' data-note='{$row['hint']}'>{$row['name']} <input type='radio' value='{$row['name']}' name='method'><span class='checkmark'></span></label>";
							$index++;
						}
					}
					?>
					
				
				</div>

				<div class="form-group">
					
					<input
						id="amount-input"
						class="form-control"
						type="number"
						placeholder="Point"
						name="point"
						value=""
						<?php if($fixedwithdraw == 1){echo "readonly";} ?>
						>
				</div>

				<div class="form-group">
				
					<input
						id="account-input"
						class="form-control"
						type="number"
						placeholder="Number"
						name="withdraw_mobile">
						
						<input
						id="amount-input2"
						class="form-control"
						type="number"
						placeholder="Point"
						name="point_minimum"
						value=""
						hidden
						>
				</div>
				
			</div>
			<center>
			<?php foreach ($errors as $error) : ?>
				<p class="kalpurush gray"><?php echo $error ?></p>
			<?php endforeach ?>
				<button type="submit" name="req" id="button" class="btn bg-main deep-purple btn-block">Withdraw</button>
			</center>
		</form>
		
<?php endif ?>
		<p class="gray notice kalpurush">
			<?= nl2br( text2link($wallet_notice) ) ?>
		</p>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			$('*[data-note]').click(function () {
				$('#amount-input').attr('value', $(this).data('amount'));
				$('#amount-input2').attr('value', $(this).data('amount'));
				$('#account-input').attr('placeholder', $(this).data('note'));
				$('#account-input').attr('type', $(this).data('type'));
			});
		</script>
	</div></div>
<?php include 'developer.php'; ?>	
	</body>
</html>