<?php 

@session_start();

require_once("../../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

	$data = array("receiver_id" => $login_seller_id,"status" => "pending");

	$get_video_calls = $db->select("video_calls",$data);
	$count_video_calls = $get_video_calls->rowCount();

	if($count_video_calls === 0) {

		echo "failed";

	}elseif($count_video_calls >= 1){

		$row_call_room =  $get_video_calls->fetch();
		$data["order_id"] = escape($row_call_room->order_id);
		$data["sender_id"] = escape($row_call_room->sender_id);
		$data["call_number"] = escape($row_call_room->call_number);
		$data["call_token"] = escape($row_call_room->call_token);

		$db->update("video_calls",['status'=>'received'],['call_number'=>$row_call_room->call_number]);

		include("../chat/incoming_call.php");

	}

?>