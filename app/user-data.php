<?php 
session_start();
require_once('includes/init.php');

if (!isset($_SESSION['token'])) {
	exit;
}

$token = $_SESSION['token'];

$user_data = get_user_by_token($conn, $token);

if ( empty( $user_data ) ) exit;
?>
	
<div class="user-block">
               <div class="icon">
                   <img src="https://invisiblelab.xyz/images/user.png" height="100px" width="100px"/>
               </div>
               <div class="userinfo">
                   <h4> <?= $user_data['fname'] ?? 'Shimul Ahmed' ;?></h4>
                   <h4 style="color : #ffffff"> <?= $user_data['mobile'] ?? '1234' ; ?></h4> <br>
                   <h4 style="color : #ffffff">Your Balance:</h4>
                   <h4><font style="font-family: 'Material Icons';">payments</font> <?= $user_data['balance'] ?? '1000' ;?></h4>
               </div>
           </div>