$(document).ready(function(){

  var base_url = $("#chatModalJs").data("base-url");
  var call_id = $("#chatModalJs").data("call-id");
  var login_seller_id = $("#chatModalJs").data("login-seller-id");
  var seller_id = $("#chatModalJs").data("seller-id");
  var seller_user_name = $("#chatModalJs").data("seller-username");

  $('#insert-message textarea').emojioneArea({
    events: {
      keydown: function (editor, event) {

        var status = "typing";
        $.ajax({
          method: 'POST',
          url: base_url+"/plugins/videoPlugin/ajax/typeStatus",
          data: {seller_id: login_seller_id, call_id:call_id, status: status}
        });

        if(event.keyCode == 13){
          event.preventDefault();
          sendMessage();
        }

      },
      keyup: function (editor, event){
        // typeStatus
        var status = "untyping";
        setTimeout(function(){
          $.ajax({
            method: 'POST',
            url: base_url+"/plugins/videoPlugin/ajax/typeStatus",
            data: {seller_id: login_seller_id, call_id:call_id, status: status}
          });
        }, 2000);
      }
    }

  });

  const uploadButton = document.querySelector('.attach');
  const realInput = document.getElementById('m-file');

  uploadButton.addEventListener('click', (e) => {
    realInput.click();
  });

   $("#m-file").change(function (){
      $(".emojionearea.form-control").css({minWidth:'220px'});
      $(".attach").html("Change File");   
   }); 

  var chatInterval = setInterval(function(){
    $.ajax({
      method: "POST",
      url: base_url+"/plugins/videoPlugin/chat/chat_messages",
      data: {call_id: call_id}
    }).done(function(data){
      $(".message-list-box").empty();
      $(".message-list-box").append(data);
    });
  },2000);

  var typingInterval = setInterval(function(){
    $.ajax({
      method: "POST",
      url: base_url+"/plugins/videoPlugin/ajax/chat_typing_status",
      data: {seller_id : seller_id, call_id: call_id}
    }).done(function(data){
      if(data == "typing"){
        $(".typing-status").removeClass("d-none");
        $('.typing-status').html("<b class='text-success'>"+seller_user_name+"</b> is typing ...");
      }else{
        $(".typing-status").addClass("d-none");
        $('.typing-status').html("Dummy Text");
      }

    });
  }, 500);

  $('.anticon').click(function(){
    clearInterval(chatInterval);
    clearInterval(typingInterval);
    $(".left-panel").html("");
    $(".left-panel").addClass("d-none");
  });


  function sendMessage(){
    var form_data = new FormData($('#insert-message')[0]);
    form_data.append('call_id',call_id);
    $("#insert-message button[type='submit']").html("<i class='fa fa-spinner fa-pulse fa-lg fa-fw'></i>");
    $("#insert-message button[type='submit']").prop("disabled", true);
    message = $('.emojionearea-editor').html();
    form_data.append('message',message);
    if(message == ""){
      alert('Message can\'t be empty!');
      $("#insert-message button[type='submit']").prop("disabled", false);
      $("#insert-message button[type='submit']").html("Send");
    }else{
      $.ajax({
        method: "POST",
        url: base_url+"/plugins/videoPlugin/ajax/insert_chat_message",
        data : form_data,
        cache: false,contentType: false,processData: false
      }).done(function(data){
        $('#chat_data_div').html(data);  
        $("#insert-message button[type='submit']").html("Send");
        $("#insert-message button[type='submit']").prop("disabled", false);
        $(".emojionearea-editor").html("");
        $("#insert-message").trigger("reset");
      });
    }
  }

  $('#insert-message').submit(function(e){
    e.preventDefault();
    sendMessage();
  });

});