<?php

session_start();
include("../../../../../includes/db.php");
include("$dir/functions/payment.php");

if(!isset($_SESSION['seller_user_name'])){
   echo "<script>window.open('login','_self');</script>";
}

if(isset($_GET['session_id'])){

   $payment = new Payment();
   if($payment->stripe_execute()){
   	   require_once("../extendTimePurchase.php");
   }

}