<?php

function escape($value){
  return htmlentities($value,ENT_QUOTES,'UTF-8');
}

$proposal_videosettings =  $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id))->fetch();
$enable = escape($proposal_videosettings->enable);
$price_per_minute = escape($proposal_videosettings->price_per_minute);
$days_within_scheduled = escape($proposal_videosettings->days_within_scheduled);

$video_schedules = $db->select("video_schedules");

$get_delivery_time =  $db->select("delivery_times",array('delivery_id' => $d_delivery_id));
$row_delivery_time = $get_delivery_time->fetch();
$delivery_proposal_title = $row_delivery_time->delivery_proposal_title;

?>
<h4 class="font-weight-normal">Video</h4>
<hr>

<form action="#" method="post" class="video-form"><!--- form Starts -->

  <div class="form-group row"><!--- form-group row Starts --->
    <label class="col-md-4 col-form-label"><?= $lang['enable_video_Lessons']; ?>:</label>
    <div class="col-md-5">
      <input type="checkbox" name="enable" class="mt-3" value="1" <?php if($enable==1){echo "checked";} ?>>
    </div>
  </div>
  
  <div class="form-group row"><!--- form-group row Starts --->
  <label class="col-md-4 col-form-label"><?= $lang['price_per_minute']; ?>:</label>
    <div class="col-md-5">
      <input type="number" min="0.5" name="price_per_minute" class="form-control" value="<?=$price_per_minute; ?>" step="any" required="">
    </div>
  </div>

  <div class="form-group row"><!--- form-group row Starts --->
  <div class="col-md-4 col-form-label"><?= $lang['label']['delivery_time']; ?></div>
  <div class="col-md-5">
  <select name="delivery_id" class="form-control" required="">
  <option value="<?= $d_delivery_id; ?>">  <?= $delivery_proposal_title; ?> </option>
  <?php 
  $get_delivery_times = $db->query("select * from delivery_times where not delivery_id='$d_delivery_id'");
  while($row_delivery_times = $get_delivery_times->fetch()){
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
  <label class="col-md-4 col-form-label"><?= $lang['Days_within_which_a_video_session_can_be_scheduled']; ?>:</label>
    <div class="col-md-5">
      <select name="days_within_scheduled" class="form-control">
        <?php foreach($video_schedules as $schedule){ ?>
          <option value="<?= escape($schedule->id); ?>" <?php if($days_within_scheduled==$schedule->id){echo"selected";} ?>><?= escape($schedule->title); ?></option>
        <?php } ?>
      </select>
    </div>
  </div>

  <hr>
  <div class="form-group mb-0"><!--- form-group Starts --->
    <a href="#" class="btn btn-secondary float-left back-to-overview">Back</a>
    <input class="btn btn-success float-right" type="submit" value="Save & Continue">
  </div><!--- form-group Starts --->
</form><!--- form Ends -->

<script>
$(document).ready(function(){

  $('.back-to-overview').click(function(){
    <?php if($d_proposal_status == "draft"){ ?>
    $("input[type='hidden'][name='section']").val("overview");
    $('#video').removeClass('show active');
    $('#overview').addClass('show active');
    $('#tabs a[href="#video"]').removeClass('active');
    <?php }else{ ?>
    $('.nav a[href="#overview"]').tab('show');
    <?php } ?>
  });

  $(".video-form").on('submit', function(event){
    event.preventDefault();
    var form_data = new FormData(this);
    form_data.append('proposal_id',<?=$proposal_id; ?>);
    $('#wait').addClass("loader");
    $.ajax({
      method: "POST",
      url: "../plugins/videoPlugin/proposals/ajax/save_video",
      data: form_data,
      async: false,cache: false,contentType: false,processData: false
    }).done(function(data){
      $('#wait').removeClass("loader");
      if(data == "error"){
        swal({type:'warning',text:'You Must Need To Fill Out All Fields Before Updating The Details.'});
      }else{
        swal({
          type: 'success',
          text: 'Details Saved.',
          timer: 1000,
          onOpen: function(){
            swal.showLoading();
          }
        }).then(function(){
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

});
</script>