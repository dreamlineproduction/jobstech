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

if(isset($_POST['dusupay'])){
	
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

	$data = [];
	$data['type'] = "orderExtendTime";

	if(isset($_POST['account_number'])){
		$account_number = $input->post('account_number');
		$data['account_number'] = $account_number;
	}
	
	if(isset($_POST['voucher'])){
		$voucher = $input->post('voucher');
		$data['voucher'] = $voucher;
	}

	$data['content_id'] = $_SESSION['extendId'];
	$data['name'] = "Proposal Payment";
	$data['qty'] = 1;
	$data['price'] = $amount;
	$data['amount'] = $amount+$processing_fee;
	// $data['redirect_url'] = "$site_url/plugins/videoPlugin/extendTime/charge/order/dusupay?extendTime=1";

	$payment = new Payment();
	$payment->dusupay($data);

}else{
	echo "<script>window.open('index','_self')</script>";
}