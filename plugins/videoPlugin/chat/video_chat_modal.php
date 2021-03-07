<?php

$login_user_id = $login_seller_id;
if($login_user_id == $where_array['receiver_id']){
	$user_id = $where_array['sender_id'];
}else{
	$user_id = $where_array['receiver_id'];
}

$select_seller = $db->select("sellers",array("seller_id"=>$user_id));
$row_seller = $select_seller->fetch();
$name = escape($row_seller->seller_user_name);
$image = getImageUrl2("sellers","seller_image",escape($row_seller->seller_image));

if(empty($image)){
	$image = "empty-image.png";
}

$get_order = $db->select("orders",array("order_id"=>$where_array['order_id']));
$count_orders = $get_order->rowCount();
$row_order = $get_order->fetch();
$order_id = escape($row_order->order_id);
$seller_id = escape($row_order->seller_id);
$buyer_id = escape($row_order->buyer_id);
$proposal_id = escape($row_order->proposal_id);
$order_minutes = escape($row_order->order_minutes);

if($login_seller_id == $buyer_id){
	$activeUser = "buyer";
}else{
	$activeUser = "seller";
}

?>
<div id="video_chat_modal" class="modal fade modal-fullscreen" style="z-index:2050;"><!-- video_chat_modal modal fade Starts -->
	<div class="modal-dialog"><!-- modal-dialog Starts -->
		<div class="modal-content"><!-- modal-content Starts -->
			<div class="modal-header"><!-- modal-header Starts -->
				<h6 class="modal-title"> Video Call </h6>
				<button type="submit" class="leave-button close"><span>&times;</span></button>
			</div><!-- modal-header Ends -->
			<div class="modal-body"><!-- modal-body Starts -->
				<h5 class="clearfix">
				   <span class="float-left d-none d-lg-block">
					Video Chat with <span class="text-success"><?= $name; ?></span>
				   </span>
				   <span class="float-right">
				   <input type="hidden" id="intervalStatus" value="run"/>
				   <input type="hidden" id="activeUser" value="<?= $activeUser; ?>"/>
				   <input type="hidden" id="orderId" value="<?= $where_array['order_id']; ?>"/>
				   <input type="hidden" id="orderMinutes" value="<?= $order_minutes; ?>"/>
				   <input type="hidden" id="warningMessage" value="<?= $result['warning_message']; ?>"/>
				   <input type="hidden" id="sessionId" name="room_number" value="<?= $where_array['call_number']; ?>"/>
				   <input type="hidden" id="token" name="call_token" value="<?= $where_array['call_token']; ?>"/>
				   <button type="submit" class="leave-button btn btn-small btn-danger text-white"> 
				   <i class="fa fa-times-circle"></i> End Call
				   </button>
				   </span>
				</h5>
				<div class="row mb-2 mt-3 justify-content-center"><!--- row mb-2 mt-3 Starts --->
					<div class="col-md-6">
					  <div id="publisher" class="w-100 h-100 border"></div>
					  <div id="publisher-screen" class="w-100 h-100 d-none border"></div>
					</div>
					<div id="subscriber" class="col-md-6 bg-dark"><!--- col-md-6 bg-dark Starts --->
					  
					  <div id="subscriber-stream" class="w-100 h-100 border d-none"></div>
					  <div id="subscriber-screen" class="w-100 h-100 d-none border"></div>

					  <div id="subscriber-ringing" class="w-100 h-100 text-center">
							<img src="<?= $image; ?>" class='img-fluid rounded-circle' width="140">
							<h3 class="mt-2"> <?= $name; ?> </h3>
							<h5 class="text-success"> Ringing ... </h5>
					  </div>
					  <div id="subscriber-ended" class="w-100 h-100 text-center d-none">
							<img src="<?= $image; ?>" class='img-fluid rounded-circle' width="140">
							<h3 class="mt-2"> <?= $name; ?> </h3>
							<h5 class="text-success"> Has Ended Your Call. </h5>
					  </div>
					  <div id="subscriber-declined" class="w-100 h-100 text-center d-none">
							<img src="<?= $image; ?>" class='img-fluid rounded-circle' width="140">
							<h3 class="mt-2"> <?= $name; ?> </h3>
							<h5 class="text-success"> Has Declined Your Call. </h5>
					  </div>
					</div><!--- col-md-6 bg-dark Ends --->
				</div><!--- row mb-2 mt-3 Ends --->
				<br>
				<div class="lead text-center">
					<span class="mt-3">Video Call Minutes : <span id="completeOrderMinutes"><?= $order_minutes; ?></span> </span> &nbsp; | &nbsp;
					<span class="remaining-minutes">Remaining Minutes : </span> <span class="countdown"><?= $order_minutes; ?></span>
				</div>
				<div class="text-center mt-4 mb-4">

					<?php if($buyer_id == $login_seller_id){ ?>
						<button class="btn start-archive btn-success mb-2">
							<i class="fa fa-play"></i> Start Video Call Recording</button>
						<button class="btn stop-archive btn-danger mb-2">
							<i class="fa fa-pause"></i> Stop Video Call Recording</button>
						<button class="btn download-archive btn-success mb-2">
							<i class="fa fa-download"></i> Download Recored Video Call
						</button>
					<?php } ?>

					<?php if($seller_id == $login_seller_id){ ?>

						<button class="btn extend-time btn-success mb-2" disabled="">
							<i class="fa fa-clock-o"></i> Extend Time
						</button>

						<button class="btn extend-time-custom-amount btn-success mb-2" disabled="">
							<i class="fa fa-plus-circle"></i> Extend Time with Custom Amount
						</button>

					<?php } ?>

					<button class="btn btn-success start-screen-share mb-2">
						<i class="fa fa- fa-desktop"></i> Start Screen Sharing
					</button>

					<button class="btn btn-success stop-screen-share d-none mb-2">
						<i class="fa fa- fa-desktop"></i> Stop Screen Sharing
					</button>

					<button class="btn btn-success open-messages mb-2">
						<span class="count-messages d-none"></span> <i class="fa fa-comments-o"></i> Messages
					</button>

				</div>
			</div><!-- modal-body Ends -->
		</div><!-- modal-content Ends -->
	</div><!-- modal-dialog Ends -->
</div><!-- video_chat_modal modal fade Ends -->

<?php include("../extendTime/extendTimeModal.php"); ?>

<script 
	type="text/javascript" 
	id="videoChatModalJs"
	src="<?= $site_url; ?>/plugins/videoPlugin/js/videoChatModal.js"
	data-base-url="<?= $site_url; ?>"
	data-name="<?= ucfirst($name); ?>"
	data-order-id="<?= $order_id; ?>"
	data-proposal-id="<?= $proposal_id; ?>"
	data-login-seller-id="<?= $login_seller_id; ?>"
	data-seller-id="<?= $seller_id; ?>"
	data-buyer-id="<?= $buyer_id; ?>"
	data-order-minutes="<?= $order_minutes; ?>" 
	data-id="<?= $where_array['id']; ?>" 
	data-call-number="<?= $where_array['call_number']; ?>" 
>
</script>