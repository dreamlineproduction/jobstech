<?php

	$extendId = $_SESSION['extendId'];
	$order_id = $_SESSION['extendOrderId'];
	$proposal_id = $_SESSION['extendProposalId'];
	
	// Proposal
	$select_proposals = $db->select("proposals",array("proposal_id"=>$proposal_id));
	$row_proposal = $select_proposals->fetch();

	// Extend Time
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
	$data['name'] = $row_proposal->proposal_title;
	$data['qty'] = 1;
	$data['price'] = $amount;
	$data['sub_total'] = $amount;
	$data['total'] = $amount+$processing_fee;

	// $data['cancel_url'] = "$site_url/order_details?order_id=$order_id";

	$data['cancel_url'] = "$site_url/cancel_payment?reference_no=$reference_no";
	$data['redirect_url'] = "$site_url/plugins/videoPlugin/extendTime/charge/order/paypal?reference_no=$reference_no";