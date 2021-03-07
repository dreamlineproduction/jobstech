<?php 

@session_start();
require_once("../../../../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$id = $input->post("id");
$order_id = $input->post("order_id");
$where = array("id"=>$id,"order_id"=>$order_id);
$extend_time = $db->select("order_extend_time",$where);
$count_extend_time = $extend_time->rowCount();

if($count_extend_time === 0){
	echo "failed";
}elseif($count_extend_time >= 1){
	$db->update("order_extend_time",['status'=>'accepted'],$where);
}