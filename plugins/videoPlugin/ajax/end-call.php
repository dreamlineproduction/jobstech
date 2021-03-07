<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

@session_start();

require_once("../../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$get_general_settings = $db->select("general_settings");
$row_general_settings = $get_general_settings->fetch();
$site_name = $row_general_settings->site_name;
$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;

$call_number = $input->post('call_number');
$update = $db->query("update video_calls set status='ended' where status='pending' AND call_number='$call_number' OR status='received' AND call_number='$call_number'");
$count = $update->rowCount();

if($count == 1){

	$video_call = $db->select("video_calls",["call_number"=>$call_number,"status"=>"ended"])->fetch();
	$id = $video_call->id;
	$order_id = $video_call->order_id;
	$receiver_id = $video_call->receiver_id;
	// Order
	$row_order = $db->select("orders",["order_id"=>$order_id])->fetch();
	$proposal_id = $row_order->proposal_id;
	// Select Order Proposal Details //
	$select_proposal = $db->select("proposals",["proposal_id"=>$proposal_id]);
	$row_proposal = $select_proposal->fetch();
	$proposal_cat_id = $row_proposal->proposal_cat_id;
	/// Get Categories Details
	$get_cat = $db->select("categories",['cat_id'=>$proposal_cat_id]);
	$row_cat = $get_cat->fetch();
	$missedEmailTime = $row_cat->missed_session_emails;

	// Insert Data Into Missed Call
	$date = date("F d, Y h:i:s");
	if(!empty($missedEmailTime)){
		$sendTime = date("M d, Y H:i:s", strtotime("$date + $missedEmailTime minutes"));
	}else{
		$sendTime = $date;
	}
	$missed_call = $db->insert("missed_calls",["call_id"=>$id,"sender_id"=>$login_seller_id,"receiver_id"=>$receiver_id,"sendTime"=>$sendTime]);
	if($missed_call){
		echo "ok";
	}

}else{
	echo "ok";
}