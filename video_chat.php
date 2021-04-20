<?php
@session_start();
require_once("./includes/db.php");
if (!isset($_SESSION['seller_user_name'])) {
    echo "<script>window.open('$site_url/login','_self')</script>";
}

if (!isset($_GET['class']) || empty($_GET['class'])) {
    echo "<script>window.open('$site_url','_self')</script>";
}

$class_slug = escape($_GET['class']);

function escape($value)
{
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
}

$opentok_api_key = $row_general_settings->opentok_api_key;
$opentok_api_secret = $row_general_settings->opentok_api_secret;

function getOpentokCredentials()
{
    global $opentok_api_key;
    global $opentok_api_secret;

    require_once("vendor/autoload.php");
    $opentok = new OpenTok\OpenTok($opentok_api_key, $opentok_api_secret);
    $session = $opentok->createSession(array('mediaMode' => OpenTok\MediaMode::ROUTED));
    $sessionId = $session->getSessionId();
    $token = generateToken($sessionId, $opentok);
    return array("sessionId" => $sessionId, "token" => $token);
}

function generateToken($sessionId, $opentok = '')
{
    if (empty($opentok)) {
        global $opentok_api_key;
        global $opentok_api_secret;

        require_once("vendor/autoload.php");
        $opentok = new OpenTok\OpenTok($opentok_api_key, $opentok_api_secret);
    }
    $token = $opentok->generateToken($sessionId, array('expireTime' => time() + (3 * 60 * 60)));
    return $token;
}

//$result = $input->post("data");

$result = $db->select('video_classes', ['slug' => $class_slug]);
if ($result->rowCount() === 0) {
    echo "<script>window.open('$site_url','_self')</script>";
}
$class_info = $result->fetch();
$seller_id = $class_info->seller_id;

$res_seller = $db->select('sellers', ['seller_user_name' => $_SESSION['seller_user_name']])->fetch();
$logged_in_user_id = $res_seller->seller_id;

if ($logged_in_user_id == $seller_id) {
    if (empty($class_info->call_token)) {
        $OpentokCredentials = getOpentokCredentials();
        $where_array["call_number"] = escape($OpentokCredentials["sessionId"]);
        $where_array["call_token"] = escape($OpentokCredentials["token"]);
        $where_array["status"] = "ongoing";
        $db->update('video_classes', $where_array, ['slug' => $class_slug]);
        $where_array["id"] = escape($db->lastInsertId());
    } else {
        $where_array["call_number"] = $class_info->call_number;
        $where_array["call_token"] = $class_info->call_token;
    }
} else {
    $res_class_buyers = $db->select('video_class_buyers', ['slug' => $class_slug, 'buyer_id' => $logged_in_user_id])->fetch();
    if (empty($res_class_buyers)) {
        echo "<script>window.open('$site_url','_self')</script>";
    } else {
        $where_array["call_number"] = $class_info->call_number;
        $where_array["call_token"] = $class_info->call_token;
    }
}

//$where_array = ["order_id"=>$links_info->order_id,"seller_id"=> $seller_id];
//$get_orders = $db->select('orders', $where_array);
//die('<pre>' . print_r($get_orders->fetchAll(), true) . '</pre>');

/*$where_array = ["order_id"=>$result["order_id"],"sender_id"=>$result["sender_id"],"receiver_id"=>$result["receiver_id"]];
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

//

$login_user_id = $login_seller_id;
if ($login_user_id == $where_array['receiver_id']) {
    $user_id = $where_array['sender_id'];
} else {
    $user_id = $where_array['receiver_id'];
}

$select_seller = $db->select("sellers", array("seller_id" => $user_id));
$row_seller = $select_seller->fetch();
$name = escape($row_seller->seller_user_name);
$image = getImageUrl2("sellers", "seller_image", escape($row_seller->seller_image));

if (empty($image)) {
    $image = "empty-image.png";
}

$get_order = $db->select("orders", array("order_id" => $where_array['order_id']));
$count_orders = $get_order->rowCount();
$row_order = $get_order->fetch();
$order_id = escape($row_order->order_id);
$seller_id = escape($row_order->seller_id);
$buyer_id = escape($row_order->buyer_id);
$proposal_id = escape($row_order->proposal_id);
$order_minutes = escape($row_order->order_minutes);

if ($login_seller_id == $buyer_id) {
    $activeUser = "buyer";
} else {
    $activeUser = "seller";
}*/

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
    <title><?= $site_name; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $site_desc; ?>">
    <meta name="keywords" content="<?= $site_keywords; ?>">
    <meta name="author" content="<?= $site_author; ?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="styles/bootstrap.css" rel="stylesheet">
    <link href="styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
    <link href="styles/styles.css" rel="stylesheet">
    <link href="styles/proposalStyles.css" rel="stylesheet">
    <link href="styles/categories_nav_styles.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="styles/owl.carousel.css" rel="stylesheet">
    <link href="styles/owl.theme.default.css" rel="stylesheet">
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/chosen.css">
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="js/ie.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <?php if (!empty($site_favicon)) { ?>
        <link rel="shortcut icon" href="<?= $site_favicon; ?>" type="image/x-icon">
    <?php } ?>

    <link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/video-call.css"/>
    <link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/video-call.css"/>
    <link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/vanilla-calendar-min.css"/>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script src="<?= escape($site_url); ?>/plugins/videoPlugin/js/vanilla-calendar-min.js"></script>
    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
</head>
<body class="is-responsive">
<div class="container"> <!-- Container starts -->
    <div class="modal-body"><!-- modal-body Starts -->
        <h5 class="clearfix">
            <!--<span class="float-left d-none d-lg-block">
            Video Chat with <span class="text-success"><? /*= $name; */ ?></span>
        </span>-->
            <span class="float-right">
           <input type="hidden" id="intervalStatus" value="run"/>
           <input type="hidden" id="activeUser" value="<?= $activeUser; ?>"/>
           <input type="hidden" id="orderId" value="<?= $where_array['order_id']; ?>"/>
           <input type="hidden" id="orderMinutes" value="<?= $order_minutes; ?>"/>
                <!--           <input type="hidden" id="warningMessage" value="-->
                <? //= $result['warning_message']; ?><!--"/>-->
           <input type="hidden" id="sessionId" name="room_number" value="<?= $where_array['call_number']; ?>"/>
           <input type="hidden" id="token" name="call_token" value="<?= $where_array['call_token']; ?>"/>
           <button type="submit" class="leave-button btn btn-small btn-danger text-white">
           <i class="fa fa-times-circle"></i> End Call
           </button>
       </span>
        </h5>
        <div class="row mb-2 mt-3 justify-content-center"><!--- row mb-2 mt-3 Starts --->

            <div class="col-md-6">
                <div id="publisher" class="w-100 h-100 border"></div>
                <div id="publisher-screen" class="w-100 h-100 d-none border"></div>
            </div>

            <div id="subscriber" class="col-md-6 bg-dark"><!--- col-md-6 bg-dark Starts --->
                <div id="subscriber-stream" class="w-100 h-100 border d-none"></div>
                <div id="subscriber-screen" class="w-100 h-100 d-none border"></div>
            </div><!--- col-md-6 bg-dark Ends --->

        </div><!--- row mb-2 mt-3 Ends --->
        <br>
        <div class="lead text-center">
            <span class="mt-3">Video Call Minutes : <span
                        id="completeOrderMinutes"><?= $order_minutes; ?></span> </span>
            &nbsp; | &nbsp;
            <span class="remaining-minutes">Remaining Minutes : </span> <span
                    class="countdown"><?= $order_minutes; ?></span>
        </div>
        <div class="text-center mt-4 mb-4">

            <?php if ($buyer_id == $login_seller_id) { ?>
                <button class="btn start-archive btn-success mb-2">
                    <i class="fa fa-play"></i> Start Video Call Recording
                </button>
                <button class="btn stop-archive btn-danger mb-2">
                    <i class="fa fa-pause"></i> Stop Video Call Recording
                </button>
                <button class="btn download-archive btn-success mb-2">
                    <i class="fa fa-download"></i> Download Recorded Video Call
                </button>
            <?php } ?>

            <button class="btn btn-success start-screen-share mb-2">
                <i class="fa fa- fa-desktop"></i> Start Screen Sharing
            </button>

            <button class="btn btn-success stop-screen-share d-none mb-2">
                <i class="fa fa- fa-desktop"></i> Stop Screen Sharing
            </button>

            <button class="btn btn-success open-messages mb-2">
                <span class="count-messages d-none"></span> <i class="fa fa-comments-o"></i> Messages
            </button>

        </div>
    </div><!-- modal-body Ends -->
    <script
            id="video-js"
            src="<?= $site_url; ?>/plugins/videoPlugin/js/videoCall.js"
            data-base-url="<?= escape($site_url); ?>"
            data-seller-id="<?= escape($login_seller_id); ?>"
            data-opentok-api-key="<?= escape($opentok_api_key); ?>"
            data-date="<?= escape(date("F d, Y")); ?>"
            data-admin-image="<?= $admin_image; ?>"
    ></script>
</div>
</body>

<script
        type="text/javascript"
        id="videoChatModalJs"
        src="<?= $site_url; ?>/plugins/videoPlugin/js/videoChat.js"
        data-base-url="<?= $site_url; ?>"
        data-name="<?= ucfirst($name); ?>"
        data-order-id="<?= $order_id; ?>"
        data-proposal-id="<?= $proposal_id; ?>"
        data-login-seller-id="<?= $login_seller_id; ?>"
        data-seller-id="<?= $login_seller_id; ?>"
        data-buyer-id="<?= $buyer_id; ?>"
        data-order-minutes="<?= $order_minutes; ?>"
        data-id="<?= $where_array['id']; ?>"
        data-call-number="<?= $where_array['call_number']; ?>"
>
</script>