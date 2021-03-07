<?php
@session_start();
require_once("../../../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

$opentok_api_key = $row_general_settings->opentok_api_key;
$opentok_api_secret = $row_general_settings->opentok_api_secret;

function getOpentokCredentials(){	
	global $opentok_api_key;
	global $opentok_api_secret;
  	
  	require_once("../../../vendor/autoload.php");
	$opentok = new OpenTok\OpenTok($opentok_api_key,$opentok_api_secret);
	$session = $opentok->createSession(array('mediaMode' => OpenTok\MediaMode::ROUTED));
	$sessionId = $session->getSessionId();
	$token = generateToken($sessionId,$opentok);
  	return array("sessionId" => $sessionId, "token" => $token);
}

function generateToken($sessionId,$opentok = ''){
	if(empty($opentok)){
		global $opentok_api_key;
		global $opentok_api_secret;
	  	
		require_once("../../../vendor/autoload.php");
		$opentok = new OpenTok\OpenTok($opentok_api_key,$opentok_api_secret);
	}
	$token = $opentok->generateToken($sessionId, array('expireTime' => time()+(29 * 24 * 60 * 60)));
  	return $token;
}

$result = $input->post("data");

$where_array = ["order_id"=>$result["order_id"],"sender_id"=>$result["sender_id"],"receiver_id"=>$result["receiver_id"]];
$get_call_rooms = $db->select("video_calls",$where_array);
$count_call_rooms = $get_call_rooms->rowCount();

if($count_call_rooms === 0){
	$OpentokCredentials = getOpentokCredentials();
	$where_array["call_number"] = escape($OpentokCredentials["sessionId"]);
	$where_array["call_token"] = escape($OpentokCredentials["token"]);
	$where_array["status"] = "pending";
  	$db->insert("video_calls",$where_array);
	$where_array["id"] = escape($db->lastInsertId());
}else{

	$row_call_room = $get_call_rooms->fetch();
	
	$token = base64_decode(str_replace("T1==","",$row_call_room->call_token));
	$url = parse_url($token);
	parse_str($url['path'], $url);
	$expire_time = new DateTime(date('F d, Y h:i A',$url['expire_time']));

	if(new DateTime() >= $expire_time){
		$where_array["call_token"] = generateToken($row_call_room->call_number);
	}else{
		$where_array["call_token"] = escape($row_call_room->call_token);
	}

	$where_array["id"] = escape($row_call_room->id);
	$where_array["call_number"] = escape($row_call_room->call_number);
	$where_array["status"] = escape($row_call_room->status);

  	$db->update("video_calls",["call_token"=>$where_array["call_token"],'status'=>'pending'],['call_number'=>$row_call_room->call_number]);

}

include("../chat/video_chat_modal.php");