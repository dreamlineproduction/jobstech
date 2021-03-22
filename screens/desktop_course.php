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

    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
            <p>Graphics & Design / Logo Design </p>
            <h1>2021 Complete Python Bootcamp From Zero to Hero in Python</h1>
            <p>Learn Python like a Professional Start from the basics and go all the way to creating your own applications and games</p>

            <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur, erat vel auctor vehicula, diam turpis ultrices dui, quis pharetra est magna sed augue.</h5>

            <p class="mt-3 font-weight-bold"><span class="badge badge-warning mr-2">Bestseller</span> <span class=" text-warning pt-2">4.5</span> 
            <img class="" src="../images/user_rate_full.png">
            <img class="" src="../images/user_rate_full.png">
            <img class="" src="../images/user_rate_full.png">
            <img class="" src="../images/user_rate_full.png">
            <img class="" src="../images/user_rate_full.png">
            (142,855 ratings)
            <span>754,354 students</span> 
            </p>

            
                <div class="">
                    <span class="mr-3"><i class="fa fa-info-circle mr-1" aria-hidden="true"></i>Last updated 3/2021</span>
                    <span><i class="fa fa-language mr-1" aria-hidden="true"></i>English</span>
                </div>
                <div class="mt-2">
                    <span class=""><i class="fa fa-cc mr-1" aria-hidden="true"></i>English [Auto], French [Auto], German [Auto], Italian [Auto], Portuguese [Auto], Spanish [Auto]</span>
                    
                </div>
                
                   
                
            
            </div>


            <div class="col-md-4">
                <div class="course-thumbnail shadow-sm mb-5">
                <div class="card">
  <div class="card-body">
  <div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0"></iframe>
</div>

<div class="course-price mt-4">
<h1>$250.00 USD</h1>
</div>

<div class="add-course-cart mt-4">
<a href="#" class="btn btn-outline-primary btn-block p-3"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Add To Cart</a>
<a href="#" class="btn btn-success btn-block p-3"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Buy Now</a>

</div>


  </div>
</div>
            

                </div>

                <div class="card shadow-sm seller-bio mb-3 rounded-0">
  <div class="card-body ">

    <div class="is-online"> <i class="fa fa-circle"></i> Online </div>
  
  <center class="mb-4">
    <img src="https://s3.us-east-1.amazonaws.com/storage.jobsteh/user_images/3_1611915611.png" width="130" class="rounded-circle">
    </center>
  <h3 class="text-center h6">
  <a class="text-success" href="../../ayanloveme2006">
  Ayanloveme2006  </a> <span class="divider"> </span> <span class="badge badge-dark text-white">New Seller</span>
  </h3>
    <a href="../../conversations/message?seller_id=1" class="btn btn-order primary"><i class="fa fa-comment" aria-hidden="true"></i> Message me</a>
    <hr>
  <div class="row">
  <div class="col-md-6">
  <p class="text-muted"><i class="fa fa-check pr-1"></i> From</p>
  </div>
  <div class="col-md-6">
  <p> United States</p>
  </div>
  <div class="col-md-6">
  <p class="text-muted"><i class="fa fa-check pr-1"></i>  Speaks</p>
  </div>
  <div class="col-md-6">
  <p>
    <span>English</span>
    </p>
  </div>
  <div class="col-md-6">
  <p class="text-muted"><i class="fa fa-check pr-1"></i>  Positive Reviews</p>
  <p class="text-muted"><i class="fa fa-check pr-1"></i> Recent Delivery</p>
  </div>
  <div class="col-md-6">
  <p> 100% </p>
  <p> March 13, 2021 </p>
  </div>
  </div>
  <hr>
  <p class="text-left ">  </p>
  <a href="../../ayanloveme2006" class="text-success"> Read More </a>
</div>

</div>




                
            </div>

        </div>


    </div>






    <?php require_once("../includes/footer.php"); ?>
</body>

</html>