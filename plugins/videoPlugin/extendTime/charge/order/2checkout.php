<?php

session_start();
include("../../../../../includes/db.php");
include("../../../../../functions/payment.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

if(isset($_GET['extendTime'])){
	require_once("../extendTimePurchase.php");
}