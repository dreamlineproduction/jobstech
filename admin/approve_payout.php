<?php

@session_start();

require_once "$dir/functions/payment.php";
require_once "$dir/vendor/autoload.php";

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login.php','_self');</script>";

    exit();

}

if (isset($_GET['approve_payout'])) {

    $id = $input->get('approve_payout');

    // Fetch selected payout info
    $get = $db->select("payouts", array('id' => $id));
    $row = $get->fetch();
    echo '<pre>' . print_r($row, true) . '</pre>';

    $seller_id = $row->seller_id;
    $method = $row->method;
    $amount = $row->amount;

    // Fetch payee info
    $get_seller = $db->select("sellers", array("seller_id" => $seller_id));
    $row_seller = $get_seller->fetch();
    $seller_email = $row_seller->seller_paypal_email;
    die('<pre>' . print_r($row_seller, true) . '</pre>');

    // Fetch payment settings
    $get_payment_settings = $db->select("payment_settings");
    $row_payment_settings = $get_payment_settings->fetch();
    $withdrawal_limit = $row_payment_settings->withdrawal_limit;
    $paypal_email = $row_payment_settings->paypal_email;
    $paypal_currency_code = $row_payment_settings->paypal_currency_code;
    $paypal_app_client_id = $row_payment_settings->paypal_app_client_id;
    $paypal_app_client_secret = $row_payment_settings->paypal_app_client_secret;
    $paypal_sandbox = $row_payment_settings->paypal_sandbox;

    if ($paypal_sandbox == "on") {
        $mode = "sandbox";
    } elseif ($paypal_sandbox == "off") {
        $mode = "live";
    }

    //Api Setup
    $api = new ApiContext(
        new OAuthTokenCredential(
            "$paypal_app_client_id",
            "$paypal_app_client_secret"
        )
    );

    $api->setConfig([
        "mode" => "$mode"
    ]);

    // Setup Payout
    $payouts = new PayPal\Api\Payout();

    $senderBatchHeader = new PayPal\Api\PayoutSenderBatchHeader();


    $senderBatchHeader->setSenderBatchId(uniqid())->setEmailSubject("You Have Paypal Payout Payment From $site_name");

    $senderItem = new \PayPal\Api\PayoutItem();

    $senderItem->setRecipientType("Email")
        ->setReceiver("$seller_email")
        ->setAmount(new \PayPal\Api\Currency(
            '{
            "value":"' . $amount . '",
            "currency":"' . $paypal_currency_code . '"
            }'
        ));

    $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);

    // Create Payout
    try {

        if ($payouts->create(null, $api)) {

            $update = $db->update("payouts", ["status" => 'completed'], ["id" => $id]);

            if ($update) {

                $update_seller_account = $db->query("update seller_accounts set current_balance=current_balance-:minus,withdrawn=withdrawn+:plus where seller_id='$login_seller_id'", array("minus" => $amount, "plus" => $amount));

                if ($update_seller_account) {

                    $update_seller = $db->query("update sellers set seller_payouts=seller_payouts+1 where seller_id='$login_seller_id'");

                    /*$date = date("F d, Y");

                    $range = range('A', 'Z');
                    $index = array_rand($range);
                    $index2 = array_rand($range);
                    $ref = "P-" . mt_rand(100000, 999999) . $range[$index] . $range[$index2];

                    $insert_withdrawal = $db->insert("payouts", array("seller_id" => $login_seller_id, "ref" => $ref, "method" => "paypal", "amount" => $amount, "date" => $date, "status" => 'completed'));

                    echo "<script>alert('Your funds ($$amount) has been transferred to your paypal account successfully.');</script>";

                    echo "<script>window.open('$site_url/revenue','_self')</script>";*/

                    $seller_phone = $row_seller->seller_phone;

                    $date = date("F d, Y");

                    $insert_notification = $db->insert("notifications", array("receiver_id" => $seller_id, "sender_id" => "admin_$admin_id", "order_id" => $id, "reason" => "withdrawal_approved", "date" => $date, "status" => "unread"));

                    /// sendPushMessage Starts
                    $notification_id = $db->lastInsertId();
                    sendPushMessage($notification_id);
                    /// sendPushMessage Ends

                    if ($notifierPlugin == 1) {
                        $smsText = $lang['notifier_plugin']['payout_approved'];
                        sendSmsTwilio("", $smsText, $seller_phone);
                    }

                    echo "
		<script>
			alert('One Payout Request Has Been Approved.');
			window.open('index?payouts&status=completed','_self');
		</script>";

                }

            }

        }

    } catch (Exception $ex) {

        echo "<pre>";
        print_r($ex);
        echo "</pre>";
        exit();

        echo "<script>
	alert('Sorry An error occurred During Sending Your Money To Your Paypal Account.');
	window.open('revenue','_self')
</script>";

    }

    ?>

<?php } ?>