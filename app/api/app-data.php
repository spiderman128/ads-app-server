<?php
require_once('../includes/init.php');

$res = (object) array();

$res->success = $APP_AVAILABLE;
$res->message = $DEV_MESSAGE;

if ( $m_mode == 1) {
	$res->success = false;
	$res->message = 'Maintenance mode';
}

if ( $dev_off == 1) {
	$res->success = false;
	$res->message = 'App is closed by Developer!';
}

$res->app_version = (int) $app_version;
$res->app_url = $app_url;

$res->spin_limit = $spin_view;
$res->daily_task_limit = $spin_click;
$res->spin_control = $spin_enabled;
$res->startapp_ads_code = $startapp_ads_code;
$res->spin_waiting_time = $spin_waiting_time;

$res->primary_color = $primary_color;
$res->gradient_color_end = $gradient_color_end;

$res->vpn_required = $vpn_task_only == 1 ? null : $vpn_required;

$res->tg_channel = $tg_channel;
$res->support_group = $support_group;

$res->ban_ad = $ban_ad ?? '';

if($multi_task == '1' && empty($_GET['task-app'])) {
	$res->vpn_required = null;
}

if ( $_GET['task-app'] == 1 ) {
	$res->ban_ad = $ban1;
}

if ( $_GET['task-app'] == 2 ) {
	$res->ban_ad = $ban2;
}

if ( $_GET['task-app'] == 3 ) {
	$res->ban_ad = $ban3;
}

if ( $_GET['task-app'] == 4 ) {
	$res->ban_ad = $ban4;
}



echo json_encode($res);
?>