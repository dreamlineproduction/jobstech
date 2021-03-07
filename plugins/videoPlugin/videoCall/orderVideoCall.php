<?php if(isset($orderCallTime) and $schedule_status == "accepted"){ ?>
	<?php ///if($seller_id == $login_seller_id and ($order_status == "progress" or $order_status == "revision requested")){ ?>
	  <button class="btn btn-success call-button float-left" type="button" data-receiver_id="<?= $receiver_id; ?>">
	 		<i class="fa fa-video-camera"></i> Video Call
	  </button>
	<?php //} ?>
<?php } ?>