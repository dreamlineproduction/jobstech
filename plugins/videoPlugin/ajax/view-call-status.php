<?php

@session_start();
require_once("../../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

$call_number = $input->post('call_number');

$get_video_calls = $db->select("video_calls",["call_number" => $call_number]);
$count_video_calls = $get_video_calls->rowCount();

if($count_video_calls !== 0) {

	$row_video_call = $get_video_calls->fetch();
	$order_id = $row_video_call->order_id;
	
	$get_order = $db->select("orders",array("order_id"=>$order_id));
	$count_orders = $get_order->rowCount();
	$row_order = $get_order->fetch();
	$order_minutes = $row_order->order_minutes;

	$data = array();
	$data['status'] = escape($row_video_call->status);
	$data['order_minutes'] = escape($order_minutes);

   echo json_encode($data);

}else{
	echo "failed";
}