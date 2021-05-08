<?php
session_start();
require_once("../includes/db.php");
require_once("../social-config.php");
require_once("../functions/functions.php");
require_once("../functions/email.php");

$username = $input->get('username');
$select_course_seller = $db->select("sellers", array("seller_user_name" => $username));
$row_course_seller = $select_course_seller->fetch();
$course_seller_id = $row_course_seller->seller_id;

$course_url = urlencode($input->get('course_url'));

//if(isset($_SESSION['admin_email'])){
//    $get_course = $db->query("select * from courses where course_url=:url and course_seller_id='$course_seller_id' AND NOT course_status='deleted'",array("url"=>$course_url));
//}elseif(isset($_SESSION['seller_user_name']) AND $_SESSION['seller_user_name'] == $username){
//    $get_course = $db->query("select * from courses where course_url=:url and course_seller_id='$course_seller_id' and not course_status in ('trash','deleted')",array("url"=>$course_url));
//}else{
//    $get_course = $db->query("select * from courses where course_url=:url and course_seller_id='$course_seller_id' and not course_status in ('draft','admin_pause','pause','pending','trash','declined','modification','trash','deleted')",array("url"=>$course_url));
//}

$get_course = $db->query("select * from courses where course_url=:url and seller_id='$course_seller_id'", array("url" => $course_url));
$count_course = $get_course->rowCount();
if ($count_course == 0) {
    echo "<script> window.open('../../index.php?not_available','_self') </script>";
}
$course = $get_course->fetch();

// Select Proposal Category
$get_cat = $db->select("categories", array('cat_id' => $course->category));
$proposal_cat_url = $get_cat->fetch()->cat_url;

$get_meta = $db->select("cats_meta", array("cat_id" => $course->sub_category, "language_id" => $siteLanguage));
$row_meta = $get_meta->fetch();
@$cat_title = $row_meta->cat_title;

// Select Proposal Child Category
$get_child = $db->select("categories_children", array('child_id' => $proposal_child_id));
$proposal_child_url = $get_child->fetch()->child_url;

$get_meta = $db->select("child_cats_meta", array("child_id" => $proposal_child_id, "language_id" => $siteLanguage));
$row_meta = $get_meta->fetch();
@$child_title = $row_meta->child_title;

// Select language
$get_language = $db->select("course_languages", array("code" => $course->language));
$language = $get_language->fetch()->name;

// Select course chapters and lessons
$get_chapters = $db->select("course_chapters", array("course_id" => $course->id));

// Select course lessons
//$get_lessons = $db->select("course_lessons",array("chapter_id"=>$lesson->id));

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
    <?php if (!empty($site_favicon)) { ?>
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

if (!isset($_GET['paused']) and !isset($_GET['pending']) and !isset($_GET['modification']) and !isset($_GET['draft']) and !isset($_GET['declined'])) {
    $active = "active";
} else {
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
                    </svg>
                    Add To Cart
                </button>
            </li>

        </ul>
    </nav>
</div>


<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-md-8">
            <p><?= $cat_title ?> / <?= $child_title ?> </p>
            <h1><?= $course->title ?></h1>


            <h5><?= $course->short_description ?></h5>

            <p class="mt-3 font-weight-bold"><span class="badge badge-warning mr-2">Bestseller</span> <span
                        class=" text-warning pt-2">4.5</span>
                <img class="" src="../images/user_rate_full.png">
                <img class="" src="../images/user_rate_full.png">
                <img class="" src="../images/user_rate_full.png">
                <img class="" src="../images/user_rate_full.png">
                <img class="" src="../images/user_rate_full.png">
                (142,855 ratings)
                <span>754,354 students</span>
            </p>


            <div class="">
                    <span class="mr-3"><i class="fa fa-info-circle mr-1" aria-hidden="true"></i>Last updated
                        <?= date('m/Y', strtotime($course->updated_at)) ?></span>
                <span><i class="fa fa-language mr-1" aria-hidden="true"></i><?= $language ?></span>
            </div>

            <div class="what-you-learn mt-5">
                <h4 class="font-weight-bold">What you'll learn</h4>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <ul>
                            <li>
                                <?= $course->outcomes_1 ?>
                            </li>
                            <li>
                                <?= $course->outcomes_2 ?>
                            </li>
                            <li>
                                <?= $course->outcomes_3 ?>
                            </li>
                            <li>
                                <?= $course->outcomes_4 ?>
                            </li>
                            <li>
                                <?= $course->outcomes_5 ?>
                            </li>
                        </ul>
                    </div>

                    <!--                    <div class="col-md-6">-->
                    <!--                        <ul>-->
                    <!--                            <li>-->
                    <!--                                Have a great intuition of many Machine Learning models-->
                    <!--                            </li>-->
                    <!--                            <li>-->
                    <!--                                Make powerful analysis-->
                    <!--                            </li>-->
                    <!--                            <li>-->
                    <!--                                Create strong added value to your business-->
                    <!--                            </li>-->
                    <!--                            <li>-->
                    <!--                                Handle specific topics like Reinforcement Learning, NLP and Deep Learning-->
                    <!--                            </li>-->
                    <!--                            <li>-->
                    <!--                                Know which Machine Learning model to choose for each type of problem-->
                    <!--                            </li>-->
                    <!---->
                    <!--                        </ul>-->
                    <!--                    </div>-->
                </div>
            </div>

            <div class="course-content">
                <h4 class="font-weight-bold mb-3">Course content</h4>

                <h6 class="text-muted mb-4"><span>45 chapters </span> | <span>322 lesson</span> | <span>44h 29m
                            total length</span></h6>
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-head" id="headingOne">
                            <h2 class="mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                Welcome to the Course
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">


                                        <p><i class="fa fa-file-o mr-4" aria-hidden="true"></i>Learning Paths</p>
                                        <p><i class="fa fa-file-o mr-4" aria-hidden="true"></i>ML vs. DL vs. AI -
                                            What’s the Difference?</p>
                                        <p><i class="fa fa-video-camera mr-4" aria-hidden="true"></i>Why Machine
                                            Learning is the Future</p>
                                        <p><i class="fa fa-file-o mr-4" aria-hidden="true"></i>GET ALL THE CODES AND
                                            DATASETS HERE!</p>

                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p>5 files</p>
                                        <p>2 files</p>
                                        <p>03:25 min</p>
                                        <p>3 files</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head" id="headingTwo">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="false" aria-controls="collapseTwo">
                                Collapsible Group Item #2
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
                                aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente
                                ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them
                                accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head" id="headingThree">
                            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                Collapsible Group Item #3
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
                                aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente
                                ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them
                                accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <div class="requirements">
                <h4 class="font-weight-bold mb-3">Requirements</h4>
                <ul>
                    <li>
                        <?= $course->requirement_1 ?>
                    </li>
                    <li>
                        <?= $course->requirement_2 ?>
                    </li>
                    <li>
                        <?= $course->requirement_3 ?>
                    </li>
                    <li>
                        <?= $course->requirement_4 ?>
                    </li>
                    <li>
                        <?= $course->requirement_5 ?>
                    </li>
                </ul>
            </div>


            <div class="description shadow-sm">
                <h4 class="font-weight-bold ">Description</h4>
                <p><?= $course->description ?></p>
            </div>


            <div class="card proposal-reviews shadow-sm rounded-0 mb-5" id="reviews">
                <div class="card-header">
                    <h4 class="mb-0 <?= ($lang_dir == "right" ? 'text-right' : '') ?>">
                        <div class="float-left">
                            <span class="mr-2"> <?= $count_reviews; ?> Reviews </span>
                            <?php
                            for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {
                                echo " <img class='mb-2' src='../images/user_rate_full_big.png' > ";
                            }
                            for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {
                                echo " <img class='mb-2' src='../images/user_rate_blank_big.png' > ";
                            }
                            ?> <span class="text-muted ml-2"> <?php
                                if ($proposal_rating == "0") {
                                    echo "0.0";
                                } else {
                                    printf("%.1f", $average_rating);
                                }
                                ?> </span>
                        </div>
                        <div class="float-right">
                            <button id="dropdown-button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown">
                                <?= $lang['button']['most_recent']; ?>
                            </button>
                            <ul class="dropdown-menu proposalDropdown" style="width: auto !important;">
                                <li class="dropdown-item active all"><?= $lang['button']['most_recent']; ?></li>
                                <li class="dropdown-item good"><?= $lang['button']['positive_reviews']; ?></li>
                                <li class="dropdown-item bad"><?= $lang['button']['negative_reviews']; ?></li>
                            </ul>
                        </div>
                    </h4>
                </div>
                <div class="card-body <?= ($lang_dir == "right" ? 'text-right' : '') ?>">
                    <?php include("includes/proposal_reviews.php") ?>
                </div>
            </div>
            <div class="proposal-tags-container mt-2 <?= ($lang_dir == "right" ? 'text-right' : '') ?>">
                <!--- proposal-tags-container Starts --->
                <?php
                $tags = explode(",", $proposal_tags);
                foreach ($tags as $tag) {
                    // $tag = str_replace(" ","-",$tag);
                    // $tag = strtolower($tag);
                    ?>
                    <div class="proposal-tag mb-3" style="<?= ($lang_dir == "right" ? 'float: right;' : '') ?>"><a
                                href="../../tags/<?= str_replace(" ", "-", $tag); ?>"><span><?= $tag; ?></span></a>
                    </div>
                <?php } ?>
            </div>


        </div>


        <div class="col-md-4">
            <div class="course-thumbnail shadow-sm mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <!--<video src="https://content.jwplatform.com/videos/xJ7Wcodt-cIp6U8lV.mp4" controller>-->
                            <?php if (!empty($course->course_preview_video_url)) { ?>
                                <iframe src="https://player.vimeo.com/video/3873878" width="320" height="240" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            <?php } else { ?>
                                <img src="<?= $course->course_preview_image_url ?>" alt="<?= $course->title ?> Preview Image">
                            <?php } ?>
                            
                        </div>

                        <div class="course-price mt-4">
                            <h1>$250.00 USD</h1>
                        </div>

                        <div class="add-course-cart mt-4">
                            <a href="#" class="btn btn-outline-primary btn-block p-3"><i
                                        class="fa fa-cart-arrow-down" aria-hidden="true"></i> Add To Cart</a>
                            <a href="#" class="btn btn-success btn-block p-3"><i class="fa fa-cart-arrow-down"
                                                                                 aria-hidden="true"></i> Buy Now</a>

                        </div>


                    </div>
                </div>


            </div>

            <div class="card shadow-sm seller-bio mb-3 rounded-0">
                <div class="card-body ">

                    <div class="is-online"><i class="fa fa-circle"></i> Online</div>

                    <center class="mb-4">
                        <img src="https://s3.us-east-1.amazonaws.com/storage.jobsteh/user_images/3_1611915611.png"
                             width="130" class="rounded-circle">
                    </center>
                    <h3 class="text-center h6">
                        <a class="text-success" href="../../ayanloveme2006">
                            Ayanloveme2006 </a> <span class="divider"> </span> <span
                                class="badge badge-dark text-white">New Seller</span>
                    </h3>
                    <a href="../../conversations/message?seller_id=1" class="btn btn-order primary"><i
                                class="fa fa-comment" aria-hidden="true"></i> Message me</a>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted"><i class="fa fa-check pr-1"></i> From</p>
                        </div>
                        <div class="col-md-6">
                            <p> United States</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted"><i class="fa fa-check pr-1"></i> Speaks</p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <span>English</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted"><i class="fa fa-check pr-1"></i> Positive Reviews</p>
                            <p class="text-muted"><i class="fa fa-check pr-1"></i> Recent Delivery</p>
                        </div>
                        <div class="col-md-6">
                            <p> 100% </p>
                            <p> March 13, 2021 </p>
                        </div>
                    </div>
                    <hr>
                    <p class="text-left "></p>
                    <a href="../../ayanloveme2006" class="text-success"> Read More </a>
                </div>

            </div>


        </div>

    </div>


</div>


<?php require_once("../includes/footer.php"); ?>
<?php if (!empty($course->course_preview_video_url)) { ?>
<script type="text/javascript" src="https://cdn.jwplayer.com/libraries/hfiS1ZF7.js"></script>
<script type=\"text/javascript\">
    var player = jwplayer('lesson_video_preview');
    player.setup({
        file: '<?= $course->course_preview_video_url ?>'
    });
</script>
<?php } ?>
</body>

</html>
