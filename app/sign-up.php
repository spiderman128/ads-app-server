<?php
session_start();
require_once('includes/init.php');

$reg_success = false;
$errors = array();

if(isset($_POST['reg_user']))
{
	$reg_name = compactify($conn, $_POST['name']);
	$reg_mobile = compactify($conn, $_POST['mobile']);
	$reg_password_1 = $_POST['password_1'];
	$reg_password_2 = $_POST['password_2'];
	$reg_ref = compactify($conn, $_POST['ref']);
	$reg_did = compactify($conn, $_POST['did']);
	
    $errors = array();
    
    # CHECK IF REGISTRATION AVAILABLE
    
    if (!$registration) {
		array_push($errors, "Registration Closed");
	}
	
	# CHECK DEVICE ID
	
	if (empty($reg_did)) {
		array_push($errors, "Unsupported device");
	}
	
	# CHECK IF DEVICE IS ALREADY REGISTERED
	
	$sql_check_did = "SELECT id FROM users WHERE did = '$reg_did'";
    $scd_result = mysqli_query($conn, $sql_check_did);
    if (mysqli_num_rows($scd_result) > 0) {
        array_push($errors, "Device already registered");
    }
	
	# CHECK IF MOBILE IS EMPTY
	
	if (empty($reg_mobile)) {
	    array_push($errors, "Mobile is required");
    }
    
	# CHECK IF MOBILE IS VALID
	
	if (strlen($reg_mobile) < 11) {
	    array_push($errors, "Invalid Mobile");
    }
    
	# CHECK IF PASSWORD IS VALID
	
	if (strlen($reg_password_1) < 4) {
	    array_push($errors, "Minimum Four Digit Password");
	}
	
	# CHECK IF USER EXIST
	
	$sql_check_user = "SELECT id FROM users WHERE mobile = '$reg_mobile'";
    $scu_result = mysqli_query($conn, $sql_check_user);
    if (mysqli_num_rows($scu_result) > 0) {
        array_push($errors, "User already exists");
    }
	
	# VALIDATE DATA
	
	if (empty($reg_name)) {
		array_push($errors, "Name is required");
	}
	
	if (empty($reg_password_1)) {
		array_push($errors, "Password is required");
	}
	
	if (empty($reg_ref)) {
		array_push($errors, "Refer Code is required");
	}
	
	# CHECK IF PASSWORDS ARE SAME
	
	if ($reg_password_1 !== $reg_password_2) {
		array_push($errors, "Passwords are not same");
	}
	
	# CHECK IF REFER CODE IS VALID
	
	if (!empty($reg_ref)) {
		$sql_check_ref = "SELECT id FROM users WHERE mobile=$reg_ref";
    	$scr_result = mysqli_query($conn, $sql_check_ref);
    	if (mysqli_num_rows($scr_result) == 0) {
        	array_push($errors, "Invalid refer code");
        }
    }
    
    
    $errors = array_slice($errors, 0, 1);
    
    # ENCRYPT PASSWORD
    
    $password = md5($reg_password_1);
    


  if (count($errors) == 0) {

    $token = sha1($reg_mobile);
  	
  	$sql = "INSERT INTO users (fname, mobile, password, balance, ref, did, token, task_time, task_time1, task_time2, task_time3, task_time4)
  	        VALUES ('$reg_name', '$reg_mobile', '$password', '$signup_bonus', '$reg_ref', '$reg_did', '$token', NOW() - INTERVAL 720 MINUTE, NOW() - INTERVAL 720 MINUTE, NOW() - INTERVAL 720 MINUTE, NOW() - INTERVAL 720 MINUTE, NOW() - INTERVAL 720 MINUTE)";
  	if ($conn->query($sql) === TRUE) {
  	  $sql = "UPDATE users SET t_ref = t_ref + 1 , balance = balance + $refer_points WHERE users.mobile = '$reg_ref'";
        if ($conn->query($sql) === TRUE) {
            $reg_success = true;
        } else {
        	echo "Error: " . $sql . "<br>" . $conn->error;
        }
  	} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
        array_push($errors, "Registration failed");
  	}
  }


}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
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

#email{
    border-radius:30px;
    background-color: #ebf0fc;
    border-color: #ebf0fc;
    color: #9da3b0;
    width: 60%;
}

#button{
    border-radius:30px;
    width: 60%;
    color:white;

}

#btn{
   position: absolute; 
   bottom: -35px; 
   padding: 5px;
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
   <br><br><br><br><br><br>
</section>
<div class="notice-bg">
<div class="notice-block">
  <div class="logoicon">
                   <img src="https://invisiblelab.xyz/images/user.png" height="100px" width="100px"/>
               </div>

  <br><br><br><div class="box">
     <center>
    <form action="" autocomplete="off" method="POST">
<?php foreach ($errors as $error) : ?>
            <p class="kalpurush gray"><?php echo $error ?></p>
<?php endforeach ?>
        <input type="hidden" id="did" name="did">
        <script type="text/javascript">
            var did_app = Android.getDeviceId();
            document.getElementById("did").value = did_app;
        </script>
        
        <div class="form-group">
            <input class="form-control" id="email" type="text" placeholder="Enter your name" value="<?= $_POST['name'] ?? ''?>" name="name">
        </div>
        <div class="form-group">
            <input class="form-control" id="email" type="number" placeholder="Mobile" value="<?= $_POST['mobile'] ?? ''?>" name="mobile">
        </div>
        <div class="form-group">
            <input class="form-control" id="email" type="password" placeholder="Create a password" name="password_1">
        </div>
        <div class="form-group">
            <input class="form-control" id="email" type="password" placeholder="Confirm password" name="password_2">
        </div>
        <div class="form-group">
            <input class="form-control" id="email" type="text" placeholder="Referral Code" value="<?= $_POST['ref'] ?? '1234'?>" name="ref">
        </div>
        
<?php if ($reg_success) : ?>
				<button disabled id="button" class="btn bg-main deep-purple btn-block">Account Create Success</button>
           	 <script>
            		Android.successAlert("Registration Successful!", false)
            	</script>
<?php elseif ($registration) : ?>
				<button type="submit" name="reg_user" id="button" class="btn bg-main deep-purple btn-block">Sign Up</button>
<?php else : ?>
				<button disabled id="button" class="btn bg-main deep-purple btn-block">Registration Closed</button>
<?php  endif ?>
    </form>
  <br>
  </center></div>
 </div>
 <?php include 'developer.php'; ?>	

</body>
</html>