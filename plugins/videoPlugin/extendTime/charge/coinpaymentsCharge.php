<?php

session_start();
include("../../../../includes/db.php");
include("$dir/functions/payment.php");
require_once("$dir/functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

if(isset($_POST['coinpayments'])){
	
	$extendId = $_SESSION['extendId'];
	$order_id = $_SESSION['extendOrderId'];
	$proposal_id = $_SESSION['extendProposalId'];

	// extend_time
	$extend_time = $db->select("order_extend_time",array("id"=>$extendId,"order_id"=>$order_id))->fetch();
	if($extend_time->customAmount != 0){
		$amount = $extend_time->customAmount;
	}else{
		$amount = $extend_time->extended_minutes*$extend_time->price_per_minute;
	}

	$processing_fee = processing_fee($amount);

	$reference_no = mt_rand();

	$data = [];
	$data['type'] = "orderExtendTime";
	$data['content_id'] = $_SESSION['extendId'];
	$data['reference_no'] = $reference_no;
	$data['name'] = "Order Video Call Extra Minutes Payment";
	$data['qty'] = 1;
	$data['price'] = $amount;
	$data['sub_total'] = $amount;
	$data['total'] = $amount+$processing_fee;

	$data['cancel_url'] = "$site_url/cancel_payment?reference_no=$reference_no";

	$payment = new Payment();
	$payment->coinpayments($data,$processing_fee);
	
}else{
	echo "<script>window.open('index','_self')</script>";
}