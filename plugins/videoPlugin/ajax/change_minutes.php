<?php

@session_start();
require_once("../../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$order_id = $input->post("order_id");
$order_minutes = $input->post("order_minutes");
if(strpos($order_minutes, 'N') === false){
	if($db->update("orders",["order_minutes"=>$order_minutes],["order_id"=>$order_id])){
		echo "updated";
	}
}