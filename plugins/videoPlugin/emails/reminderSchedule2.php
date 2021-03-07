<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

@session_start();
require_once("../../../includes/db.php");
require '../../../vendor/autoload.php';

$get_general_settings = $db->select("general_settings");
$row_general_settings = $get_general_settings->fetch();
$site_name = $row_general_settings->site_name;
$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;
$sel_schedules = $db->query("select * from order_schedules where status='accepted' AND email='0'");
while($row_schedules = $sel_schedules->fetch()){
	$order_id = $row_schedules->order_id;
	$schedule_time = $row_schedules->time;
	$schedule_timezone = $row_schedules->timezone;

	$get_order = $db->select("orders",array("order_id"=>$order_id));
	$row_order = $get_order->fetch();
	$order_id = $row_order->order_id;
	$order_number = $row_order->order_number;
	$proposal_id = $row_order->proposal_id;
	$buyer_id = $row_order->buyer_id;
	$seller_id = $row_order->seller_id;
	$order_number = $row_order->order_number;

	// Select Order Proposal Details ///
	$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposal = $select_proposal->fetch();
	$proposal_cat_id = $row_proposal->proposal_cat_id;

	/// Get Categories Details
	$get_cat = $db->select("categories",['cat_id'=>$proposal_cat_id]);
	$row_cat = $get_cat->fetch();
	$reminder_minutes = $row_cat->reminder_emails;

	if(!empty($schedule_time)){
		$order_call_time = new DateTime($schedule_time,new DateTimeZone($schedule_timezone));
		$since_start = $order_call_time->diff(new DateTime());
		$minutes = $since_start->days * 24 * 60;
		$minutes += $since_start->h * 60;
		$minutes += $since_start->i;
		
		if($order_call_time > new DateTime() AND $minutes == $reminder_minutes){
		  $select_buyer = $db->select("sellers",array("seller_id"=>$buyer_id));
		  $row_buyer = $select_buyer->fetch();
		  $buyer_user_name = $row_buyer->seller_user_name;
		  $buyer_email = $row_buyer->seller_email;
		  $select_seller = $db->select("sellers",array("seller_id"=>$seller_id));
		  $row_seller = $select_seller->fetch();
		  $seller_user_name = $row_seller->seller_user_name;
		  $seller_email = $row_seller->seller_email;
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
			$mail->addAddress($seller_email);
			$mail->addReplyTo($site_email_address,$site_name);
			$mail->isHTML(true);
	    $mail->Subject = "$site_name: Order Video Session Time Has Been Almost Arrived.";
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
			<h2> Hi Dear $seller_user_name </h2>
			<hr>
			<p class='lead'> Order Video Session Time Has Been Almost Arrived. You Can Video Call To Buyer Of This Order <a href='$site_url/order_detais?order_id=$order_id'>#$order_number</a> After $reminder_minutes Minutes. </p>
			</center>
			</div>
			</div>
			</body>
			</html>
EOT;
			$mail->send();

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
			$mail->addAddress($buyer_email);
			$mail->addReplyTo($site_email_address,$site_name);
			$mail->isHTML(true);
	    $mail->Subject = "$site_name: Order Video Session Time Has Been Almost Arrived.";
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
			<h2> Hi Dear $buyer_user_name </h2>
			<hr>
			<p class='lead'> Order Video Session Time Has Been Arrived.  You And Seller Of This Order <a href='$site_url/order_detais?order_id=$order_id'>#$order_number</a> Can Video Call Each Other After $reminder_minutes Minutes. </p>
			</center>
			</div>
			</div>
			</body>
			</html>
EOT;
			$mail->send();
		}
	}
}
?>