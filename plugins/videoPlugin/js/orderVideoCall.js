$(document).ready(function(){

  var base_url = $("#call-js").data("base-url");
  var order_id = $("#call-js").data("order-id");
  var proposal_id = $("#call-js").data("proposal-id");
  var login_seller_id = $("#call-js").data("login-seller-id");
  var seller_id = $("#call-js").data("seller-id");
  var buyer_id = $("#call-js").data("buyer-id");
  var start_call = $("#call-js").data("start-call");
  var warning_message = $("#call-js").data("warning-message");
  var orderCallTime = $("#call-js").data("order-call-time");
  var videoSessionTime = $("#call-js").data("video-session-time");

  // Propose Another Schedule
  $(document).on("click", "#proposeAnotherSchedule", function(event){
    var dateTime = $("#anotherScheduleTime").val();
    if(dateTime === ""){
      event.preventDefault();
      alert("Please set a date and time before proceeding, or accept the proposed date and time.");
    }
  });

  function video_call(){
    $('#wait').addClass("loader");
    data = {};
    data["order_id"] = order_id;
    data["proposal_id"] = proposal_id;
    data["sender_id"] = login_seller_id;
    data["receiver_id"] = $('.call-button').data("receiver_id");
    data["warning_message"] = warning_message;
    $.ajax({
      method: "POST",
      url: base_url+"/plugins/videoPlugin/ajax/video-chat-modal",
      data: { data },
      success: function(data) {
        if(!data.error){
          $('#wait').removeClass("loader");
          $("#video-chat-modal").html(data);
          //// (optional) add server code here
          // console.log($("#sessionId").val());
          // console.log($("#token").val());
          initializeSession($("#sessionId").val(), $("#token").val());
        }
      }
    });
  }
  
  if(start_call == 1){
    video_call();
  }

  $(document).on("click", ".call-button", function(){

    if(userbrowser == "MSIE" || userbrowser == "Trident" || userbrowser == "Edge"){
    
    }else{

      if(orderCallTime == 1 || login_seller_id == seller_id){
        if(login_seller_id == seller_id & orderCallTime == 0){
          if(confirm("This call is scheduled for "+videoSessionTime+". Do you wish to still proceed with the call")){
            video_call();
          }
        }else{
          video_call();
        }
      }else{
        $("#video-modal").modal('show');
      }

    }

  });

});