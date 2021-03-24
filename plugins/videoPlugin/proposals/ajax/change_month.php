<?php

@session_start();
require_once("../../../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$date = $input->post("course_date");
$proposal_id = $input->post("proposal");

$formattedDate = date('Y-m-d H:i:s', strtotime($date));

$res = $db->select('class_remainingseats', array('proposal_id' => $proposal_id, 'class_date' => $formattedDate))->fetch();
if (empty($res)) {
    $video_settings_res = $db->select('proposal_videosettings', array('proposal_id' => $proposal_id))->fetch();
    $max_seats = $video_settings_res->max_seats;

    $db->insert('class_remainingseats', array('proposal_id' => $proposal_id, 'class_date' => $formattedDate, 'remaining_seats' => $max_seats));

    echo json_encode(array(
        'available' => true
    ));
} else {
    if ($res->remaining_seats > 0) {
        echo json_encode(array(
            'available' => true
        ));
    } else {
        echo json_encode(array(
            'available' => false
        ));
    }
}