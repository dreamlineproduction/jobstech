<?php 

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

require_once("../../../includes/db.php");

if(isset($_POST['call_id'])){
  $call_id = $input->post("call_id");
}

$get_messages = $db->select("video_call_messages",array("call_id" => $call_id));
$count_messages = $get_messages->rowCount();

if($count_messages == 0){
  echo "<p class='text-center'>No Messages Found.</p>";
}

while($row_messages = $get_messages->fetch()){

$id = escape($row_messages->id);
$sender_id = escape($row_messages->sender_id);
$message = $row_messages->message;
$file = escape($row_messages->file);

$select_sender = $db->select("sellers",array("seller_id" => $sender_id));
$row_sender = $select_sender->fetch();
$sender_user_name = escape($row_sender->seller_user_name);
$sender_image = escape($row_sender->seller_image);

$sender_image = getImageUrl2("sellers","seller_image",escape($row_sender->seller_image));

if($sender_id == $login_seller_id){
  $div_calss = "message-item-sender";
}else{
  $div_calss = "message-item";
}

if($login_seller_id != $sender_id){
  $db->update("video_call_messages",["status"=>"read"],["id"=>$id]);
}

?>

<div class="<?= $div_calss; ?> mb-1">
    <div class="message-label">
      <img src="<?= $sender_image; ?>" class="rounded-circle mb-1" width="30"> <?= $sender_user_name; ?>
    </div>
    <div class="message-detail">
      <?= $message; ?>
      <?php if(!empty($file)){ ?>
        <p class="mt-1 mb-0">
          <a class="text-primary" download="" href="<?= $site_url; ?>/plugins/videoPlugin/chat_files/<?= $file; ?>"><i class="fa fa-download"></i> <?= $file; ?></a>
        </p>
      <?php } ?>
    </div>
</div>

<?php } ?>