<!-- <div id="myCalendar" class="vanilla-calendar" style="margin-bottom: 20px"></div> -->
<form method="post" action="../../checkout" id="checkoutForm" class="<?=($lang_dir == "right" ? 'text-right':'')?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Month</label>
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>January</option>
                    <option>February</option>
                    <option selected>March</option>
                    <option>April</option>
                    <option>May</option>
                    <option>June</option>
                    <option>July</option>
                    <option>August</option>
                    <option>September</option>
                    <option>October</option>
                    <option>November</option>
                    <option>December</option>
                </select>
            </div>
        </div>


        <div class="col-md-12 mt-2 mb-4">
            <div class="avalaible-slots">
                <h2>Available Seats</h2>
                <div class="all-slots mb-4">
                    <button type="button" class="btn btn-dark mb-3 mr-2">
                        Monday <span class="badge badge-primary">4</span>
                    </button>
                    <button type="button" class="btn btn-dark mb-3 mr-2">
                        Tuesday <span class="badge badge-primary">4</span>
                    </button>
                    <button type="button" class="btn btn-dark mb-3 mr-2">
                        Friday <span class="badge badge-primary">4</span>
                    </button>
                    <button type="button" class="btn btn-dark mb-3 mr-2">
                        Saturday <span class="badge badge-primary">4</span>
                    </button>

                </div>

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

                <a class="btn btn-order" href="#">
                    Book Now
                </a>

            </div>
        </div>

    </div>
    <input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
    <input type="hidden" name="proposal_qty" value="1">
    <!-- <h3>
        <?= showPrice($proposal_price); ?> For 1 minute
        <span class="<?=($lang_dir == "left" ? 'float-right':'')?> font-weight-normal">
            <?= showPrice($proposal_price,$priceClass); ?>
        </span>
    </h3> -->

    <!-- <p class="mb-2">How many minutes of video time do you wish to purchase?</p> -->
    <!-- <input type="number" name="proposal_minutes" class="form-control mb-3" placeholder="5 Minutes" min="1" required=""> -->
    <!-- <h6 class="mb-3"><i class="fa fa-clock-o"></i> <?= $schedule_title; ?> Delivery</h6> -->



    <?php include('videoPluginButtons.php'); ?>

</form>