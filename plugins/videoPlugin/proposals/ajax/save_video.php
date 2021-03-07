<?php
session_start();
require_once("../../config.php");
require_once("$dir/includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('../../login','_self')</script>";
}

if(isset($_POST["proposal_id"])){
  
  $proposal_id = strip_tags($input->post('proposal_id'));
  $delivery_id = strip_tags($input->post('delivery_id'));
  
  $data = $input->post();

  unset($data['proposal_id']);
  unset($data['delivery_id']);

  if(!isset($_POST['enable'])){
	$data['enable'] = 0;
  }

  $update_videosettings = $db->update("proposal_videosettings",$data,["proposal_id"=>$proposal_id]);
  
  $update_proposal = $db->update("proposals",["delivery_id"=>$delivery_id,"proposal_price"=>$data["price_per_minute"]],["proposal_id"=>$proposal_id]);

}