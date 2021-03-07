<form method="post" action="../../checkout" id="checkoutForm" class="<?=($lang_dir == "right" ? 'text-right':'')?>">
  
  <input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
  <input type="hidden" name="proposal_qty" value="1">
  <h3>
    <?= showPrice($proposal_price); ?> For 1 minute
    <span class="<?=($lang_dir == "left" ? 'float-right':'')?> font-weight-normal">
      <?= showPrice($proposal_price,$priceClass); ?>
    </span>
  </h3>
  
  <p class="mb-2">How many minutes of video time do you wish to purchase?</p>
  <input type="number" name="proposal_minutes" class="form-control mb-3" placeholder="5 Minutes" min="1" required="">
  <!-- <h6 class="mb-3"><i class="fa fa-clock-o"></i> <?= $schedule_title; ?> Delivery</h6> -->

  <h6 class="mb-3">
    <i class="fa fa-clock-o"></i> <?= $schedule_title; ?> Delivery
    &nbsp;&nbsp;
    <span class="float-right mr-3">
      <i class="fa fa-refresh"></i>&nbsp;

      <?php
        if($proposal_revisions != "unlimited"){
          echo $proposal_revisions.' Revisions';
        }else{
          echo "Unlimited Revisions";
        }
      ?>

    </span>
  </h6>

  <?php include('videoPluginButtons.php'); ?>

</form>