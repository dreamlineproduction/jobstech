<?php

function escape($value)
{
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
}

$proposal_videosettings = $db->select("proposal_videosettings", array('proposal_id' => $proposal_id))->fetch();
$enable = escape($proposal_videosettings->enable);
$price_per_minute = escape($proposal_videosettings->price_per_minute);
$max_seats = escape($proposal_videosettings->max_seats);
$days_within_scheduled = escape($proposal_videosettings->days_within_scheduled);

$video_schedules = $db->select("video_schedules");

$get_delivery_time = $db->select("delivery_times", array('delivery_id' => $d_delivery_id));
$row_delivery_time = $get_delivery_time->fetch();
$delivery_proposal_title = $row_delivery_time->delivery_proposal_title;

$selected_start_times = array();
$selected_end_times = array();

$proposal_classtimings = $db->select("proposal_classtimings", array('proposal_id' => $proposal_id))->fetchAll();
foreach ($proposal_classtimings as $timing) {
    $selected_start_times[$timing->day] = $timing->start_time;
    $selected_end_times[$timing->day] = $timing->end_time;
}

date_default_timezone_set('UTC');

$startTimeArray = array_map(function ($time) {
    return [
        '12' => date('h:i a', $time),
        '24' => date('H:i', $time)
    ];
}, range(0, 46 * 1800, 1800));

$endTimeArray = array_map(function ($time) {
    return [
        '12' => date('h:i a', $time),
        '24' => date('H:i', $time)
    ];
}, range(1800, 47 * 1800, 1800));
?>
<h4 class="font-weight-normal">Video Lesson Settings</h4>
<hr>

<form action="#" method="post" class="video-form"><!--- form Starts -->

    <div class="form-group row"><!--- form-group row Starts --->
        <label class="col-md-4 col-form-label"><?= $lang['enable_video_Lessons']; ?>:</label>
        <div class="col-md-8">
            <input type="checkbox" name="enable" class="mt-3" value="1" <?php if ($enable == 1) {
                echo "checked";
            } ?>>
        </div>
    </div>

    <div class="form-group row"><!--- form-group row Starts --->
        <label class="col-md-4 col-form-label">Price:</label>
        <div class="col-md-8">
            <input type="number" min="1" name="price_per_minute" class="form-control" value="<?= $price_per_minute; ?>"
                   step="any" required="">
        </div>
    </div>

    <!-- <div class="form-group row">
  <label class="col-md-4 col-form-label"><?= $lang['price_per_minute']; ?>:</label>
    <div class="col-md-5">
      <input type="number" min="0.5" name="price_per_minute" class="form-control" value="<?= $price_per_minute; ?>" step="any" required="">
    </div>
  </div> -->

    <div class="form-group row"><!--- form-group row Starts --->
        <label class="col-md-4 col-form-label">Maximum Number of Seats <small>Minimum 1, Maximum 12</small></label>
        <div class="col-md-8">
            <input type="number" min="1" max="12" name="max_seats" value="<?= $max_seats; ?>"
                   class="form-control" required>
        </div>
    </div>

    <div class="form-group row"><!--- form-group row Starts --->
        <div class="col-md-4 col-form-label"><?= $lang['label']['delivery_time']; ?></div>
        <div class="col-md-8">
            <select name="delivery_id" class="form-control" required="">
                <option value="<?= $d_delivery_id; ?>">  <?= $delivery_proposal_title; ?> </option>
                <?php
                $get_delivery_times = $db->query("select * from delivery_times where not delivery_id='$d_delivery_id'");
                while ($row_delivery_times = $get_delivery_times->fetch()) {
                    $delivery_id = $row_delivery_times->delivery_id;
                    $delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
                    echo "<option value='$delivery_id'>$delivery_proposal_title</option>";
                }
                ?>
            </select>
        </div>
        <small class="form-text text-danger"><?= ucfirst(@$form_errors['delivery_id']); ?></small>
    </div><!--- form-group row Ends --->

    <div class="form-group row"><!--- form-group row Starts --->
        <label class="col-md-4 col-form-label"><?= $lang['Days_within_which_a_video_session_can_be_scheduled']; ?>
            :</label>
        <div class="col-md-8">
            <select name="days_within_scheduled" class="form-control">
                <?php foreach ($video_schedules as $schedule) { ?>
                    <option value="<?= escape($schedule->id); ?>" <?php if ($days_within_scheduled == $schedule->id) {
                        echo "selected";
                    } ?>><?= escape($schedule->title); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <hr>

    <div class="row mb-3 d-flex align-items-center select-time">

        <div class="col-md-2">
            <div class="form-group">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input1" id="Sunday" <?php echo isset($selected_start_times['sunday']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="Sunday">Sunday</label>
                </div>
            </div>
        </div>
        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">Start Time</label>
                <select class="form-control video_start_time" name="video_start_time[sunday]" <?php echo isset($selected_start_times['sunday']) ? '' : 'disabled' ?>>
                    <?php foreach ($startTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_start_times['sunday']) && ($time['24'] === date('H:i', strtotime($selected_start_times['sunday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">End Time</label>
                <select class="form-control video_end_time" name="video_end_time[sunday]" <?php echo isset($selected_end_times['sunday']) ? '' : 'disabled' ?>>
                    <?php foreach ($endTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_end_times['sunday']) && ($time['24'] === date('H:i', strtotime($selected_end_times['sunday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


    </div>


    <div class="row mb-3 d-flex align-items-center select-time">

        <div class="col-md-2">
            <div class="form-group">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input1" id="monday" <?php echo isset($selected_start_times['monday']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="monday">Monday</label>
                </div>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">Start Time</label>
                <select class="form-control video_start_time" name="video_start_time[monday]" <?php echo isset($selected_start_times['monday']) ? '' : 'disabled' ?>>
                    <?php foreach ($startTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_start_times['monday']) && ($time['24'] === date('H:i', strtotime($selected_start_times['monday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">End Time</label>
                <select class="form-control video_end_time" name="video_end_time[monday]" <?php echo isset($selected_end_times['monday']) ? '' : 'disabled' ?>>
                    <?php foreach ($endTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_end_times['monday']) && ($time['24'] === date('H:i', strtotime($selected_end_times['monday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


    </div>


    <div class="row mb-3 d-flex align-items-center select-time">

        <div class="col-md-2">
            <div class="form-group">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input1" id="Tuesday" <?php echo isset($selected_start_times['tuesday']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="Tuesday">Tuesday</label>
                </div>
            </div>
        </div>
        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">Start Time</label>
                <select class="form-control video_start_time" name="video_start_time[tuesday]" <?php echo isset($selected_start_times['tuesday']) ? '' : 'disabled' ?>>
                    <?php foreach ($startTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_start_times['tuesday']) && ($time['24'] === date('H:i', strtotime($selected_start_times['tuesday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">End Time</label>
                <select class="form-control video_end_time" name="video_end_time[tuesday]" <?php echo isset($selected_end_times['tuesday']) ? '' : 'disabled' ?>>
                    <?php foreach ($endTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_end_times['tuesday']) && ($time['24'] === date('H:i', strtotime($selected_end_times['tuesday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


    </div>


    <div class="row mb-3 d-flex align-items-center select-time">

        <div class="col-md-2">
            <div class="form-group">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input1" id="Wednesday" <?php echo isset($selected_start_times['wednesday']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="Wednesday">Wednesday</label>
                </div>
            </div>
        </div>
        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">Start Time</label>
                <select class="form-control video_start_time" name="video_start_time[wednesday]" <?php echo isset($selected_start_times['wednesday']) ? '' : 'disabled' ?>>
                    <?php foreach ($startTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_start_times['wednesday']) && ($time['24'] === date('H:i', strtotime($selected_start_times['wednesday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">End Time</label>
                <select class="form-control video_end_time" name="video_end_time[wednesday]" <?php echo isset($selected_end_times['wednesday']) ? '' : 'disabled' ?>>
                    <?php foreach ($endTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_end_times['wednesday']) && ($time['24'] === date('H:i', strtotime($selected_end_times['wednesday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


    </div>


    <div class="row mb-3 d-flex align-items-center select-time">

        <div class="col-md-2">
            <div class="form-group">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input1" id="Thursday" <?php echo isset($selected_start_times['thursday']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="Thursday">Thursday</label>
                </div>
            </div>
        </div>
        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">Start Time</label>
                <select class="form-control video_start_time" name="video_start_time[thursday]" <?php echo isset($selected_start_times['thursday']) ? '' : 'disabled' ?>>
                    <?php foreach ($startTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_start_times['thursday']) && ($time['24'] === date('H:i', strtotime($selected_start_times['thursday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">End Time</label>
                <select class="form-control video_end_time" name="video_end_time[thursday]" <?php echo isset($selected_end_times['thursday']) ? '' : 'disabled' ?>>
                    <?php foreach ($endTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_end_times['thursday']) && ($time['24'] === date('H:i', strtotime($selected_end_times['thursday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


    </div>


    <div class="row mb-3 d-flex align-items-center select-time">

        <div class="col-md-2">
            <div class="form-group">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input1" id="Friday" <?php echo isset($selected_start_times['friday']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="Friday">Friday</label>
                </div>
            </div>
        </div>
        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">Start Time</label>
                <select class="form-control video_start_time" name="video_start_time[friday]" <?php echo isset($selected_start_times['friday']) ? '' : 'disabled' ?>>
                    <?php foreach ($startTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_start_times['friday']) && ($time['24'] === date('H:i', strtotime($selected_start_times['friday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">End Time</label>
                <select class="form-control video_end_time" name="video_end_time[friday]" <?php echo isset($selected_end_times['friday']) ? '' : 'disabled' ?>>
                    <?php foreach ($endTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_end_times['friday']) && ($time['24'] === date('H:i', strtotime($selected_end_times['friday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


    </div>


    <div class="row mb-3 d-flex align-items-center select-time">

        <div class="col-md-2">
            <div class="form-group">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input1" id="Saturday" <?php echo isset($selected_start_times['saturday']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="Saturday">Saturday</label>
                </div>
            </div>
        </div>
        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">Start Time</label>
                <select class="form-control video_start_time" name="video_start_time[saturday]" <?php echo isset($selected_start_times['saturday']) ? '' : 'disabled' ?>>
                    <?php foreach ($startTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_start_times['saturday']) && ($time['24'] === date('H:i', strtotime($selected_start_times['saturday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label for="video_day">End Time</label>
                <select class="form-control video_end_time" name="video_end_time[saturday]" <?php echo isset($selected_end_times['saturday']) ? '' : 'disabled' ?>>
                    <?php foreach ($endTimeArray as $time): ?>
                        <option value="<?php echo $time['24']; ?>"
                            <?php echo (isset($selected_end_times['saturday']) && ($time['24'] === date('H:i', strtotime($selected_end_times['saturday'])))) ? 'selected' : '' ?>>
                            <?php echo $time['12']; ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


    </div>


    <div class="form-group mb-0"><!--- form-group Starts --->
        <a href="#" class="btn btn-secondary float-left back-to-overview">Back</a>
        <input class="btn btn-success float-right" type="submit" value="Save & Continue">
    </div><!--- form-group Starts --->
</form><!--- form Ends -->

<script>
    $(document).ready(function () {

        $('.back-to-overview').click(function () {
            <?php if($d_proposal_status == "draft"){ ?>
            $("input[type='hidden'][name='section']").val("overview");
            $('#video').removeClass('show active');
            $('#overview').addClass('show active');
            $('#tabs a[href="#video"]').removeClass('active');
            <?php }else{ ?>
            $('.nav a[href="#overview"]').tab('show');
            <?php } ?>
        });

        $(".video-form").on('submit', function (event) {
            event.preventDefault();
            var form_data = new FormData(this);
            form_data.append('proposal_id', <?=$proposal_id; ?>);
            $('#wait').addClass("loader");
            $.ajax({
                method: "POST",
                url: "../plugins/videoPlugin/proposals/ajax/save_video",
                data: form_data,
                async: false, cache: false, contentType: false, processData: false
            }).done(function (data) {
                $('#wait').removeClass("loader");
                if (data == "error") {
                    swal({type: 'warning', text: 'You Must Need To Fill Out All Fields Before Updating The Details.'});
                } else {
                    swal({
                        type: 'success',
                        text: 'Details Saved.',
                        timer: 1000,
                        onOpen: function () {
                            swal.showLoading();
                        }
                    }).then(function () {
                        $("input[type='hidden'][name='section']").val("description");
                        <?php if($d_proposal_status == "draft"){ ?>
                        $('#video').removeClass('show active');
                        $('#description').addClass('show active');
                        $('#tabs a[href="#description"]').addClass('active');
                        <?php }else{ ?>
                        $('.nav a[href="#description"]').tab('show');
                        <?php } ?>
                    });
                }
            });
        });

        $('.form-check-input1').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('.select-time').find('select').prop('disabled', false);
            } else {
                $(this).closest('.select-time').find('select').prop('disabled', true);
            }
        });

        $('.video_start_time').change(function () {
            const selectedIndex = $(this).prop('selectedIndex');
            $(this).closest('.select-time').find('.video_end_time option').each(function (index, value) {
                if (index < selectedIndex) {
                    $(this).prop('disabled', true);
                } else if (index === selectedIndex) {
                    if ($(this).closest('.select-time').find('.video_end_time option:selected').prop('index') < selectedIndex) {
                        $(this).prop('disabled', false);
                        $(this).prop('selected', true);
                    }
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });

        $('.video_end_time').change(function () {
            const selectedIndex = $(this).prop('selectedIndex');
            $(this).closest('.select-time').find('.video_start_time option').each(function (index, value) {
                if (index > selectedIndex) {
                    $(this).prop('disabled', true);
                } else if (index === selectedIndex) {
                    if ($(this).closest('.select-time').find('.video_start_time option:selected').prop('index') > selectedIndex) {
                        $(this).prop('disabled', false);
                        $(this).prop('selected', true);
                    }
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });
    });
</script>

