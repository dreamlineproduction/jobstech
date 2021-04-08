<?php

session_start();
require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>

    <title><?= $site_name; ?> - Proposals Ordered By Your Customers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $site_desc; ?>">
    <meta name="keywords" content="<?= $site_keywords; ?>">
    <meta name="author" content="<?= $site_author; ?>">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">

    <link href="../styles/bootstrap.css" rel="stylesheet">
    <link href="../styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
    <link href="../styles/styles.css" rel="stylesheet">
    <link href="../styles/user_nav_styles.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../styles/owl.carousel.css" rel="stylesheet">
    <link href="../styles/owl.theme.default.css" rel="stylesheet">
    <script type="text/javascript" src="../js/jquery.min.js"></script>

    <?php if(!empty($site_favicon)){ ?>

    <link rel="shortcut icon" href="<?= $site_favicon; ?>" type="image/x-icon">

    <?php } ?>

</head>

<body class="is-responsive">

    <?php require_once("../includes/user_header.php"); ?>

    <div class="container mt-5">

        <div class="row">

            <div class="col-md-10">

                <!-- <h1 class="<?=($lang_dir == "right" ? 'text-right':'')?>"><?= $lang["titles"]["selling_orders"]; ?></h1> -->
                <h1>Manage Online Learning Orders</h1>

            </div>
            <div class="col-md-2 text-right">

                <a class="btn btn-success" href="../selling_orders.php" role="button"><i class="fa fa-arrow-left"
                        aria-hidden="true"></i>
                    Go Back</a>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12 mt-5 mb-3">


                <div class="card">
                    <div class="card-body shadow-sm">
                        <div id="myCalendar" class="vanilla-calendar" style="margin-bottom: 20px"></div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Proposal Title</th>
                                        <th>Lesson Time</th>
                                        <th>Students Enrolled</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="order_details?order_id=20" class="make-black">
                                                <img class="order-proposal-image"
                                                    src="https://s3.us-east-1.amazonaws.com/storage.jobsteh/proposal_files/toyota-fortuner-car-the-undisputed-leader-ad-times-of-india-mumbai-26-09-2018_1617727066.png">
                                                <p class="order-proposal-title">Video call test</p>
                                            </a>
                                        </td>
                                        <td>12:00PM - 13:00PM</td>
                                        <td>8/12</td>
                                        <td><a class="btn btn-success" href="../video-order-details.php"
                                                role="button">Manage Order</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="order_details?order_id=20" class="make-black">
                                                <img class="order-proposal-image"
                                                    src="https://s3.us-east-1.amazonaws.com/storage.jobsteh/proposal_files/toyota-fortuner-car-the-undisputed-leader-ad-times-of-india-mumbai-26-09-2018_1617727066.png">
                                                <p class="order-proposal-title">Video call test</p>
                                            </a>
                                        </td>
                                        <td>12:00PM - 13:00PM</td>
                                        <td>8/12</td>
                                        <td><a class="btn btn-success" href="../video-order-details.php"
                                                role="button">Manage Order</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="order_details?order_id=20" class="make-black">
                                                <img class="order-proposal-image"
                                                    src="https://s3.us-east-1.amazonaws.com/storage.jobsteh/proposal_files/toyota-fortuner-car-the-undisputed-leader-ad-times-of-india-mumbai-26-09-2018_1617727066.png">
                                                <p class="order-proposal-title">Video call test</p>
                                            </a>
                                        </td>
                                        <td>12:00PM - 13:00PM</td>
                                        <td>8/12</td>
                                        <td><a class="btn btn-success" href="../video-order-details.php"
                                                role="button">Manage Order</a></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <?php require_once("../includes/footer.php"); ?>
</body>

</html>