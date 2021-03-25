<?php
if (!function_exists("escape")) {
    function escape($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }
}
?>
<link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/video-call.css"/>
<link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/video-call.css"/>
<link rel="stylesheet" href="<?= escape($site_url); ?>/plugins/videoPlugin/styles/vanilla-calendar-min.css"/>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="<?= escape($site_url); ?>/plugins/videoPlugin/js/vanilla-calendar-min.js"></script>
<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>

<div class="chat-modal"></div>
<div id="video-chat-modal"></div>
<div id="incoming-call"></div>
<div id="incoming-extend-time"></div>
<div id="wait"></div>

<?php
if (isset($_SESSION['seller_user_name'])) {

    $opentok_api_key = escape($row_general_settings->opentok_api_key);
    $get_admin = $db->select("admins");
    $admin_image = $get_admin->fetch()->admin_image;
    if (empty($admin_image)) {
        $admin_image = "empty-image.png";
    }

    ?>
    <script
            id="video-js"
            src="<?= $site_url; ?>/plugins/videoPlugin/js/videoCall.js"
            data-base-url="<?= escape($site_url); ?>"
            data-seller-id="<?= escape($login_seller_id); ?>"
            data-opentok-api-key="<?= escape($opentok_api_key); ?>"
            data-date="<?= escape(date("F d, Y")); ?>"
            data-admin-image="<?= $admin_image; ?>"
    ></script>

<?php } ?>

<?php

$days = $db->select('proposal_classtimings', array('proposal_id' => $video_proposal_id))->fetchAll();
$availableWeekDays = array();
foreach ($days as $day) {
    $availableWeekDays[] = array(
        'day' => $day->day,
        'time' => date('h:i A', strtotime($day->start_time)) . ' to ' . date('h:i A', strtotime($day->end_time))
    );
}
?>

<script>
    let calendar = new VanillaCalendar({
        selector: "#myCalendar",
        availableWeekDays: <?php echo json_encode($availableWeekDays) ?>,
        datesFilter: true,
        pastDates: false,
        onSelect: (data, element) => {
            const date = new Date(Date.parse(data.date));
            const formattedDate = date.toDateString().slice(4,15);
            $('#classDate').val(formattedDate);
            $('#classTime').val(data.data.time);
            $.ajax({
                url: "../../plugins/videoPlugin/proposals/ajax/change_month",
                method: 'post',
                data: {course_date: formattedDate, proposal: <?php echo $video_proposal_id ?>},
                dataType: 'json',
                success: function (data) {
                    if (data.available === true) {
                        $('#checkoutForm').removeClass('d-none');
                        $('#notAvailable').addClass('d-none');
                    } else {
                        $('#checkoutForm').addClass('d-none');
                        $('#notAvailable').removeClass('d-none');
                    }
                }
            });
        }
    });
</script>