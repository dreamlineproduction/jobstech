<?php

session_start();
include("../../../../../includes/db.php");
include("../../../../../functions/payment.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

if(!isset($_GET['reference_no'])){
   echo "<script> window.open('$site_url/index','_self'); </script>";
}

$reference_no = $input->get('reference_no');

$get_order = $db->select("temp_orders",['reference_no'=>$reference_no,'method'=>'coinpayments']);
$row_order = $get_order->fetch();
$count_order = $get_order->rowCount();

if($count_order == 0){
   echo "<script> window.open('$site_url/index','_self'); </script>";
}

$reference_no = $row_order->reference_no;
$buyer_id = $row_order->buyer_id;
$content_id = $row_order->content_id;
$qty = $row_order->qty;
$price = $row_order->price;
$delivery_id = $row_order->delivery_id;
$revisions = $row_order->revisions;
$minutes = $row_order->minutes;
$extras = $row_order->extras;
$currency = $row_order->currency;
$type = $row_order->type;
$message = $row_order->message;
$status = $row_order->status;

if($buyer_id != $login_seller_id){
   echo "<script> window.open('$site_url/index','_self'); </script>";
}

if($status != "completed"){
   echo "<script> window.open('$site_url/index','_self'); </script>";
}

if(isset($_GET['extendTime']) & $type == "orderExtendTime" & $status == "completed"){

	$extend_time = $db->select("order_extend_time",["id"=>$content_id])->fetch();
	$order_id = $extend_time->order_id;

	$get_order = $db->select("orders",array("order_id" => $order_id));
	$row_order = $get_order->fetch();
	$proposal_id = $row_order->proposal_id;

	$_SESSION['extendId'] = $content_id;
	$_SESSION['extendOrderId'] = $order_id;
	$_SESSION['extendProposalId'] = $proposal_id;
	
	$delete = $db->delete("temp_orders",array('reference_no'=>$reference_no));
   
	require_once("../extendTimePurchase.php");

}