<?php

require_once("../../../includes/db.php");
if($_POST['status'] == "typing"){
	
	$seller_id = $input->post('seller_id');
	$call_id = $input->post('call_id');
	$time = date("Y-m-d H:i:s");

	$status = $input->post('status');
	$select = $db->select("chat_type_status",array("seller_id"=>$seller_id,"call_id"=>$call_id));
	$count = $select->rowCount();
	if($count == 0){
		$insert = $db->insert("chat_type_status",array("seller_id"=>$seller_id,"call_id"=>$call_id,"time"=>$time,"status"=>$status));
	}else{
		$update = $db->update("chat_type_status",array("time"=>$time,"status"=>$status),array("seller_id"=>$seller_id,"call_id"=>$call_id));
	}

}elseif($_POST['status'] == "untyping"){

	$seller_id = $input->post('seller_id');
	$call_id = $input->post('call_id');

	$status = $input->post('status');
	$update = $db->update("chat_type_status",array("status"=>$status),array("seller_id"=>$seller_id,"call_id"=>$call_id));

}