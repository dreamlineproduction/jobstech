<?php
session_start();
require_once("../includes/db.php");




?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">

<head>
    <title><?= $site_name; ?> - My All Courses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $site_desc; ?>">
    <meta name="keywords" content="<?= $site_keywords; ?>">
    <meta name="author" content="<?= $site_author; ?>">

    <link href="../styles/create-course.css" rel="stylesheet">
    <link href="../styles/desktop_proposals.css" rel="stylesheet">
    <link href="../styles/bootstrap.css" rel="stylesheet">
    <link href="../styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
    <link href="../styles/styles.css" rel="stylesheet">
    <link href="../styles/user_nav_styles.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../styles/owl.carousel.css" rel="stylesheet">
    <link href="../styles/owl.theme.default.css" rel="stylesheet">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link href="../styles/sweat_alert.css" rel="stylesheet">
    <link href="../styles/animate.css" rel="stylesheet">
    <script type="text/javascript" src="../js/ie.js"></script>
    <script type="text/javascript" src="../js/sweat_alert.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="<?= $site_favicon; ?>" type="image/x-icon">
    <?php } ?>

    <!-- Include the PayPal JavaScript SDK -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=<?= $paypal_client_id; ?>&disable-funding=credit,card&currency=<?= $paypal_currency_code; ?>">
    </script>

</head>

<body class="is-responsive">

    <?php 

require_once("../includes/header.php"); 

if(!isset($_GET['paused']) and !isset($_GET['pending']) and !isset($_GET['modification']) and !isset($_GET['draft']) and !isset($_GET['declined'])){
	$active =  "active";
}else{
	$active = "";
}

?>

    <div class="mp-gig-top-nav">
        <nav>
            <ul class="container text-center" id="mainNav">

                <li class="selected">
                    <a href="#introduction" class="gig-page-nav-link">Introduction</a>
                </li>

                <li>
                    <a href="#details" class="gig-page-nav-link">Proposal Details</a>
                </li>

                <li>
                    <a href="#faq" class="gig-page-nav-link">FAQ</a>
                </li>

                <li>
                    <a href="#reviews" class="gig-page-nav-link">Reviews</a>
                </li>

                <li>
                    <a href="#related" class="gig-page-nav-link">Related Proposals</a>
                </li>

                <li>
                    <a href="#redirect" onclick="window.location.href='../../conversations/message.php?seller_id=1'"
                        class="gig-page-nav-link">
                        <i class="fa fa-comments-o fa-lg"></i> Message the Seller</a>
                </li>


                <li class="btns d-none float-right">
                    <button class="add-to-cart btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" height="19px" width="19px" viewBox="0 0 24 24"
                            class="ccl-0f24ac4b87ce1f67 ccl-cd43b511fc3197b8 ccl-0f084ffde1637b39"
                            data-reactid=".looayv4cn4.1.0.0.0.1.$bar-link-$5=190-2.0.0.0.0">
                            <path
                                d="M14,15 L14,12 L10,12 L10,15 L14,15 Z M15,15 L19.0988383,15 L19.8055064,12 L15,12 L15,15 Z M14,9 L10,9 L10,11 L14,11 L14,9 Z M15,9 L15,11 L20,11 L20,11.1743211 L20.5121744,9 L15,9 Z M14,18 L14,16 L10,16 L10,18 L14,18 Z M15,18 L18.3921702,18 L18.8632823,16 L15,16 L15,18 Z M9,15 L9,12 L4.19449364,12 L4.9011617,15 L9,15 Z M9,9 L3.48782558,9 L4,11.1743211 L4,11 L9,11 L9,9 Z M9,18 L9,16 L5.13671772,16 L5.60782976,18 L9,18 Z M7,7 L7,3 L17,3 L17,7 L23,7 L20,20 L4,20 L1,7 L7,7 Z M9,7 L15,7 L15,5 L9,5 L9,7 Z"
                                data-reactid=".looayv4cn4.1.0.0.0.1.$bar-link-$5=190-2.0.0.0.0.0"></path>
                        </svg> Add To Cart </button>
                </li>

            </ul>
        </nav>
    </div>


    <div class="container-fluid bg-black-call">
        <div class="row">
            <div class="col-md-12">
                asdad
            </div>

        </div>


    </div>




    <?php require_once("../includes/footer.php"); ?>
</body>

</html>