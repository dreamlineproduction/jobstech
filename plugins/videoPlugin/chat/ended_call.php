<div id="ended_call_modal" class="modal fade"><!-- ended_call modal fade Starts -->
	<div class="modal-dialog"><!-- modal-dialog Starts -->
		<div class="modal-content"><!-- modal-content Starts -->
			<div class="modal-header"><!-- modal-header Starts -->
				<h5 class="modal-title"> Missed Call</h5>
				<button data-dismiss="modal" class="close close-button">
					<span>&times;</span>
				</button>
			</div><!-- modal-header Ends -->
			<div class="modal-body"><!-- modal-body Starts -->

				<img src="<?= $sender_image; ?>" class='float-left img-fluid rounded-circle' width="45">
				<span class="ml-2 font-weight-bold mt-1 name"><?= $sender_user_name; ?></span>

				<div class='group-body ml-1'>
					<?php if(@$online == 1){ ?>
						<span class="ml-2 mt-2 float-right text-success status">Online</span>
					<?php } ?>

					<p class="mb-0 pl-5 ml-2 message">
						You Missed A Call From <span class="text-success"><?= $sender_user_name; ?></span>
					</p>
				</div>

			</div><!-- modal-body Ends -->
			<div class="modal-footer"><!-- modal-footer Starts -->
				<button class="btn btn-small btn-default close-button">Close</button>
			</div><!-- modal-footer Ends -->
		</div><!-- modal-content Ends -->
	</div><!-- modal-dialog Ends -->
</div><!-- ended_call modal fade Ends -->

<script 
type="text/javascript" 
id="endedCallJs"
src="<?= $site_url; ?>/plugins/videoPlugin/js/endedCall.js"
data-base-url="<?= $site_url; ?>"
></script>