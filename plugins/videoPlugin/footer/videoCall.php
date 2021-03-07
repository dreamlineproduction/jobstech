<?php
if(!function_exists("escape")){
	function escape($value){
	  return htmlentities($value,ENT_QUOTES,'UTF-8');
	}
}
?>
<link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/video-call.css"/>
<link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/video-chat.css"/>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>

<div class="chat-modal"></div>
<div id="video-chat-modal"></div>
<div id="incoming-call"></div>
<div id="incoming-extend-time"></div>
<div id="wait"></div>

<?php 
  if(isset($_SESSION['seller_user_name'])){ 
  	
	$opentok_api_key = escape($row_general_settings->opentok_api_key);
	$get_admin = $db->select("admins");
	$admin_image = $get_admin->fetch()->admin_image;
	if(empty($admin_image)){
		$admin_image = "empty-image.png";
	}

?>
	<script 
	id="video-js" 
	src="<?= $site_url; ?>/plugins/videoPlugin/js/videoCall.js" 
	data-base-url="<?= escape($site_url); ?>" 
	data-seller-id="<?= escape($login_seller_id); ?>" 
	data-opentok-api-key="<?= escape($opentok_api_key); ?>"
	data-date="<?= escape(date("F d, Y")); ?>"
	data-admin-image="<?= $admin_image; ?>"
	></script>
<?php } ?>