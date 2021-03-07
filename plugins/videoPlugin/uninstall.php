<?php

function delete_plugin(){
	global $db;
	$db->query("
	ALTER TABLE `cart` DROP `video`;

	ALTER TABLE `general_settings` 
		DROP `opentok_api_key`,
		DROP `opentok_api_secret`;

	ALTER TABLE `categories`
	  DROP `video`,
	  DROP `reminder_emails`,
	  DROP `missed_session_emails`,
	  DROP `warning_message`;

	ALTER TABLE `categories_children`
	  DROP `video`,
	  DROP `reminder_emails`,
	  DROP `missed_session_emails`,
	  DROP `warning_message`;

	ALTER TABLE `orders`
	  DROP `order_minutes`,
	  DROP `extended_minutes`,
	  DROP `extended_minutes_price`;

	DROP TABLE `chat_type_status`;
	DROP TABLE `missed_calls`;
	DROP TABLE `order_extend_time`;
	DROP TABLE `order_schedules`;
	DROP TABLE `proposal_videosettings`;
	DROP TABLE `video_calls`;
	DROP TABLE `video_call_messages`;
	DROP TABLE `video_schedules`;
	");
}

delete_plugin();
