<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

@session_start();

require_once("../../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login','_self')</script>";
}

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

$data = array("receiver_id" => $login_seller_id,"status" => "ended");
$get_video_calls = $db->select("video_calls",$data);
$count_video_calls = $get_video_calls->rowCount();

if($count_video_calls === 0) {
	echo "failed";
}elseif($count_video_calls >= 1){
	$row_call_room = $get_video_calls->fetch();
	$id = $row_call_room->id;
	$sender_id = $row_call_room->sender_id;

	$db->delete("video_calls",["status" => "ended", "call_number" => $row_call_room->call_number]);
	$db->delete("video_call_messages",["call_id" => $id]);
	$db->delete("chat_type_status",["call_id" => $id]);

	$select_sender = $db->select("sellers",array("seller_id"=>$sender_id));
	$row_sender = $select_sender->fetch();
	$sender_user_name = escape($row_sender->seller_user_name);
	$sender_image = getImageUrl2("sellers","seller_image",escape($row_sender->seller_image));

	if (empty($sender_image)) {
		$sender_image = "empty-image.png";
	}

	$seller_user_name = escape($row_login_seller->seller_user_name);
	$seller_email = escape($row_login_seller->seller_email);

	include("../chat/ended_call.php");
}