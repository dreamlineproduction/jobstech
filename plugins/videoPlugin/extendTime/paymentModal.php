<?php

$login_seller_email = escape($row_login_seller->seller_email);

$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$enable_paypal = escape($row_payment_settings->enable_paypal);
$enable_stripe = escape($row_payment_settings->enable_stripe);
$enable_dusupay = escape($row_payment_settings->enable_dusupay);
$dusupay_method = escape($row_payment_settings->dusupay_method);
$dusupay_provider_id = escape($row_payment_settings->dusupay_provider_id);

$enable_coinpayments = escape($row_payment_settings->enable_coinpayments);
$coinpayments_merchant_id = escape($row_payment_settings->coinpayments_merchant_id);
$coinpayments_currency_code = escape($row_payment_settings->coinpayments_currency_code);

if($paymentGateway == 1){
  $enable_2checkout = escape($row_payment_settings->enable_2checkout);
  $get_plugin = $db->query("select * from plugins where folder='paymentGateway'");
  $row_plugin = $get_plugin->fetch();
  $paymentGatewayVersion = $row_plugin->version;
}else{
  $enable_2checkout = "no"; 
  $paymentGatewayVersion = 0.0;
}


$enable_mercadopago = escape($row_payment_settings->enable_mercadopago);
$enable_paystack = escape($row_payment_settings->enable_paystack);

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = escape($row_seller_accounts->current_balance);

$select_proposals = $db->select("proposals",array("proposal_id"=>$proposal_id));
$row_proposals = $select_proposals->fetch();
$proposal_title = escape($row_proposals->proposal_title);
$site_logo = escape($row_general_settings->site_logo);

$processing_fee = processing_fee($amount);

// below variable shall use in paymentMethodCharges
$_SESSION['extendId'] = escape($extend_time->id);
$_SESSION['extendOrderId'] = escape($order_id);
$_SESSION['extendProposalId'] = escape($proposal_id);

?>

<div id="payment-modal" style="z-index: 5051;" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><!-- modal-header Starts -->
        <h5 class="modal-title"> 
          <span class="float-left">Pay For <?= $extend_time->extended_minutes ?> minutes extention.</span>
        </h5>
        <button class="closeExtendTimePayment close" data-dismiss="modal">
          <span> &times; </span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div class="payment-options-list">
          <?php if($current_balance >= $amount){ ?>
          <div class="payment-options mb-2">
            <input type="radio" name="payment_option" id="shopping-balance" class="radio-custom" checked>
            <label for="shopping-balance" class="radio-custom-label" ></label>
            <span class="lead font-weight-bold"> Shopping Balance </span>
            <p class="lead ml-5">
              Personal Balance - <?= $login_seller_user_name; ?> <span class="text-success font-weight-bold"> <?= showPrice($current_balance); ?> </span>
            </p>
          </div>
          <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_coinpayments == "yes" or $enable_dusupay == "yes"){ ?>
          <hr>
          <?php } ?>
          <?php } ?>
          <?php if($enable_paypal == "yes"){ ?>
          <div class="payment-option">
            <input type="radio" name="payment_option" id="paypal" class="radio-custom" <?php if($current_balance < $amount){ echo "checked"; } ?>>
            <label for="paypal" class="radio-custom-label"></label>
            <img src="images/paypal.png" class="img-fluid">
          </div>
          <?php } ?>
          <?php if($enable_stripe == "yes"){ ?>
          <?php if($enable_paypal == "yes"){ ?>
          <hr>
          <?php } ?>
          <div class="payment-option">
            <input type="radio" name="payment_option" id="credit-card" class="radio-custom" <?php if($current_balance < $amount){ if($enable_paypal == "no"){ echo "checked";}} ?>>
            <label for="credit-card" class="radio-custom-label"></label>
            <img src="images/credit_cards.jpg" class="img-fluid">
          </div>
          <?php } ?>

          <?php 
            if($enable_2checkout == "yes" AND $paymentGatewayVersion >= 1.1){ 
              include("$dir/plugins/paymentGateway/paymentMethod2.php");
            }
          ?>

          <?php if($enable_mercadopago == "1"){ ?>
          <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes"){ ?>
          <hr>
          <?php } ?>
          <div class="payment-option">
            <input type="radio" name="payment_option" id="mercadopago" class="radio-custom"
                <?php
                if($current_balance < $amount){
                  if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_mercadopago == "1"){ 
                  echo "checked";
                  }
                }
                ?>>
            <label for="mercadopago" class="radio-custom-label"></label>
            <img src="images/mercadopago.png" class="img-fluid">
          </div>
          <?php } ?>

          <?php if($enable_coinpayments == "yes"){ ?>
          <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes" or $enable_mercadopago == "1"){ ?>
          <hr>
          <?php } ?>
          <div class="payment-option">
            <input type="radio" name="payment_option" id="coinpayments" class="radio-custom"
              <?php
                if($current_balance < $amount){
                  if($enable_paypal == "no" and $enable_stripe == "no"){ 
                    echo "checked";
                  }
                }
                ?>
              >
            <label for="coinpayments" class="radio-custom-label"></label>
            <img src="images/coinpayments.png">
          </div>
          <?php } ?>

          <?php if($enable_paystack == "yes"){ ?>
          <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_coinpayments == "yes"){ ?>
          <hr>
          <?php } ?>
          <div class="payment-option">
            <input type="radio" name="payment_option" id="paystack" class="radio-custom"
              <?php
                if($current_balance < $amount){
                if($enable_paypal == "no" and $enable_stripe == "no" and $enable_coinpayments == "no"){ 
                echo "checked";
                }
                }
                ?>>
            <label for="paystack" class="radio-custom-label"></label>
            <img src="images/paystack.png" class="img-fluid">
          </div>
          <?php } ?>

          <?php if($enable_dusupay == "yes"){ ?>
          <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_coinpayments =="yes" or $enable_paystack =="yes"){ ?>
          <hr>
          <?php } ?>
          <div class="payment-option">
            <input type="radio" name="payment_option" id="mobile-money" class="radio-custom"
              <?php
                if($current_balance < $amount){
                if($enable_paypal == "no" and $enable_stripe == "no" and $enable_coinpayments == "no" and $enable_paystack == "no"){ 
                	echo "checked"; 
                }
                }
              ?>
              >
            <label for="mobile-money" class="radio-custom-label"></label>
            <img src="images/mobile-money.png" class="img-fluid">
          </div>
          <?php } ?>

        </div>
      </div>
      <div class="modal-footer">

        <button class="closeExtendTimePayment btn btn-secondary" data-dismiss="modal"> Close </button>

        <?php if($current_balance >= $amount){ ?>
        <form action="plugins/videoPlugin/extendTime/charge/shoppingBalance" target="_blank" method="post" id="shopping-balance-form">
          <button class="btn btn-success" type="submit" name="extendTime" onclick="return confirm('Are you sure you want to pay for this with your shopping balance?')">
            Pay With Shopping Balance
          </button>
        </form>
        <br>
        <?php } ?>

        <?php if($enable_paypal == "yes"){ ?>
          <div id="paypal-form" class="paypal-button-container"></div>
        <?php } ?>

        <?php if($enable_stripe == "yes"){ ?>

        <form action="plugins/videoPlugin/extendTime/charge/stripeCharge" target="_blank" method="post" id="credit-card-form"><!--- credit-card-form Starts --->

          <input name="stripe" type="submit" class="btn btn-success" value="<?= $lang['button']['pay_with_stripe']; ?>"/>

        </form><!--- credit-card-form Ends --->

        <?php } ?>
        
        <?php if($enable_2checkout == "yes" AND $paymentGatewayVersion >= 1.2){ ?>
        <form action='plugins/paymentGateway/extendTime/2checkout_charge' target="_blank" id="2checkout-form" method='post'>
          <input name='2Checkout' type='submit' class="btn btn-success btn-block" value='Pay With 2Checkout'/>
        </form>
        <?php } ?>

        <?php if($enable_mercadopago == "1"){ ?>
        <form action="plugins/videoPlugin/extendTime/charge/mercadopago" target="_blank" method="post" id="mercadopago-form">
          <input type="submit" name="mercadopago" class="btn btn-success" value="<?= $lang['button']['pay_with_mercadopago']; ?>">
        </form>
        <?php } ?>

        <?php if($enable_paystack == "yes"){ ?>
        <form action="plugins/videoPlugin/extendTime/charge/paystackCharge" target="_blank" method="post" id="paystack-form"><!--- paystack-form Starts --->
          <button type="submit" name="paystack" class="btn btn-success btn-block">Pay With Paystack</button>
        </form><!--- paystack-form Ends --->
        <?php } ?>
      
        <?php 
           if($enable_dusupay == "yes"){
              $main_modal = "payment-modal";
              $form_action = "plugins/videoPlugin/extendTime/charge/dusupayCharge";
              $extendTimePayment = 1;
              include("$dir/includes/comp/dusupay_method2.php");
           }
        ?>

        <?php if($enable_coinpayments == "yes"){ ?>
          <form action="plugins/videoPlugin/extendTime/charge/coinpaymentsCharge" target="_blank" method="post" id="coinpayments-form">
            <button type="submit" name="coinpayments" class="btn btn-success"><?= $lang['button']['pay_with_coinpayments']; ?></button>
          </form>
        <?php } ?>
        
      </div>
    </div>
  </div>
</div>

<?php include("$dir/includes/comp/mobile_money_modal.php"); ?>

<script 
  src="<?= $site_url; ?>/js/paypal.js" 
  id="paypal-js" 
  data-base-url="<?= $site_url; ?>" 
  data-payment-type="orderExtendTime">
</script>