<?php

function compactify ($connection, $field)
{
	$compact_result = strip_tags($field);
	return mysqli_real_escape_string($connection, $compact_result);
}

function text2link ($text)
{
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $text);
}

function start_user_session($token)
{
	setcookie('token', $token, time() + 3600*24*30*12*10);
	$_SESSION['token'] = $token;
}

function get_user_data ($conn, $mobile)
{
	$mobile = compactify( $conn, $mobile );
	
	$sql = $sql = "SELECT * FROM users WHERE mobile = '{$mobile}' ";
	$result = mysqli_query($conn, $sql);
	
	if ( mysqli_num_rows($result) != 1 ) return null;
	return mysqli_fetch_assoc($result);
}

function get_user_by_did ($conn, $did)
{
	$did = compactify( $conn, $did );
	
	$sql = $sql = "SELECT * FROM users WHERE did = '{$did}' ";
	$result = mysqli_query($conn, $sql);
	
	if ( mysqli_num_rows($result) != 1 ) return null;
	return mysqli_fetch_assoc($result);
}

function get_user_by_token ($conn, $token)
{
	$did = compactify( $conn, $did );
	
	$sql = $sql = "SELECT * FROM users WHERE token = '{$token}' ";
	$result = mysqli_query($conn, $sql);
	
	if ( mysqli_num_rows($result) != 1 ) return null;
	return mysqli_fetch_assoc($result);
}

function get_payment_records ($conn, $mobile, $status)
{
	$mobile = compactify( $conn, $mobile );
	$status = compactify( $conn, $status ); 
	
	$sql = "SELECT * FROM payments";
	$sql .= ( empty($status) ) ? " WHERE mnumber = '{$mobile}' " : " WHERE status = '{$status}' ";
	$sql .= "ORDER BY id DESC";
	
	$result = mysqli_query( $conn, $sql );
	while( $row = mysqli_fetch_assoc($result) )
	{
		$rows[] = $row;
	}
	return $rows;
}

?>