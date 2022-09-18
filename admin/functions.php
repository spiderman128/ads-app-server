<?php

function snack ($type, $text)
{
	echo "<p class='snackbar {$type}'>{$text}</p>";
}

function compactify ($connection, $field)
{
	$compact_result = strip_tags($field);
	return mysqli_real_escape_string($connection, $compact_result);
}

function start_admin_session ($pass)
{
	$_SESSION['token'] = md5($pass);
}

function is_admin_session ($pass)
{
	return $_SESSION['token'] == md5($pass);
}

function get_admin ($conn, $password)
{
	
	$sql = $sql = "SELECT * FROM admins WHERE password = '{$password}' ";
	$result = mysqli_query($conn, $sql);
	
	if ( mysqli_num_rows($result) != 1 ) return null;
	return mysqli_fetch_assoc($result);
}


?>