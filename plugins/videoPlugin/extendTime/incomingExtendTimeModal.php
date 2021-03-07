<div id="incomingExtendTime" class="modal fade" style="z-index: 7050;"><!-- incomingExtendTime modal fade Starts -->
	<div class="modal-dialog"><!-- modal-dialog Starts -->
		<div class="modal-content"><!-- modal-content Starts -->
			<div class="modal-header"><!-- modal-header Starts -->
				<h5 class="modal-title"> Extend Time Request For Order #<?= $order_number; ?> </h5>
			</div><!-- modal-header Ends -->
			<div class="modal-body"><!-- modal-body Starts -->
				<img src="<?= $image; ?>" class='float-left img-fluid rounded-circle' width="45">
				<span class="font-weight-bold mt-1 ml-2 name"><?= $name; ?></span>
				<div class='group-body ml-1'>
					<?php if(@$online == 1){ ?>
						<span class="ml-2 mt-2 float-right text-success status">Online</span>
					<?php } ?>
					<p class="mb-0 pl-5 ml-2 message"><?= $name; ?> wishes to extend the time by <?= $extend_time->extended_minutes; ?> minutes.</p>
					<p class="mb-0 pl-5 ml-2 message">If you confirm, this will cost you an extra $<?= $amount; ?>. Do you wish to confirm?</p>
					<button id="accept-offer" target="blank" class="btn btn-small btn-success float-right ml-3 mt-3"> Yes </button>
					<button id="decline-offer" class="btn btn-small btn-warning float-right mt-3"> No </button>
				</div>
			</div><!-- modal-body Ends -->
		</div><!-- modal-content Ends -->
	</div><!-- modal-dialog Ends -->
</div><!-- incomingExtendTime modal fade Ends -->
<?php include("paymentModal.php"); ?>

<script 
type="text/javascript" 
id="extendTimeJs"
src="<?= $site_url; ?>/plugins/videoPlugin/js/incomingExtendTimeModal.js"
data-base-url="<?= $site_url; ?>"
data-name="<?= ucfirst($name); ?>"
data-order-id="<?= $order_id; ?>"
data-id="<?= $extend_time->id; ?>"
data-current_balance="<?= $current_balance; ?>"
data-amount="<?= $amount; ?>"
data-enable_paypal="<?= $enable_paypal; ?>"
data-enable_stripe="<?= $enable_stripe; ?>"
data-enable_coinpayments="<?= $enable_coinpayments; ?>"
data-enable_paystack="<?= $enable_paystack; ?>"
data-enable_2checkout="<?= $enable_2checkout; ?>"
data-enable_mercadopago="<?= $enable_mercadopago; ?>"
></script>