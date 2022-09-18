<?php
session_start();
require_once('includes/init.php');


$token = $_SESSION['token'];

$user_data = get_user_by_token($conn, $token);

echo $user_data['balance'];
?>