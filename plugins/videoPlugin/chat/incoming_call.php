<?php 

$select_sender = $db->select("sellers",array("seller_id" => $data['sender_id']));
$row_sender = $select_sender->fetch();
$name = escape($row_sender->seller_user_name);
$image = getImageUrl2("sellers","seller_image",$row_sender->seller_image);

if(empty($image)){
	$image = "empty-image.png";
}

$get_order = $db->select("orders",array("order_id"=>$data['order_id']));
$count_orders = $get_order->rowCount();
$row_order = $get_order->fetch();
$order_id = escape($row_order->order_id);
$seller_id = escape($row_order->seller_id);
$proposal_id = escape($row_order->proposal_id);
$order_minutes = escape($row_order->order_minutes);

// Select Order Proposal Details ///
$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));
$row_proposal = $select_proposal->fetch();
$proposal_cat_id = escape($row_proposal->proposal_cat_id);

/// Get Category Details
$get_cat = $db->select("categories",array('cat_id'=>$proposal_cat_id));
$row_cat = $get_cat->fetch();
$c_video = escape($row_cat->video);
$warning_message = escape($row_cat->warning_message);

?>
<div id="video_chat_accept" class="modal fade" style="z-index: 7050;"><!-- video_chat_accept modal fade Starts -->
	<div class="modal-dialog"><!-- modal-dialog Starts -->
	<div class="modal-content"><!-- modal-content Starts -->
		<div class="modal-header"><!-- modal-header Starts -->
			<h5 class="modal-title"> Incoming Video Call </h5>
		</div><!-- modal-header Ends -->
		<div class="modal-body"><!-- modal-body Starts -->
			<img src="<?= $image; ?>" class='float-left img-fluid rounded-circle' width="45">
			<span class="font-weight-bold mt-1 ml-2 name"><?= $name; ?></span>
			<div class='group-body ml-1'>
				<?php if(@$online == 1){ ?>
				<span class="ml-2 mt-2 float-right text-success status">Online</span>
				<?php } ?>
				<p class="mb-0 pl-5 ml-2 message">The Call Will Start As Soon As You Answer.</p>
				<input type="hidden" id="sessionId" value="<?= $data['call_number']; ?>">
				<input type="hidden" id="token" value="<?= $data['call_token']; ?>">
				<button id="accept-call-button" class="btn btn-small btn-primary float-right ml-3 mt-3"> Accept </button>
				<button id="decline-call" class="btn btn-small btn-danger float-right mt-3">Decline</button>
			</div>
		</div><!-- modal-body Ends -->
	</div><!-- modal-content Ends -->
	</div><!-- modal-dialog Ends -->
</div><!-- video_chat_accept modal fade Ends -->

<script 
type="text/javascript" 
id="incomingJs"
src="<?= $site_url; ?>/plugins/videoPlugin/js/incomingCall.js"
data-base-url="<?= $site_url; ?>"
data-order_id = "<?= $data['order_id']; ?>"
data-sender_id = "<?= $data['sender_id']; ?>"
data-receiver_id = "<?= $data['receiver_id']; ?>"
data-warning_message="<?= $warning_message ?>" 
></script>