<?php if(isset($orderCallTime)){ ?>
<div id="video-modal" class="modal fade"><!--- video-modal Starts --->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Video Call </h5>
        <button class="close" data-dismiss="modal"><span> &times; </span></button>
      </div>
      <div class="modal-body text-center">
        <?php if($buyer_id == $login_seller_id){ ?>
          <p class="lead">You can initiate a video call only on or after <?= $orderCallTime->format("F d l, Y H:i A"); ?>. However, seller can initiate a video call anytime.</p>
        <?php }else{ ?>
          <p class="lead">You Can Video Call To Buyer On Or After : <?= $orderCallTime->format("F d l, Y H:i A"); ?></p>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!--- video-modal Ends --->
<?php } ?>