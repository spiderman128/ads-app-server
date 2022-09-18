<?php
require_once('../includes/init.php');

/* -------------------- */

$col_todayTask = 'today_task';
$col_taskTime = 'task_time';

if (isset($_GET['task-app'])) {
	$col_todayTask = 'today_task' . $_GET['task-app'];
	$col_taskTime = 'task_time' . $_GET['task-app'];
}
/* -------------------- */

$res = (object) array();

$res->success = true;
$res->message = '';

if($task_enabled == 0 ) {
    $res->success = false;
    $res->message = 'Task closed';
    die( json_encode($res) );
}

$token = compactify($conn, base64_decode($_GET['user']));
$token = preg_replace('/[^a-z0-9 ]/i', '', $token);


$res->balance = 0;

$res->view_target = $view_target;
$res->impression_time = $impression_time;
$res->click_time = $click_time;
$res->button_timer = $button_timer;
$res->click_ttimer = $click_ttimer;
$res->im_ttimer = $im_ttimer;
$res->auto_back = $auto_back;

$res->vpn_required = $vpn_required;
$res->int_ad = $int_ad;
$res->task_ban1 = $task_ban1 ?? '';
$res->task_ban2 = $task_ban2 ?? '';

if ( $_GET['task-app'] == 1 ) {
	$res->int_ad = $int1;
    $res->task_ban1 = $ban1 ?? '';
    $res->task_ban2 = $ban1 ?? '';
}

if ( $_GET['task-app'] == 2 ) {
	$res->int_ad = $int2;
    $res->task_ban1 = $ban2 ?? '';
    $res->task_ban2 = $ban2 ?? '';
}

if ( $_GET['task-app'] == 3 ) {
$res->int_ad = $int3;
    $res->task_ban1 = $ban3 ?? '';
    $res->task_ban2 = $ban3 ?? '';
}

if ( $_GET['task-app'] == 4 ) {
	$res->int_ad = $int4;
    $res->task_ban1 = $ban4 ?? '';
    $res->task_ban2 = $ban4 ?? '';
}

$sql = "SELECT
		*, TIMESTAMPDIFF(MINUTE, $col_taskTime, NOW()) AS time_diff
		FROM users WHERE token = '{$token}'";
		
$result = mysqli_query($conn, $sql);

if (!mysqli_num_rows($result) == 1) {
	$res->success = false;
	$res->message = "User not found";
	die( json_encode($res) );
}

while($data = mysqli_fetch_assoc($result)) {
	
	$res->balance = $data['balance'];
	
	if ( $data['i_click'] > $invalid_limit ) {
		$res->success = false;
		$res->message = "Account blocked";
		die( json_encode($res) );
	}
	
	if ( $data[$col_todayTask] >= $task_limit ) {
		$res->success = false;
		$res->message = "Daily limit reached: {$task_limit}";
		die( json_encode($res) );
	}
	
	
	if ( $data['time_diff'] < $task_timer ) {
		$time_left = $task_timer - $data['time_diff'];
		$res->success = false;
		$res->message = "Wait {$time_left} minute";
		die( json_encode($res) );
	}
}

$conn->close();

if ($vpn_required) {
	
	$country = get_location($i_key);
	
	if ( strlen($country) != 2 ) {
		$res->message = "Invalid token or limit reached. Token : {$i_key}";
		die( json_encode($res) );
	}
	
	if ( !in_array($country, $ALLOWED_LOCATIONS) ) {
		$res->success = false;
		$res->message = "Connect VPN";
		
		$res->country = $country;
		$res->allowed = $ALLOWED_LOCATIONS;
		
		die( json_encode($res) );
	}
}

echo json_encode($res);
?>