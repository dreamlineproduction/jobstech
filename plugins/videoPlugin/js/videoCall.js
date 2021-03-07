$(document).ready(function(){
  var base_url = $("#video-js").data("base-url");
  var login_seller_id = $("#video-js").data("seller-id");
  var opentok_api_key = $("#video-js").data("opentok-api-key");
  
  // this stopInterval function is not in use right now
  var stopInterval = function(intervalId, callback){
    clearInterval(intervalId);
    callback();
  }

  var incoming_call = function(){
    $.ajax({
      type: "POST",
      url: base_url+"/plugins/videoPlugin/ajax/incoming-call"
    }).done(function(data){
      if(data !== "failed"){
        $("#incoming-call").html(data);
      }else{
        setTimeout(incoming_call, 6000);
      }
    });
  }
  incoming_call();

  var ended_call = function(){
    $.ajax({
      type: "POST",
      url: base_url+"/plugins/videoPlugin/ajax/ended-call"
    }).done(function (data){
      if(data !== "failed"){
        $("#incoming-call").html(data);
      }else{
        setTimeout(ended_call, 12000);
      }
    });
  }
  ended_call();

  $(document).on("click", ".leave-button", function(){
    $('#wait').addClass("loader");
    var orderId = $("#orderId").val();
    var call_number = $("#sessionId").val();
    $.ajax({
      method: "POST",
      url: base_url+"/plugins/videoPlugin/ajax/end-call",
      data: {call_number: call_number},
      success: function(data){
        if(data == "ok"){
          $('#wait').removeClass("loader");
           window.open("order_details?order_id="+orderId,"_self"); 
        }
      }
    });
  });

});

var date = $("#video-js").data("date");
var admin_image = $("#video-js").data("admin-image");

function orderMinutesInterval(){
  var intervalStatus = $("#intervalStatus").val();
  if(intervalStatus == "run"){
    var orderId = $("#orderId").val();
    var timer2 = $("#orderMinutes").val();
    var warning_message = $("#warningMessage").val();

    var timer = timer2.split(':');
    //by parsing integer, I avoid all extra string processing
    var minutes = parseInt(timer[0], 10);
    var seconds = parseInt(timer[1], 10);
    if(minutes == 0 & seconds == 0){

    }else{
      --seconds; 
      minutes = (seconds < 0) ? --minutes : minutes;
      if (minutes < 0) clearInterval(interval);
      seconds = (seconds < 0) ? 59 : seconds;
      seconds = (seconds < 10) ? '0' + seconds : seconds;
      //minutes = (minutes < 10) ?  minutes : minutes;
      $('.countdown').html(minutes + ':' + seconds);
      $('#orderMinutes').val(minutes + ':' + seconds);
      timer2 = minutes + ':' + seconds;
      $.ajax({
        url:base_url+"/plugins/videoPlugin/ajax/change_minutes",type:"POST",
        data:{order_id: orderId, order_minutes: timer2}
      });
      if(warning_message > 0){
        if(minutes == warning_message & seconds == 0){
          html = "<div class='header-message-div'> <a class='float-left' href='#'> <img src='"+base_url+"/admin/admin_images/"+admin_image+"' width='50' height='50' class='rounded-circle'><strong class='heading'>Video Call</strong><p class='message'>Only "+warning_message+" more minute(s) left for this video session.</p><p class='date text-muted'>"+date+"</p> </a> <a href='#' class='float-right close closePopup btn btn-sm pl-lg-5 pt-0'><i class='fa fa-times'></i></a></div>";
          $('.messagePopup').prepend(html);
        }
      }
    }
  }
}

// replace these values with those generated in your TokBox Account
var apiKey = $("#video-js").data("opentok-api-key");

// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

OT.checkScreenSharingCapability(function(response) {
  if(!response.supported || response.extensionRegistered === false) {
    // This browser does not support screen sharing
    alert('This browser does not support screen sharing');
  }else{
    // alert('This browser support screen sharing');
  }
});

registerListeners();

function initializeSession(sessionId, token){
  var orderMinutes;
  
  session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function(event){
    
    // extendtime
    $('#video_chat_modal .extend-time').prop('disabled',false);
    $('#video_chat_modal .extend-time-custom-amount').prop('disabled',false);
    $("#subscriber-ringing,#subscriber-ended,#subscriber-declined").addClass("d-none");
    $("#subscriber-stream").removeClass("d-none");
    $("#subscriber").removeClass("bg-dark");

    $("#intervalStatus").val("run");
    var activeUser = $("#activeUser").val();

    if(activeUser == "seller"){
      orderMinutes = setInterval(orderMinutesInterval, 1000);
    }else{
      setTimeout(function(){ 
        orderMinutes = setInterval(orderMinutesInterval, 1000);
      },2000);
    }

    data = {};
    data["order_id"] =  $("#orderId").val();
    data["warning_message"] = "";
    $.ajax({
      url:base_url+"/plugins/videoPlugin/ajax/accept-call",
      type:"POST",
      data:{data},
    });

    streamContainer = event.stream.videoType === "screen" ? "subscriber-screen" : "subscriber-stream";

    session.subscribe(event.stream,streamContainer, {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    },handleScreenShare(event.stream.videoType));

  });

  session.on("streamDestroyed", event => {

    streamType = event.stream.videoType;

    if(streamType == "screen"){

      $('#video_chat_modal #subscriber-stream').addClass("w-100 h-100").removeClass("small");
      $('#video_chat_modal #subscriber-screen').addClass("d-none");

      console.log("subscriber screen share removed.");

    }

  });

  // Create a publisher
  publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);

  // when user end the call
  session.on("connectionDestroyed", function(event){
    /// extendTime
    $('#video_chat_modal .extend-time').prop('disabled',true);
    $('#video_chat_modal .extend-time-custom-amount').prop('disabled',true);
     
    $("#subscriber").addClass("bg-dark");
    $("#subscriber-ringing,#subscriber-stream,#subscriber-screen").addClass("d-none");
    $("#subscriber-ended").removeClass("d-none");
    $("#intervalStatus").val("stopped");
    clearInterval(orderMinutes);
  });

  // Connect to the session
  session.connect(token, function(error) {
    // If the connection is successful, publish to the session
    if(error){
      handleError(error);
    }else{
      session.publish(publisher,handleError);
    }
  });

  session.on('archiveStarted', function(event) {
    archiveID = event.id;
    console.log('ARCHIVE STARTED');
    $('.start-archive').hide();
    $('.download-archive').hide();
    $('.stop-archive').show();
  });

  session.on('archiveStopped', function(event) {
    archiveID = event.id;
    console.log('ARCHIVE STOPPED');
    $('.start-archive').hide();
    $('.stop-archive').hide();
    $('.download-archive').show();
  });

}

// Screenshare layout
function handleScreenShare(streamType, error) {
  if(error){
    console.log("error: " + error.message);
  }else{

    console.log("handleScreenShare event runs");

    if(streamType === "screen"){

      $('#video_chat_modal #subscriber-stream').removeClass("w-100 h-100").addClass("small");
      $('#video_chat_modal #subscriber-screen').removeClass("d-none");

      console.log("subscriber screen share added.");

    }else{

      console.log("subscriber screen share removed.");

      $('#video_chat_modal #subscriber-stream').addClass("w-100 h-100").removeClass("small");
      $('#video_chat_modal #subscriber-screen').addClass("d-none");

    }
  }
}

function registerListeners() {

  startShareBtn = $('.start-screen-share');
  stopShareBtn = $('.stop-screen-share');

  stopShareBtn.removeClass("d-none");

  $(document).on("click",".start-screen-share",function(){

    // if(confirm('Do you want to show your face also on left side?')){

    // }else{

      OT.checkScreenSharingCapability(response => {
        if(!response.supported || response.extensionRegistered === false){
          alert("Screen sharing not supported");
        }else if(response.extensionInstalled === false){
          alert("Browser requires extension");
        }else{

          // publisher.destroy();

          $('#video_chat_modal #publisher').removeClass("w-100 h-100").addClass("small");

          // $('#video_chat_modal .col-md-6:first').html("<div id='publisher' class='w-100 h-100 border'></div>");

          $('#video_chat_modal #publisher-screen').removeClass("d-none");

          screenSharePublisher = OT.initPublisher("publisher-screen",{
            insertMode: "append",
            width: "100%",
            height: "100%",
            videoSource: "screen",
            publishAudio: true
          },handleError);

          session.publish(screenSharePublisher,handleError);
          
          $('.start-screen-share').addClass("d-none");
          $('.stop-screen-share').removeClass("d-none");

          console.log("screen sharing started.");

        }

      });

    // }

  });

  $(document).on("click", ".stop-screen-share", function(){

    screenSharePublisher.destroy();

    $('.start-screen-share').removeClass("d-none");
    $('.stop-screen-share').addClass("d-none");

    $('#video_chat_modal #publisher').addClass("w-100 h-100").removeClass("small");
    $('#video_chat_modal #publisher-screen').addClass("d-none");

    // $('#video_chat_modal .col-md-6:first').html("<div id='publisher' class='w-100 h-100 border'></div>");

    // Create a publisher
    // publisher = OT.initPublisher('publisher', {
    //   insertMode: 'replace',
    //   width: '100%',
    //   height: '100%'
    // }, handleError);

    // session.publish(publisher, handleError);

    console.log("screen sharing stopped.");

  });

}