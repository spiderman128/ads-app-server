<?php
require_once('../includes/init.php');

$res = (object) array();

$res->success = false;
$res->message = '';

$token = compactify($conn, base64_decode($_GET['user']));
$token = preg_replace('/[^a-z0-9 ]/i', '', $token);

$sql = "UPDATE users SET i_click = i_click + 1 WHERE token = '{$token}' ";
$sql2 = "UPDATE users SET balance = balance - '$click_fine' WHERE token = '{$token}' ";

$result = mysqli_query( $conn, $sql );
$result2 = mysqli_query( $conn, $sql2 );

if(mysqli_affected_rows($conn) == 1) {
	$res->success = true;
	die(json_encode($res));
} else {
	$res->success = false;
	$res->message = 'Failed';
	die(json_encode($res));
}

echo json_encode($res);
?>