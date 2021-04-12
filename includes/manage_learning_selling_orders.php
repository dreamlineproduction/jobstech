<?php

session_start();
require_once("../includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {
    echo "<script>window.open('login','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers", array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$video_category_ids = $db->query('SELECT cat_id FROM categories WHERE video = 1')->fetchAll(PDO::FETCH_COLUMN);

$video_proposals = $db->query('SELECT * FROM proposals WHERE proposal_cat_id IN (' . implode(',', $video_category_ids) . ')');

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

    <?php if (!empty($site_favicon)) { ?>

        <link rel="shortcut icon" href="<?= $site_favicon; ?>" type="image/x-icon">

    <?php } ?>

</head>

<body class="is-responsive">

<?php require_once("../includes/user_header.php"); ?>

<div class="container mt-5">

    <div class="row">

        <div class="col-md-10">

            <!-- <h1 class="<?= ($lang_dir == "right" ? 'text-right' : '') ?>"><?= $lang["titles"]["selling_orders"]; ?></h1> -->
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
                        <table class="table table-bordered" id="video_orders">
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
                                <td colspan="4">
                                    Please select a date first to view the orders.
                                </td>
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

<script>
    let calendar = new VanillaCalendar({
        selector: "#myCalendar",
        pastDates: false,
        onSelect: (data, element) => {
            const date = new Date(Date.parse(data.date));
            const formattedDate = date.toDateString().slice(4, 15);
            $.ajax({
                url: "../plugins/videoPlugin/proposals/ajax/video_orders",
                method: 'post',
                data: {course_date: formattedDate},
                dataType: 'json',
                success: function (data) {
                    let html = '';

                    if (data.length > 0) {
                        $.each(data, function (key, order) {
                            html += '<tr>';
                            html += '<td>' + order.proposal_title + '</td>' +
                                '<td>' + order.class_time + '</td>' +
                                '<td>' + order.students_enrolled + '/' + order.max_seats + '</td>' +
                                '<td><a class="btn btn-success" href="../video-order-details.php?proposal='
                                + order.proposal_id + '&date=' + encodeURIComponent(order.class_date) + '&order_id=19" ' +
                                'role="button">Manage Order</a></td>';
                            html += '</tr>';
                        });
                    } else {
                        html += '<tr><td colspan="4">No orders are available for this date.</td></tr>';
                    }

                    $('#video_orders tbody').html(html);

                }
            });
        }
    });
</script>
</body>

</html>