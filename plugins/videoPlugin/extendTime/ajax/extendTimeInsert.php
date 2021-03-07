<?php
@session_start();
require_once("../../../../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('$site_url/login','_self')</script>";
}

$order_id = $input->post("order_id");
$proposal_id = $input->post("proposal_id");
$extended_minutes = $input->post('extended_minutes');

if(isset($_POST["customAmount"]) and !empty($_POST["customAmount"])){
  $customAmount = $input->post('customAmount');
  $price_per_minute = 0;
}else{
  $proposal_videosettings = $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id))->fetch();
  $price_per_minute = $proposal_videosettings->price_per_minute;
  $customAmount = 0;
}

$data = array(
  "order_id"=>$order_id,
  "extended_minutes"=>$extended_minutes,
  "price_per_minute"=>$price_per_minute,
  "customAmount"=>$customAmount,
  "status"=>"pending",
);

if($db->insert("order_extend_time",$data)){
  echo 1;
}