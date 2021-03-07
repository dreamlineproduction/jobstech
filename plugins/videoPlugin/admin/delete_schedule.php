<?php
@session_start();
if(!isset($_SESSION['admin_email'])){
	echo "<script>window.open('login','_self');</script>";
}else{
	if(isset($_GET['delete_schedule'])){
		$delete_id = $input->get('delete_schedule');
		$delete_schedule = $db->delete("video_schedules",array('id'=>$delete_id));
		if($delete_schedule){
	   	successRedirect("Video Schedule Deleted Successfully.","index?view_schedules");
		}
	}
}