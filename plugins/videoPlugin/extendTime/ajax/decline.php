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

	$get_order = $db->select("orders",array("order_id"=>$order_id));
	$count_orders = $get_order->rowCount();
	$row_order = $get_order->fetch();
	$seller_id = $row_order->seller_id;
	$buyer_id = $row_order->buyer_id;

	if($db->update("order_extend_time",['status'=>'declined'],$where)){
		$notification = array(
			"receiver_id"=>$seller_id,
			"sender_id"=>$buyer_id,
			"order_id"=>$order_id,
			"reason"=>"extendTimeDeclined",
			"date"=>date("F d, Y h:i:s"),
			"status"=>"unread"
		);
    if($db->insert("notifications",$notification)){
			echo 1;
		}
	}

}