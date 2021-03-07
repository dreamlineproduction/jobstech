<?php 

@session_start();
require_once("../../config.php");
require_once("$dir/includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$order_id = $input->post("order_id");
$extend_time = $db->select("order_extend_time",array("order_id"=>$order_id,"status"=>"accepted"));
$count_extend_time = $extend_time->rowCount();
if($count_extend_time === 0) {
	echo "failed";
}elseif($count_extend_time >= 1){
	echo "accepted";
}