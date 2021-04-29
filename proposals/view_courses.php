<?php
session_start();
require_once("../includes/db.php");
if (!isset($_SESSION['seller_user_name'])) {
    echo "<script>window.open('../login','_self')</script>";
}

$courses = $db->select('courses', ['seller_id' => $login_seller_id])->fetchAll();

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

    <link href="./styles/create-course.css" rel="stylesheet">
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

require_once("../includes/user_header.php");

if (!isset($_GET['paused']) and !isset($_GET['pending']) and !isset($_GET['modification']) and !isset($_GET['draft']) and !isset($_GET['declined'])) {
    $active = "active";
} else {
    $active = "";
}

?>
<div class="container view-proposals">
    <!-- container-fluid view-proposals Starts -->
    <div class="row">
        <!-- row Starts -->
        <div class="col-md-12 mt-5 mb-3">
            <!-- col-md-12 mt-5 mb-3 Starts -->
            <h1 class="pull-left">My Courses</h1>
            <label class="pull-right lead">
                <!-- pull-right lead Starts -->
                <?= $lang['view_proposals']['vacation_mode']; ?>
                <?php if ($login_seller_vacation == "off") { ?>
                    <button id="turn_on_seller_vaction" data-toggle="button" class="btn btn-lg btn-toggle">
                        <div class="toggle-handle"></div>
                    </button>
                <?php } else { ?>
                    <button id="turn_off_seller_vaction" data-toggle="button" class="btn btn-lg btn-toggle active">
                        <div class="toggle-handle"></div>
                    </button>
                <?php } ?>
            </label><!-- pull-right lead Ends -->
            <script>
                $(document).ready(function () {
                    $(document).on('click', '#turn_on_seller_vaction', function () {
                        seller_id = "<?= $login_seller_id; ?>";
                        $.ajax({
                            method: "POST",
                            url: "seller_vacation_modal",
                            data: {
                                seller_id: seller_id,
                                turn_on: 'on'
                            }
                        }).done(function (data) {
                            $('.append-modal').html(data);
                        });
                    });
                    $(document).on('click', '#turn_off_seller_vaction', function () {
                        seller_id = "<?= $login_seller_id; ?>";
                        $.ajax({
                            method: "POST",
                            url: "seller_vacation",
                            data: {
                                seller_id: seller_id,
                                turn_off: 'off'
                            }
                        }).done(function () {
                            $("#turn_off_seller_vaction").attr('id', 'turn_on_seller_vaction');
                            swal({
                                type: 'success',
                                text: 'Vacation switched OFF.',
                                padding: 40,
                            });
                        });
                    });
                });
            </script>
        </div>
        <div class="append-modal"></div>
        <div class="col-md-12">
            <a href="create_course" class="btn btn-success pull-right">
                <i class="fa fa-plus-circle"></i> Create New Course
            </a>
            <div class="clearfix"></div>
        </div>


        <div class="col-md-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-courses-tab" data-toggle="pill" href="#all-courses" role="tab"
                       aria-controls="all-courses" aria-selected="true">All Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="course-bookings-tab" data-toggle="pill" href="#course-bookings" role="tab"
                       aria-controls="course-bookings" aria-selected="false">Bookings</a>
                </li>

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="all-courses" role="tabpanel"
                     aria-labelledby="all-courses-tab">
                    <div class="card mb-5">
                        <div class="card-body shadow-sm">
                            <div class="row">
                                <?php if (!empty($courses)) {
                                    foreach ($courses as $course) { ?>
                                        <div class="col-md-3  course-cards mb-4">
                                            <div class="card shadow-sm">
                                                <img class="card-img-top"
                                                     src="https://via.placeholder.com/290x200.png?text=Course+Thumbnail+Image+Here"
                                                     alt="Card image cap">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $course->title ?></h5>
                                                    <p class="card-text text-muted"><?= $_SESSION['seller_user_name'] ?> </p>

                                                    <?php if (!empty($course->discounted_price)) { ?>
                                                        <h5><del>$<?= $course->price ?></del> $<?= $course->discounted_price ?></h5>
                                                    <?php } else { ?>
                                                        <h5>$<?= $course->price ?></h5>
                                                    <?php } ?>

                                                    <div class="mt-4">
                                                        <a href="#" class="btn btn-success edit-course"><i class="fa fa-pencil"
                                                                                                           aria-hidden="true"></i>
                                                            Edit</a>
                                                        <a href="../screens/desktop_course.php"
                                                           class="btn btn-primary pull-right  view-course">View Course</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                                <div class="col-md-3  course-cards mb-4">
                                    <div class="card shadow-sm">
                                        <img class="card-img-top"
                                             src="https://via.placeholder.com/290x200.png?text=Course+Thumbnail+Image+Here"
                                             alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Graphic Design Masterclass - Learn GREAT Design</h5>
                                            <p class="card-text text-muted">Jose Portilla </p>
                                            <h5>$250.00</h5>
                                            <div class="mt-4">
                                                <a href="#" class="btn btn-success edit-course"><i class="fa fa-pencil"
                                                                                                   aria-hidden="true"></i>
                                                    Edit</a>
                                                <a href="../screens/desktop_course.php"
                                                   class="btn btn-primary pull-right  view-course">View Course</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3  course-cards mb-4">
                                    <div class="card shadow-sm">
                                        <img class="card-img-top"
                                             src="https://via.placeholder.com/290x200.png?text=Course+Thumbnail+Image+Here"
                                             alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Graphic Design Masterclass - Learn GREAT Design</h5>
                                            <p class="card-text text-muted">Jose Portilla </p>
                                            <h5>$250.00</h5>
                                            <div class="mt-4">
                                                <a href="#" class="btn btn-success edit-course"><i class="fa fa-pencil"
                                                                                                   aria-hidden="true"></i>
                                                    Edit</a>
                                                <a href="#" class="btn btn-primary pull-right  view-course">View
                                                    Course</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3  course-cards mb-4">
                                    <div class="card shadow-sm">
                                        <img class="card-img-top"
                                             src="https://via.placeholder.com/290x200.png?text=Course+Thumbnail+Image+Here"
                                             alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Graphic Design Masterclass - Learn GREAT Design</h5>
                                            <p class="card-text text-muted">Jose Portilla </p>
                                            <h5>$250.00</h5>
                                            <div class="mt-4">
                                                <a href="#" class="btn btn-success edit-course"><i class="fa fa-pencil"
                                                                                                   aria-hidden="true"></i>
                                                    Edit</a>
                                                <a href="#" class="btn btn-primary pull-right  view-course">View
                                                    Course</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3  course-cards mb-4">
                                    <div class="card shadow-sm">
                                        <img class="card-img-top"
                                             src="https://via.placeholder.com/290x200.png?text=Course+Thumbnail+Image+Here"
                                             alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Graphic Design Masterclass - Learn GREAT Design</h5>
                                            <p class="card-text text-muted">Jose Portilla </p>
                                            <h5>$250.00</h5>
                                            <div class="mt-4">
                                                <a href="#" class="btn btn-success edit-course"><i class="fa fa-pencil"
                                                                                                   aria-hidden="true"></i>
                                                    Edit</a>
                                                <a href="#" class="btn btn-primary pull-right  view-course">View
                                                    Course</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="tab-pane fade" id="course-bookings" role="tabpanel" aria-labelledby="course-bookings-tab">
                    <div class="card mb-5">
                        <div class="card-body shadow-sm">
                            <div class="row">
                                <table class="table table-borderless">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Course ID</th>
                                        <th scope="col">Course Name</th>
                                        <th scope="col">Enrolled Students</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">#JB1255451</th>
                                        <td>Graphic Design Masterclass - Learn GREAT Design</td>
                                        <td>10/12</td>
                                        <td>28-03-2021</td>
                                        <td>12:30PM - 2:30PM</td>
                                        <td><span class="badge badge-primary">Active</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">#JB1255451</th>
                                        <td>Graphic Design Masterclass - Learn GREAT Design</td>
                                        <td>10/12</td>
                                        <td>28-03-2021</td>
                                        <td>12:30PM - 2:30PM</td>
                                        <td><span class="badge badge-primary">Active</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">#JB1255451</th>
                                        <td>Graphic Design Masterclass - Learn GREAT Design</td>
                                        <td>10/12</td>
                                        <td>28-03-2021</td>
                                        <td>12:30PM - 2:30PM</td>
                                        <td><span class="badge badge-primary">Active</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">#JB1255451</th>
                                        <td>Graphic Design Masterclass - Learn GREAT Design</td>
                                        <td>10/12</td>
                                        <td>28-03-2021</td>
                                        <td>12:30PM - 2:30PM</td>
                                        <td><span class="badge badge-primary">Active</span></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>
</div>
<div id="featured-proposal-modal"></div>
<?php require_once("../includes/footer.php"); ?>
</body>

</html>