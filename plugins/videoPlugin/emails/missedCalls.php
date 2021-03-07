<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("../../../includes/db.php");

$missed_calls = $db->select("missed_calls");
while($missed_call = $missed_calls->fetch()){
	$id = $missed_call->id;
	$call_id = $missed_call->call_id;
	$sender_id = $missed_call->sender_id;
	$receiver_id = $missed_call->receiver_id;
	$sendTime = new DateTime($missed_call->sendTime);
	// Receiver
	$row_receiver = $db->select("sellers",["seller_id"=>$receiver_id])->fetch();
	$receiver_user_name = $row_receiver->seller_user_name;
	$receiver_email = $row_receiver->seller_email;
	// Sender
	$row_sender = $db->select("sellers",["seller_id"=>$sender_id])->fetch();
	$sender_user_name = $row_sender->seller_user_name;
	// send Missed Call Email
	$currentDate = new DateTime();
	if($currentDate >= $sendTime){
		if(missedCall($receiver_user_name,$receiver_email,$sender_user_name) === true){
			if($db->delete("missed_calls",["id"=>$id])){
				echo "ok";
			}
		}else{
			echo "<h1>there is an error in code.</h1>";
			break;
		}
	}
}

function missedCall($receiver_user_name,$receiver_email,$sender_user_name){
	global $db;
	global $dir;

	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	require '../../../vendor/autoload.php';
	$mail = new PHPMailer;
	if($enable_smtp == "yes"){
		$mail->isSMTP();
		$mail->Host = $s_host;
		$mail->Port = $s_port;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = $s_secure;
		$mail->Username = $s_username;
		$mail->Password = $s_password;
	}
	$mail->setFrom($site_email_address,$site_name);
	$mail->addAddress($receiver_email);
	$mail->addReplyTo($site_email_address,$site_name);
	$mail->isHTML(true);
	$mail->Subject = "$site_name: You Have Missed A Video Call";
	$mail->Body = <<<EOT
	<html>
	<head>
	<style>
	.container {
	  background: rgb(238, 238, 238);
	  padding: 80px;
	}
	@media only screen and (max-device-width: 690px) {
		.container {
			background: rgb(238, 238, 238);
			width:100%;
			padding:1px;
		}
	}
	.box {
		background: #fff;
		margin: 0px 0px 30px;
		padding: 8px 20px 20px 20px;
		border:1px solid #e6e6e6;
		box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
	}
	h2{
		 margin-top: 0px;
		 margin-bottom: 0px;
	}
	.lead {
		margin-top: 10px;
		 margin-bottom: 0px;
		font-size:16px;
	}
	.btn{
		background:green;
		margin-top:20px;
		color:white !important;
		text-decoration:none;
		padding:10px 16px;
		font-size:18px;
		border-radius:3px;
	}
	hr{
		margin-top:20px;
		margin-bottom:20px;
		border:1px solid #eee;
	}
	@media only screen and (max-device-width: 690px) {
		.container {
			background: rgb(238, 238, 238);
			width:100%;
			padding:1px;
		}
		.btn{
			background:green;
			margin-top:15px;
			color:white !important;
			text-decoration:none;
			padding:10px;
			font-size:14px;
			border-radius:3px;
		}
		.lead {
			font-size:14px;
		}
	}
	</style>
	</head>
	<body class='is-responsive'>
	<div class='container'>
	<div class='box'>
	<center>
	<img class='logo' src='$site_url/images/$site_logo' width='100'>
	<h2> Hi Dear $receiver_user_name </h2>
	<hr>
	<p class='lead'> You Have Missed A Video Call From $sender_user_name </p>
	</center>
	</div>
	</div>
	</body>
	</html>
EOT;
	if($mail->send()){
		return true;
	}
}