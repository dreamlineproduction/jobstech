<?php 

@session_start();
require_once("../../../../includes/db.php");
require_once("../../../../functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

$order_id = $input->post("order_id");
$extend_time = $db->select("order_extend_time",array("order_id"=>$order_id,"status"=>"pending"));
$count_extend_time = $extend_time->rowCount();

if($count_extend_time === 0) {
	echo "failed";
}elseif($count_extend_time >= 1){
	
	$db->update("order_extend_time",['status'=>'received'],['order_id'=>$order_id,"status"=>"pending"]);

	$extend_time = $extend_time->fetch();
	if($extend_time->customAmount != 0){
		$amount = $extend_time->customAmount;
	}else{
		$amount = $extend_time->extended_minutes*$extend_time->price_per_minute;
	}

	$get_order = $db->select("orders",array("order_id"=>$order_id));
	$count_orders = $get_order->rowCount();
	$row_order = $get_order->fetch();
	$order_id = escape($row_order->order_id);
	$order_number = escape($row_order->order_number);
	$proposal_id = escape($row_order->proposal_id);
	$seller_id = escape($row_order->seller_id);
	$order_minutes = escape($row_order->order_minutes);

	$select_sender = $db->select("sellers",array("seller_id" => $seller_id));
	$row_sender = $select_sender->fetch();
	$name = escape($row_sender->seller_user_name);
	$image = getImageUrl2("sellers","seller_image",escape($row_sender->seller_image));

	if(empty($image)){
		$image = "empty-image.png";
	}

	include("../incomingExtendTimeModal.php");
}