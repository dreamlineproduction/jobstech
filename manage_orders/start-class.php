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
$get_general_settings = $db->select("general_settings");
$row_general_settings = $get_general_settings->fetch();
$site_color = $row_general_settings->site_color;
$site_hover_color = $row_general_settings->site_hover_color;
$site_border_color = $row_general_settings->site_border_color;

?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>

    <title><?= $site_name; ?> - Proposals Ordered</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?= $site_keywords; ?>">
    <meta name="author" content="<?= $site_author; ?>">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/bootstrap.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/custom.css" rel="stylesheet">
    <!-- Custom css code from modified in admin panel --->
    <link href="<?= $site_url; ?>/styles/styles.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/user_nav_styles.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/owl.carousel.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/owl.theme.default.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $site_url; ?>/js/jquery.min.js"></script>
    <script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    <link href="<?= $site_url; ?>/styles/themes/krajee-fas/theme.css" media="all" rel="stylesheet" type="text/css" />
    <script src="<?= $site_url; ?>/js/star-rating.js" type="text/javascript"></script>
    <script src="<?= $site_url; ?>/styles/themes/krajee-fas/theme.js"></script>

    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="<?= $site_favicon; ?>" type="image/x-icon">
    <?php } ?>

</head>

<body class="is-responsive">
    <nav class="navbar navbar-expand-lg navbar-light bg-light course-navbar ">
        <a class="navbar-brand" href="#">

            <div id="gigtodo-logo"
                class="apply-nav-height gigtodo-logo-svg gigtodo-logo-svg-logged-in <?php if(isset($_SESSION["seller_user_name"])){echo"loggedInLogo";} ?>">
                <a href="<?= $site_url; ?>">
                    <?php if($site_logo_type == "image"){ ?>
                    <img class="desktop" src="<?= $site_logo_image; ?>" width="150">
                    <?php }else{ ?>
                    <span class="desktop text-logo"><?= $site_logo_text; ?></span>
                    <?php } ?>
                    <?php if($enable_mobile_logo == 1){ ?>
                    <img class="mobile" src="<?= $site_mobile_logo; ?>" height="25">
                    <?php } ?>
                </a>
            </div>

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText" style="height: 70px;">
            <ul class="navbar-nav mr-auto ml-5">
                <li class="nav-item active">
                    <h4>Javascript Essentials</h4>
                </li>


            </ul>
            <span class="navbar-text pr-5 hori-nav">
                <p class="leave-rating" data-toggle="modal" data-target="#leave-rating">Leave a rating</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle text-dark" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Your Progress
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">7 of 39 complete</a>

                    </div>
                </div>
            </span>
        </div>
    </nav>


    <div class="container-fluid mt-5 mb-5">

        <div class="row">

            <div class="col-md-9">
                <video id="course-player" controls>
                    <source data-fluid-hd src="https://cdn.fluidplayer.com/videos/valerian-1080p.mkv" title="1080p"
                        type="video/mp4" />
                    <source data-fluid-hd src="https://cdn.fluidplayer.com/videos/valerian-720p.mkv" title="720p"
                        type="video/mp4" />
                    <source src="https://cdn.fluidplayer.com/videos/valerian-480p.mkv" title="480p" type="video/mp4" />

                </video>

            </div>

            <div class="col-md-3">
                <div class="course-content-start">
                    <h5>Course content
                    </h5>
                    <div id="accordion" class="myaccordion">
                        <div class="card">
                            <div class="card-header bg-light" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="d-flex align-items-center justify-content-between btn btn-link"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Chapter 1: Introduction

                                        <span class="fa-stack text-secondary text-small fa-2x">
                                            <i class="fas fa-circle fa-stack-2x"></i>
                                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </button>

                                </h2>
                                <small>4 Lessons | 1 hour 35 min</small>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body course-ul-content">
                                    <ul>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">1. Introduction</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">2. What is Javascript?</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">3. How Javascript Works</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">4. Javascript Console</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header bg-light" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="d-flex align-items-center justify-content-between btn btn-link"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Chapter 2: Introduction

                                        <span class="fa-stack text-secondary text-small fa-2x">
                                            <i class="fas fa-circle fa-stack-2x"></i>
                                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </button>

                                </h2>
                                <small>4 Lessons | 1 hour 35 min</small>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordion">
                                <div class="card-body course-ul-content">
                                    <ul>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">1. Introduction</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">2. What is Javascript?</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">3. How Javascript Works</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">4. Javascript Console</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-light" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="d-flex align-items-center justify-content-between btn btn-link"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Chapter 3: Introduction

                                        <span class="fa-stack text-secondary text-small fa-2x">
                                            <i class="fas fa-circle fa-stack-2x"></i>
                                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </button>

                                </h2>
                                <small>4 Lessons | 1 hour 35 min</small>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordion">
                                <div class="card-body course-ul-content">
                                    <ul>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">1. Introduction</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">2. What is Javascript?</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">3. How Javascript Works</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">4. Javascript Console</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header bg-light" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="d-flex align-items-center justify-content-between btn btn-link"
                                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        Chapter 4: Introduction

                                        <span class="fa-stack text-secondary text-small fa-2x">
                                            <i class="fas fa-circle fa-stack-2x"></i>
                                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </button>

                                </h2>
                                <small>4 Lessons | 1 hour 35 min</small>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-parent="#accordion">
                                <div class="card-body course-ul-content">
                                    <ul>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">1. Introduction</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">2. What is Javascript?</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">3. How Javascript Works</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">4. Javascript Console</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-light" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="d-flex align-items-center justify-content-between btn btn-link"
                                        data-toggle="collapse" data-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        Chapter 5: Introduction

                                        <span class="fa-stack text-secondary text-small fa-2x">
                                            <i class="fas fa-circle fa-stack-2x"></i>
                                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </button>

                                </h2>
                                <small>4 Lessons | 1 hour 35 min</small>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                                data-parent="#accordion">
                                <div class="card-body course-ul-content">
                                    <ul>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">1. Introduction</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">2. What is Javascript?</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">3. How Javascript Works</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">4. Javascript Console</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-light" id="headingSix">
                                <h2 class="mb-0">
                                    <button class="d-flex align-items-center justify-content-between btn btn-link"
                                        data-toggle="collapse" data-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        Chapter 6: Introduction

                                        <span class="fa-stack text-secondary text-small fa-2x">
                                            <i class="fas fa-circle fa-stack-2x"></i>
                                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </button>

                                </h2>
                                <small>4 Lessons | 1 hour 35 min</small>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                data-parent="#accordion">
                                <div class="card-body course-ul-content">
                                    <ul>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">1. Introduction</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">2. What is Javascript?</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">3. How Javascript Works</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="form-check p-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="defaultCheck1">

                                                <p class="d-inline ml-2 font-weight-bold">4. Javascript Console</p>
                                                <small class="pull-right"> <i class="fas fa-play-circle"></i> 30
                                                    min</small>

                                            </div>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>



    </div>

    <!-- Modal -->
    <div class="modal fade" id="leave-rating" tabindex="-1" role="dialog" aria-labelledby="leave-ratingLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leave-ratingLabel">Leave a rating?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h2>Why did you leave this rating?</h2>


                    <div class="star-rating mt-4">
                        <input id="input-93" class="rating-loading">



                    </div>

                    <div class="form-group mt-4">

                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            placeholder="Tell us about your own personal experience taking this course. Was it a good match for you?"></textarea>
                    </div>

                    <button type="button" class="btn btn-dark">Save & Continue</button>

                </div>

            </div>
        </div>
    </div>

    <?php require_once("../includes/footer.php"); ?>
</body>

</html>


<script>
// fluidPlayer method is global when CDN distribution is used.
var player = fluidPlayer('course-player');
</script>

<script>
$("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
    $(e.target)
        .prev()
        .find("i:last-child")
        .toggleClass("fa-minus fa-plus");
});
</script>

<script>
$(document).ready(function() {


    $('#input-93').rating({

    });


});
</script>