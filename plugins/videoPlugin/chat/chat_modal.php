<?php 

@session_start();
require_once("../../../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('$site_url/login','_self')</script>";
}

$call_id = $input->post("call_id");

$get_call_rooms = $db->select("video_calls",['id'=>$call_id]);
$row_call_room = $get_call_rooms->fetch();

$receiver_id = $row_call_room->receiver_id;
$sender_id = $row_call_room->sender_id;

if($login_seller_id == $receiver_id){
  $seller_id = $sender_id;
}else{
  $seller_id = $receiver_id;
}

$select_seller = $db->select("sellers",array("seller_id" => $seller_id));
$row_seller = $select_seller->fetch();
$seller_user_name = $row_seller->seller_user_name;

?>

<div class="left-panel"><!--- right-panel Starts --->

  <div class="message-list-container"><!--- message-list-container Starts --->
    <div class="message-list-header">
      <span>Messages</span>
      <i class="anticon">
        <img src="<?= $site_url; ?>/plugins/videoPlugin/images/close.png" class="img-fluid" alt="close"></i>
    </div>
    <div class="ant-divider ant-divider-horizontal"></div>
    
    <div class="message-list-box"><!--- message-list-box Starts --->
      <?php include("chat_messages.php") ?>
    </div><!--- message-list-box Ends --->

    <p class="bg-danger p-2 text-white mv-0 d-none"><i class="fa fa-warning"></i> You seem to have typed word(s) that are in violation of our policy. No direct payments or emails allowed.</p>

    <p class="typing-status d-none mb-2"></p>

    <div class="message-control mb-1"><!--- message-control Starts --->
      <form action="" id="insert-message">
          <textarea placeholder="Type Your Message." name="message" class="form-control" onkeyup="matchWords(this,'chat_box')"></textarea>
          <input type="file" name="file" class="d-none" id="m-file">
          <div>
            <button type="submit" class="ant-btn message-send-btn ant-btn-success">Send</button>
            <button type="button" class="ant-btn attach message-send-btn ant-btn-primary mt-1">File</button>
          </div>
      </form>
    </div><!--- message-control Ends --->
  </div><!--- message-list-container Ends --->

</div><!--- right-panel Endss --->

<div id="chat_data_div"></div>

<link href="styles/emoji.css" rel="stylesheet">
<script src="js/emoji.js<?= '?v='.mt_rand(); ?>"></script>

<script 
id="chatModalJs" 
src="<?= $site_url; ?>/plugins/videoPlugin/js/chatModal.js" 
data-base-url="<?= $site_url; ?>" 
data-call-id="<?= $call_id; ?>"
data-login-seller-id="<?= $login_seller_id; ?>"
data-seller-id="<?= $seller_id; ?>"
data-seller-username="<?= $seller_user_name; ?>"
></script>