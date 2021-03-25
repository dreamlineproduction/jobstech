<?php if ($proposal_seller_user_name != @$_SESSION['seller_user_name']) : ?>
<div id="myCalendar" class="vanilla-calendar" style="margin-bottom: 20px"></div>
<?php endif; ?>

<h3>
    Price:
    <span class="<?= ($lang_dir == "left" ? 'float-right' : '') ?> font-weight-normal">
            <?= showPrice($proposal_price, $priceClass); ?>
        </span>
</h3>

<div id="notAvailable" class="d-none">
    <?php echo $lang['seat-not-available'] ?>
</div>

<form method="post" action="../../checkout" id="checkoutForm" class="<?= ($lang_dir == "right" ? 'text-right' : '') ?> <?= $proposal_seller_user_name != @$_SESSION['seller_user_name'] ? 'd-none' : '' ?>">
    <input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
    <input type="hidden" name="proposal_qty" value="1">
    <input type="hidden" name="class_date" id="classDate" value="">
    <input type="hidden" name="class_time" id="classTime" value="">

    <!-- <p class="mb-2">How many minutes of video time do you wish to purchase?</p> -->
    <!-- <input type="number" name="proposal_minutes" class="form-control mb-3" placeholder="5 Minutes" min="1" required=""> -->
    <!-- <h6 class="mb-3"><i class="fa fa-clock-o"></i> <?= $schedule_title; ?> Delivery</h6> -->


    <?php include('videoPluginButtons.php'); ?>

</form>