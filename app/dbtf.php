<?php
session_start();
require_once('includes/init.php');

if(!empty($_GET['cp']) && !empty($_GET['cge'])) {
    $_SESSION['cp'] = $_GET['cp'];
    $_SESSION['cge'] = $_GET['cge'];
}

if($_GET['app'] == 'main') {
	$_SESSION['main_app'] = "1";
}

$_SESSION['token'] = $_COOKIE['token'] ?? null;

if ( !isset($_SESSION['token']) ) {
	header('location: login.php?' . http_build_query($_GET));
}

$token = $_SESSION['token'];

$user_data = get_user_by_token($conn, $token);

if ( empty( $user_data ) ) header('location: login.php?' . http_build_query($_GET));
if($user_data['d_bonus'] != 1){
$sql = "UPDATE users SET d_bonus = 1 , balance = balance + $daily_rewards WHERE users.token = '$token'";
if ($conn->query($sql) === TRUE) {
            header('location: index.php?d_bonus=true');
        }
}else {
            header('location: index.php?' . http_build_query($_GET));
        }        
?>