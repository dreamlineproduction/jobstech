<?php

	@session_start();
	require_once("../../../includes/db.php");

	if(!isset($_SESSION['seller_user_name'])){
		echo "<script>window.open('$site_url/login','_self')</script>";
	}
		
	$data = $input->post('data');
	unset($data['warning_message']);
	$db->update("video_calls",['status'=>'accepted'],$data);
	echo "ok";