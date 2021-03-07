$(document).ready(function(){
   
   var base_url = $("#extendTimeJs").data("base-url");
   var order_id = $("#extendTimeJs").data("order-id");
   var id = $("#extendTimeJs").data("id");
   var name = $("#extendTimeJs").data("name");
   var current_balance = $("#extendTimeJs").data("current_balance");
   var amount = $("#extendTimeJs").data("amount");
   var enable_paypal = $("#extendTimeJs").data("enable_paypal");
   var enable_stripe = $("#extendTimeJs").data("enable_stripe");
   var enable_2checkout = $("#extendTimeJs").data("enable_2checkout");
   var enable_mercadopago = $("#extendTimeJs").data("enable_mercadopago");
   var enable_coinpayments = $("#extendTimeJs").data("enable_coinpayments");
   var enable_paystack = $("#extendTimeJs").data("enable_paystack");

   $('#incomingExtendTime').modal({ backdrop: 'static', show: true });
   
   // Accept Offer
   $("#accept-offer").click(function(){
      $.ajax({
      method: "POST",
      url: base_url+"/plugins/videoPlugin/extendTime/ajax/accept",
      data: {id:id,order_id:order_id},
    }).done(function(data){
         $("#incomingExtendTime").modal("hide");
         $("#intervalStatus").val("stopped");
         clearInterval(orderMinutesInterval);
         $("#payment-modal").modal({show:true,backdrop:'static'});
      });
   });

   // Decline Offer
   $("#decline-offer").click(function(){
      $.ajax({
         method: "POST",
         url: base_url+"/plugins/videoPlugin/extendTime/ajax/decline",
         data: {id:id,order_id:order_id},
      }).done(function(data){
         console.log(data);
         if(data==1){
            alert('You have declined the extendTime offer of '+name+'.');
            $("#incomingExtendTime").modal("hide");
         }
      });
   });

   // Payment Modal
   $('#payment-modal').on('shown.bs.modal', function(event){
      $(".is-responsive").addClass("modal-open");
   });

   // Delete ExtendTime
   function deleteExtendTime(){
      $.ajax({
         method: "POST",
         url: base_url+"/plugins/videoPlugin/extendTime/ajax/delete",
         data: {id:id,order_id:order_id},
      }).done(function(data){
         $("#intervalStatus").val("run");
      });
   }

   // closeExtendTimePayment
   $(".closeExtendTimePayment").click(function(){
    deleteExtendTime();
   });

   // Stripe
   $('.stripe-submit').on('click', function(event) {
     event.preventDefault();
     var $button = $(this),
     $form = $button.parents('form');
     var opts = $.extend({}, $button.data(), {
      token: function(result) {
        $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
      }
     });
     StripeCheckout.open(opts);
   });


   $("#offer-order-modal").modal('show');
   $(".offer-div").hide();

   $(".arrow").click(function(){
      $(".offer-div").slideToggle();
   });

   $(".btn-close").click(function(){
      $(".request-div").fadeOut().remove();
      $(".offer-div").fadeOut().remove();
   });

   if(current_balance >= amount){
      $('#paypal-form').hide();
      $('#credit-card-form').hide();
      $('#2checkout-form').hide();
      $('#mercadopago-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').hide();
      $('#mobile-money-form').hide();
   }else{
      $('#shopping-balance-form').hide();
   }

   if(current_balance < amount){

      if(enable_paypal == "yes"){
         
      }else{
         $('#paypal-form').hide();
      }

   }

   if(current_balance < amount){

      if(enable_paypal == "yes"){
         
         $('#credit-card-form').hide();
         $('#2checkout-form').hide();
         $('#mercadopago-form').hide();
         $('#mobile-money-form').hide();
         $('#coinpayments-form').hide();
         $('#paystack-form').hide();

      }else if(enable_paypal == "no" & enable_stripe == "yes"){
         
         $('#2checkout-form').hide();
         $('#mercadopago-form').hide();
         $('#coinpayments-form').hide();
         $('#mobile-money-form').hide();
         $('#paystack-form').hide();
      
      }else if(enable_paypal == "no" & enable_stripe == "no" & enable_2checkout == "yes") {
      
         $('#mercadopago-form').hide();
         $('#coinpayments-form').hide();
         $('#mobile-money-form').hide();
         $('#paystack-form').hide();

      }else if(enable_paypal == "no" & enable_stripe == "no" & enable_2checkout == "no" & enable_mercadopago == "yes") {
      
         $('#coinpayments-form').hide();
         $('#mobile-money-form').hide();
         $('#paystack-form').hide();

      }else if(enable_paypal == "no" & enable_stripe == "no" & enable_2checkout == "no" & enable_mercadopago == "no" & enable_coinpayments == "yes") {
      
         $('#mobile-money-form').hide();
         $('#paystack-form').hide();
      
      }else if(enable_paypal == "no" & enable_stripe == "no" & enable_2checkout == "no" & enable_mercadopago == "no" & enable_coinpayments == "no" & enable_paystack == "yes") {
      
         $('#mobile-money-form').hide();
      
      }
   
   }

   $('#shopping-balance').click(function(){
      $('#credit-card-form').hide();
      $('#2checkout-form').hide();
      $('#mercadopago-form').hide();
      $('#mobile-money-form').hide();
      $('#paypal-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').hide();
      $('#shopping-balance-form').show();
   });

   $('#paypal').click(function(){
      $('#paypal-form').show();
      $('#credit-card-form').hide();
      $('#2checkout-form').hide();
      $('#mercadopago-form').hide();
      $('#shopping-balance-form').hide();
      $('#mobile-money-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').hide();
   });

   $('#credit-card').click(function(){
      $('#credit-card-form').show();
      $('#2checkout-form').hide();
      $('#mercadopago-form').hide();
      $('#paypal-form').hide();
      $('#shopping-balance-form').hide();
      $('#mobile-money-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').hide();
   });

   $('#2checkout').click(function(){
      $('#mobile-money-form').hide();
      $('#credit-card-form').hide();
      $('#2checkout-form').show();
      $('#mercadopago-form').hide();
      $('#paypal-form').hide();
      $('#shopping-balance-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').hide();
   });

   $('#mercadopago').click(function(){
      $('#mobile-money-form').hide();
      $('#credit-card-form').hide();
      $('#2checkout-form').hide();
      $('#mercadopago-form').show();
      $('#paypal-form').hide();
      $('#shopping-balance-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').hide();
   });

   $('#coinpayments').click(function(){
      $('#mobile-money-form').hide();
      $('#credit-card-form').hide();
      $('#2checkout-form').hide();
      $('#mercadopago-form').hide();
      $('#paypal-form').hide();
      $('#coinpayments-form').show();
      $('#paystack-form').hide();
      $('#shopping-balance-form').hide();
   });

   $('#paystack').click(function(){
      $('#mobile-money-form').hide();
      $('#credit-card-form').hide();
      $('#2checkout-form').hide();
      $('#mercadopago-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').show();
      $('#paypal-form').hide();
      $('#shopping-balance-form').hide();
   });

   $('#mobile-money').click(function(){
      $('#paypal-form').hide();
      $('#credit-card-form').hide();
      $('#2checkout-form').hide();
      $('#mercadopago-form').hide();
      $('#shopping-balance-form').hide();
      $('#coinpayments-form').hide();
      $('#paystack-form').hide();
      $('#mobile-money-form').show();
   });

});