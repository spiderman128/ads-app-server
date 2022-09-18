<?php
require_once('functions.php');
require_once('dbconnection.php');
require_once('includes/init.php');

session_start();
//destroy the session
session_unset();
//redirect to login page
header("location: login.php");
?>