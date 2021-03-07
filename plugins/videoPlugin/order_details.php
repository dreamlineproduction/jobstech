<?php

	function escape($value){
	  return htmlentities($value,ENT_QUOTES,'UTF-8');
	}

  // Get Proposal Video Details
  $proposal_videosettings = $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id))->fetch();
  $enableVideo = escape($proposal_videosettings->enable);
  $days_within_scheduled = escape($proposal_videosettings->days_within_scheduled);

  // extendTime
  if($seller_id == $login_seller_id){
    $where = array("order_id"=>$order_id,"sellerExtended"=>0,"buyerExtended"=>0,"status"=>"accepted");
    $extend_time = $db->delete("order_extend_time",$where);
  }