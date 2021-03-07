<?php

session_start();
include("../../../../includes/db.php");
include("../../../../functions/payment.php");
require_once("../../../../functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

if(isset($_POST['paystack'])){
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

	$payment = new Payment();
	$data = [];
	$data['type'] = 'orderExtendTime';
	$data['content_id'] = $_SESSION['extendId'];
	$data['reference_no'] = $reference_no;
	$data['price'] = $amount;
	$data['qty'] = 1;
	$data['sub_total'] = $amount;
	$data['total'] = $amount+$processing_fee;
	$data['redirect_url'] = "$site_url/plugins/videoPlugin/extendTime/charge/order/paystack?extendTime=1&reference_no=$reference_no";
	
	$payment->paystack($data);
}else{
	echo "<script>window.open('index','_self')</script>";
}

?>