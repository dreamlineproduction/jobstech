<?php

include("email.php");

// Select Order Schedule
$order_schedule = $db->select("order_schedules",array("order_id"=>$order_id));
$count_schedule = $order_schedule->rowCount();
$row_schedule = $order_schedule->fetch();
$schedule_sender = @$row_schedule->sender_id;
$schedule_time = @$row_schedule->time;
$schedule_timezone = @$row_schedule->timezone;

$schedule_status = @$row_schedule->status;
if($count_schedule == 1){
  $orderCallTime = new DateTime($schedule_time,new DateTimeZone($schedule_timezone));
  $videoSessionTime = new DateTime($schedule_time,new DateTimeZone($schedule_timezone));
  $videoSessionTime->setTimezone(new DateTimeZone($login_seller_timezone));
  $videoSessionTime = $videoSessionTime->format("F d, Y h:i A");
}

// Schedule Sender Details
$schedule_row_sender = $db->select("sellers",array("seller_id" => $schedule_sender))->fetch();
$schedule_sender_user_name = @$schedule_row_sender->seller_user_name;

// Get Proposal Video Schedule Details
$get_schedule = $db->select("video_schedules",array("id"=>$days_within_scheduled));
$schedule = $get_schedule->fetch();
$schedule_title = @$schedule->title;
$schedule_duration = @$schedule->duration;

$reset = date_default_timezone_get();
date_default_timezone_set($login_seller_timezone);

$maxVideoSessionTime = date("Y-m-d", strtotime(" + $schedule_duration days"));
$minVideoSessionTime = date("Y-m-d H:i", strtotime(" + 1 hour "));
$minVideoSessionTime = str_replace(" ","T",$minVideoSessionTime);

date_default_timezone_set($reset);

if($seller_id == $login_seller_id){ 
  $receiver_id = $buyer_id;
  $receiverType = "buyer";
}else{
  $receiver_id = $seller_id;
  $receiverType = "seller";
}

$receiver_timezone = $db->select("sellers",array("seller_id"=>$receiver_id))->fetch()->seller_timezone;

?>
<?php if(($count_schedule == 0 and $login_seller_id == $buyer_id and $enableVideo == 1) or ($count_schedule == 1)){ ?>

<?php if($count_schedule == 0){ ?>

<?php if(empty($login_seller_timezone)){ ?>
<div class="alert alert-danger clearfix activate-email-class mb-0">
  <div class="float-left mt-2">
    <i style="font-size: 125%;" class="fa fa-exclamation-circle"></i> <?= $lang['Please_Select_Your_Time_Zone_First_By_Going_To']; ?>
    <a href="settings?profile_settings" class="text-primary"><?= $lang['Profile_Settings']; ?></a> <?= $lang['And_Then_You_Can_Set_A_Time_For_Video_Session']; ?> 
  </div>
  <div class="float-right">
    <a href="settings?profile_settings" class="btn btn-success btn-sm float-right">
      <i class="fa fa-folder-open"></i> <?= $lang['Open_Profile_Settings']; ?>
    </a>
  </div>
</div>

<?php }else{ ?>

<div class="card shadow-sm mb-3 mt-3"><!--- card mb-3 mt-3 Starts --->
  <div class="card-header"><h5 class="mb-0"><?= $lang['Set_A_Time_For_Video_Session']; ?></h5></div>
  <div class="card-body">
    <h5 class="font-weight-normal mt-4 mb-4 text-center"> <strong><?= $login_seller_user_name; ?>,</strong> <?= $lang['When_are_you_available_for_a_video_session']; ?></h5>
    <p class=" mt-4 mb-4 text-center"><?= $lang['You_can_only_choose_a_day_within']; ?> <?php echo $schedule_duration; ?> <?= $lang['days_from']; ?> <?php echo date("m/d/Y"); ?></p>
    <form method="post">
    <div class="form-row">
    <div class="col-md-10">
    <div class="form-group">
        <!-- <label class="">+ <?= $lang['Set_A_Date_Time']; ?></label> -->
        <!-- <input type="datetime-local" name="time" min="<?= $minVideoSessionTime; ?>" max="<?= $maxVideoSessionTime; ?>T00:00" class="form-control" required> -->
        <input id="time" name="time" type="text" class="form-control" required placeholder="<?= $lang['Set_A_Date_Time']; ?>">
      </div>
    </div>
    <div class="col-md-2">
    <button type="submit" name="setTime" class="btn btn-primary btn-block"><?= $lang['Submit']; ?></button>
    </div>
  </div>
      
      
    </form>
  </div>
</div><!--- card mb-3 mt-3 Ends --->

<?php } ?>

<?php 
if(isset($_POST['setTime'])){
  $time = $input->post('time');
  $dateTimeSel = explode(' ',$time);
  $time = $dateTimeSel[0].'T'.$dateTimeSel[1];
  $data = array("order_id"=>$order_id,"sender_id"=>$login_seller_id,"time"=>$time,"timezone"=>$login_seller_timezone,"status"=>"pending");
  $insertOrderSchedule = $db->insert("order_schedules",$data);
  if($insertOrderSchedule){
    // Time
    $time = new DateTime($time);
    $oldTime = $time->format("F d, Y h:i A");
    $time->setTimezone(new DateTimeZone($receiver_timezone));
    $time = $time->format("F d, Y h:i A");
    if(sendVideoSessionTimeEmail($login_seller_id,$receiver_id,$order_id,$time)){
     successRedirect("You have successfully set the video session time to $oldTime.","order_details?order_id=$order_id");
    }
  }
}
?>
<?php }else{ ?>
<div class="card bg-white shadow-sm mb-3 mt-3"><!--- card mb-3 mt-3 Starts --->
  <div class="card-header"><h5 class="mb-0"><?= $lang['Video_Session_Time']; ?></h5></div>
  <div class="card-body text-center">
    <?php if($schedule_status == "accepted"){ ?>
    <h5 class="font-weight-normal"> 
      <?= $lang['You_and_your']; ?> <?= $receiverType; ?> <?= $lang['have_accepted_the_video_session_time']; ?> 
      <span class="badge badge-info schedule-badge p-3">(<?= $videoSessionTime; ?>). </span>
      </h5>
    <?php } ?>
    <!-- Video call button start -->

    <?php if(isset($orderCallTime) and $schedule_status == "accepted"){ ?>
	<?php ///if($seller_id == $login_seller_id and ($order_status == "progress" or $order_status == "revision requested")){ ?>
    <div class="text-center mt-5 mb-5">
	  <button class="btn  call-button  accpt-schudle" type="button" data-receiver_id="<?= $receiver_id; ?>">
	 		<i class="fa fa-video-camera"></i> Start Video Lesson
	  </button>
    </div>
	<?php //} ?>
<?php } ?>



    <!-- Video call button end -->

    <?php if($schedule_sender == $login_seller_id){ ?>
    <?php if($schedule_status == "pending"){ ?>
    <h5 class="font-weight-normal text-center"> <strong><?= $login_seller_user_name; ?></strong> <?= $lang['You_have_set_the_video_session_time_to']; ?>
    <span class="badge badge-info schedule-badge p-3">(<?= $videoSessionTime; ?>)</span>
    
    </h5>
    <small class="text-center">Once they accept or propose another time you will get an notification</small>
    <?php }elseif($schedule_status == "proposed"){ ?>
    <h5 class="font-weight-normal"> <strong><?= $login_seller_user_name; ?></strong> <?= $lang['You_have_proposed_the_video_session_time_to']; ?> (<?= $videoSessionTime; ?>). </h5>
    <?php } ?>
    <?php }else{ ?>
    <?php if($schedule_status == "pending"){ ?>
    <h5 class="font-weight-normal text-center"> <strong>Hi,</strong> <?= $schedule_sender_user_name; ?> <?= $lang['has_set_the_video_session_time_to']; ?> 
    <span class="badge badge-info schedule-badge p-3">(<?= $videoSessionTime; ?>)</span> </h5>
    <?php }elseif($schedule_status == "proposed"){ ?>
    <h5 class="font-weight-normal"> <strong><?= $login_seller_user_name; ?></strong> <?= $schedule_sender_user_name; ?> <?= $lang['have_proposed_the_video_session_time_to']; ?> (<?= $videoSessionTime; ?>). </h5>
    <?php } ?>

    <?php if($schedule_status != "accepted"){ ?>
    <form method="post">
    <div class="form-group text-center">
    <button type="submit" name="accept_schedule" class="btn accpt-schudle">
        <?= $lang['accept']; ?>  <?= $lang['schedule']; ?></button>
    </div>

      <div class="form-group mt-5">
        <label class=""><?= $lang['Chose_Another_Schedule']; ?></label>
        <input id="anotherScheduleTime" type="datetime-local" name="time" min="<?= $minVideoSessionTime; ?>" max="<?= $maxVideoSessionTime; ?>T00:00" class="form-control">
      </div>

      <button type="submit" id="proposeAnotherSchedule" name="propose_another_schedule" class="btn btn-success"><?= $lang['Propose_Another_Schedule']; ?></button>
    </form>
    <?php
    if(isset($_POST['accept_schedule'])){
      $updateOrderSchedule = $db->update("order_schedules",array("status"=>'accepted'),array("order_id"=>$order_id));
      if($updateOrderSchedule){
        // Time
        $time = new DateTime($schedule_time,new DateTimeZone($schedule_timezone));
        $time->setTimezone(new DateTimeZone($receiver_timezone));
        $time = $time->format("F d, Y h:i A");
        if(sendAcceptScheduleEmail($login_seller_id,$receiver_id,$order_id,$time)){
          if(sendAcceptScheduleEmailv2($login_seller_id,$receiver_id,$order_id,$time,$receiverType)){
            successRedirect("You have successfully accepted the $schedule_sender_user_name video session schedule.","order_details?order_id=$order_id");
          }
        }
      }
    }
    if(isset($_POST['propose_another_schedule'])){
      $time = $input->post('time');
      $updateOrderSchedule = $db->update("order_schedules",array("sender_id"=>$login_seller_id,"time"=>$time,"timezone"=>$login_seller_timezone,"status"=>"proposed"),array("order_id"=>$order_id));
      if($updateOrderSchedule){
        // Time
        $time = new DateTime($time);
        $time->setTimezone(new DateTimeZone($receiver_timezone));
        $time = $time->format("F d, Y h:i A");
        if(sendProposeAnotherScheduleEmail($login_seller_id,$receiver_id,$order_id,$time)){
            successRedirect("You have successfully proposed another schedule to $schedule_sender_user_name.","order_details?order_id=$order_id");
        }
      }
    }
    ?>
    <?php } ?>
    <?php } ?>
  </div>
</div>
<?php } ?>

<?php } ?>

<script type="text/javascript">
  $(document).ready(function() {
    var min_now = moment().format("mm");
    if(min_now <= 30) {
        var start_time = parseTime(moment().format('H:30'));        
    } else if(min_now > 30){
        var start_time = parseTime(moment().add(1,'hour').format('H:00'));        
    }    

    //var start_time = parseTime(moment().format('HH:00'));
    var end_time = parseTime('23:30');
    var interval = 30;
    var currentTimeArray = calculate_time_slot(start_time, end_time, interval);

    //console.log(currentTimeArray);

    $.datetimepicker.setDateFormatter('moment');
    $('#time').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        allowTimes: currentTimeArray,        
        minDate: 0,
        maxDate: moment().add('<?php echo $schedule_duration?>','day'),
        onSelectDate: function(ct) {
            var dtp = this;
            var start_time_n = parseTime(moment().format('00:00'));
            var end_time_new = parseTime('23:30');
            var interval = 30;
            var newTimeArray = calculate_time_slot(start_time_n, end_time_new, interval);
            if (moment(ct).format("DD") == moment().format("DD")) {
                var res = currentTimeArray;
            } else {
                var res = newTimeArray;
            }

            dtp.setOptions({
                allowTimes: res,
                format: 'YYYY-MM-DD HH:mm',
            })
        }
    });
});
</script>