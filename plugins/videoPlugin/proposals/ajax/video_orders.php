<?php

@session_start();
require_once("../../../../includes/db.php");

/*if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}*/

$date = $input->post("course_date");

$res_seller = $db->select('sellers', ['seller_user_name' => $_SESSION['seller_user_name']])->fetch();
$seller_id = $res_seller->seller_id;

$formattedDate = date('Y-m-d H:i:s', strtotime($date));

$orders = array();

//$orders_data = $db->select('orders', array('seller_id' => $seller_id, 'class_date' => $formattedDate))->fetchAll();

//$query = 'SELECT order_id, proposal_title, class_time, s.seller_name AS buyer_name FROM orders o LEFT JOIN proposals p ON o.proposal_id = p.proposal_id LEFT JOIN sellers s ON o.buyer_id = s.seller_id WHERE o.seller_id = ' . $seller_id . ' AND class_date = "' . $formattedDate . '"';
//$orders_data = $db->query($query)->fetchAll();
//foreach ($orders_data as $order_data) {
//    $orders[] = [
//        'order_id' => $order_data->order_id,
//        'proposal_title' => $order_data->proposal_title,
//        'class_time' => $order_data->class_time,
//        'buyer_name' => $order_data->buyer_name,
//    ];
//}

$query = 'SELECT COUNT(*) AS student_count, o.proposal_id, o.class_date, o.class_time, p.proposal_title, pv.max_seats FROM orders o LEFT JOIN proposals p ON o.proposal_id = p.proposal_id LEFT JOIN proposal_videosettings pv ON p.proposal_id = pv.proposal_id WHERE o.seller_id = ' . $seller_id . ' AND class_date = "' . $formattedDate . '" GROUP BY o.proposal_id';
$orders_data = $db->query($query)->fetchAll();
foreach ($orders_data as $order_data) {
    $orders[] = [
        'proposal_id' => $order_data->proposal_id,
        'proposal_title' => $order_data->proposal_title,
        'class_date' => $order_data->class_date,
        'class_time' => $order_data->class_time,
        'students_enrolled' => $order_data->student_count,
        'max_seats' => $order_data->max_seats
    ];
}

echo json_encode($orders);