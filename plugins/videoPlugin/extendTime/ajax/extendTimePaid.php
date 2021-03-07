<?php 

@session_start();
require_once("../../../../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$order_id = $input->post("order_id");
$login_seller_id = $input->post("login_seller_id");
$get_order = $db->select("orders",array("order_id"=>$order_id));
$count_orders = $get_order->rowCount();
$row_order = $get_order->fetch();
$seller_id = $row_order->seller_id;
$buyer_id = $row_order->buyer_id;
$order_minutes = $row_order->order_minutes;

if($login_seller_id == $seller_id){
	$where = array("order_id"=>$order_id,"sellerExtended"=>0,"status"=>"paid");
}elseif($login_seller_id == $buyer_id){
	$where = array("order_id"=>$order_id,"buyerExtended"=>0,"status"=>"paid");
}
$extend_time = $db->select("order_extend_time",$where);
$count_extend_time = $extend_time->rowCount();
if($count_extend_time === 0){
	echo "failed";
}elseif($count_extend_time >= 1){
	if($login_seller_id == $seller_id){
		$db->update("order_extend_time",['sellerExtended'=>1],$where);
		$sender_id = $buyer_id;
		$reason = "extendTimeAccepted";
	}elseif($login_seller_id == $buyer_id){
		$db->update("order_extend_time",['buyerExtended'=>1],$where);
		$sender_id = $buyer_id;
		$reason = "buyerExtendTimeAccepted";
	}
	$notification = array(
		"receiver_id"=>$login_seller_id,
		"sender_id"=>$sender_id,
		"order_id"=>$order_id,
		"reason"=>$reason,
		"date"=>date("F d, Y h:i:s"),
		"status"=>"unread"
	);
	if($db->insert("notifications",$notification)){
		echo $order_minutes;
	}
}