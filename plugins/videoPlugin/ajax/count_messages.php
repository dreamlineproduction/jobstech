<?php

@session_start();

require_once("../../../includes/db.php");
require_once("../../../vendor/autoload.php");

$call_id = $input->post('call_id');

echo $db->query("select * from video_call_messages where call_id='$call_id' AND status='unread' AND Not sender_id='$login_seller_id'")->rowCount();

?>