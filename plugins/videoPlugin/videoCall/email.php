<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendVideoSessionTimeEmail($sender_id,$receiver_id,$order_id,$time){
	global $db;
	global $dir;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $verification_code;
	global $u_name;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	// sender
	$row_sender = $db->select("sellers",array("seller_id" => $sender_id))->fetch();
	$sender_user_name = $row_sender->seller_user_name;
	// receiver
	$row_receiver = $db->select("sellers",array("seller_id" => $receiver_id))->fetch();
	$receiver_user_name = $row_receiver->seller_user_name;
	$receiver_email = $row_receiver->seller_email;

	require "$dir/vendor/autoload.php";
	$mail = new PHPMailer(true);
	try {
	 //Server settings
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
		$mail->Subject = "$site_name: $sender_user_name has set the video session time to $time.";
		$mail->Body = <<<EOT
		<html>
		<head>
		<style>
		.container {
			background: rgb(238, 238, 238);
			padding: 80px;
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
		@media only screen and (max-device-width: 690px){
	    .container{
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
				display:block;
		  }
		  .lead {
				font-size:14px;
			}
	  	}
		</style>
		</head>
		<body>
		<div class='container'>
		<div class='box'>
		<center>
		<img class='logo' src='$site_url/images/$site_logo' width='100' >
		<h2> Hi $receiver_user_name, $sender_user_name has set the video session time to $time.</h2>
		<p class='lead'> Are you willing to do video call sessions that time. </p>
		<hr>
		<a href='$site_url/order_details?order_id=$order_id' class='btn'>Accept Schedule</a>
		<a href='$site_url/order_details?order_id=$order_id' class='btn'>Propose Another Schedule</a>
		<p class='lead'></p>
		</center>
		</div>
		</div>
		</body>
		</html>
EOT;
	  if($mail->send()){
	 		return true;
		}
	}catch(Exception $e){
		return true;
	}
}

function sendAcceptScheduleEmail($sender_id,$receiver_id,$order_id,$time){
	global $db;
	global $dir;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $verification_code;
	global $u_name;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	// sender
	$row_sender = $db->select("sellers",array("seller_id" => $sender_id))->fetch();
	$sender_user_name = $row_sender->seller_user_name;
	// receiver
	$row_receiver = $db->select("sellers",array("seller_id" => $receiver_id))->fetch();
	$receiver_user_name = $row_receiver->seller_user_name;
	$receiver_email = $row_receiver->seller_email;

	require "$dir/vendor/autoload.php";
	$mail = new PHPMailer(true);
	try {
	 //Server settings
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
		$mail->Subject = "$site_name: $sender_user_name has accepted your video session time: ($time).";
		$mail->Body = <<<EOT
		<html>
		<head>
		<style>
		.container {
			background: rgb(238, 238, 238);
			padding: 80px;
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
		@media only screen and (max-device-width: 690px){
	    .container{
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
		<body>
		<div class='container'>
		<div class='box'>
		<center>
		<img class='logo' src='$site_url/images/$site_logo' width='100' >
		<h2> Hi $receiver_user_name, $sender_user_name has accepted your video session time: ($time).</h2>
		<hr>
		<a href='$site_url/order_details?order_id=$order_id' class='btn'>View Order</a>
		<p class='lead'></p>
		</center>
		</div>
		</div>
		</body>
		</html>
EOT;
	  if($mail->send()){
	 		return true;
		}
	}catch(Exception $e){
	 return true;
	}
}

function sendAcceptScheduleEmailv2($sender_id,$receiver_id,$order_id,$time,$receiverType){
	global $db;
	global $dir;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $verification_code;
	global $u_name;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	// sender
	$row_sender = $db->select("sellers",array("seller_id" => $sender_id))->fetch();
	$sender_user_name = $row_sender->seller_user_name;
	$sender_email = $row_sender->seller_email;
	// receiver
	$row_receiver = $db->select("sellers",array("seller_id" => $receiver_id))->fetch();
	$receiver_user_name = $row_receiver->seller_user_name;
	$receiver_email = $row_receiver->seller_email;

	require "$dir/vendor/autoload.php";
	$mail = new PHPMailer(true);
	try {
	 //Server settings
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
		$mail->addAddress($sender_email);
		$mail->addReplyTo($site_email_address,$site_name);
		$mail->isHTML(true);
		$mail->Subject = "$site_name: $sender_user_name, You and your $receiverType have accepted the video session time: ($time).";
		$mail->Body = <<<EOT
		<html>
		<head>
		<style>
		.container {
			background: rgb(238, 238, 238);
			padding: 80px;
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
		@media only screen and (max-device-width: 690px){
	    .container{
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
		<body>
		<div class='container'>
		<div class='box'>
		<center>
		<img class='logo' src='$site_url/images/$site_logo' width='100' >
		<h2> Hi $sender_user_name, You and your $receiverType have accepted the video session time: ($time).</h2>
		<hr>
		<a href='$site_url/order_details?order_id=$order_id' class='btn'>View Order</a>
		<p class='lead'></p>
		</center>
		</div>
		</div>
		</body>
		</html>
EOT;
	  if($mail->send()){
	 		return true;
		}
	}catch(Exception $e){
	 return true;
	}
}

function sendProposeAnotherScheduleEmail($sender_id,$receiver_id,$order_id,$time){
	global $db;
	global $dir;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $verification_code;
	global $u_name;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	// sender
	$row_sender = $db->select("sellers",array("seller_id" => $sender_id))->fetch();
	$sender_user_name = $row_sender->seller_user_name;
	// receiver
	$row_receiver = $db->select("sellers",array("seller_id" => $receiver_id))->fetch();
	$receiver_user_name = $row_receiver->seller_user_name;
	$receiver_email = $row_receiver->seller_email;

	require "$dir/vendor/autoload.php";
	$mail = new PHPMailer(true);
	try {
	 //Server settings
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
		$mail->Subject = "$site_name: $sender_user_name has proposed another schedule: ($time).";
		$mail->Body = <<<EOT
		<html>
		<head>
		<style>
		.container {
			background: rgb(238, 238, 238);
			padding: 80px;
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
		@media only screen and (max-device-width: 690px){
	    .container{
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
		<body>
		<div class='container'>
		<div class='box'>
		<center>
		<img class='logo' src='$site_url/images/$site_logo' width='100' >
		<h2> Hi $receiver_user_name, $sender_user_name has proposed another schedule: ($time).</h2>
		<hr>
		<a href='$site_url/order_details?order_id=$order_id' class='btn'>View Order</a>
		<p class='lead'></p>
		</center>
		</div>
		</div>
		</body>
		</html>
EOT;
	  if($mail->send()){
	 		return true;
		}
	}catch(Exception $e){
	 return true;
	}
}