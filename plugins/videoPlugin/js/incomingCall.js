$(document).ready(function(){

  	var base_url = $("#incomingJs").data("base-url");

	audio_play = new Audio(base_url+"/images/sound.mp3");
	audio_play.loop = true;
	audio_play.play();

	$('#video_chat_accept').modal({ backdrop: 'static', show: true });

	data = {};
	data["order_id"] =  $("#incomingJs").data("order_id");
	data["sender_id"] = $("#incomingJs").data("sender_id");
	data["receiver_id"] = $("#incomingJs").data("receiver_id");
	data["warning_message"] = $("#incomingJs").data("warning_message");

	$("#accept-call-button").click(function(){
		audio_play.pause();
		$('#wait').addClass("loader");
		$.ajax({
			method: "POST",
			url: base_url+"/plugins/videoPlugin/ajax/video-chat-modal",
			data:{data},
			success:function(video_chat_modal){
				$.ajax({
				url:base_url+"/plugins/videoPlugin/ajax/accept-call",
				type:"POST",
				data:{data},
				success:function(data){
					if(data === "ok"){
						$('#wait').removeClass("loader");
						$('#video_chat_accept').modal('hide');
						$("#incoming-call").html("");
						$("#video-chat-modal").html(video_chat_modal);
						// (optional) add server code here
						initializeSession($("#sessionId").val(),$("#token").val());
					}
				}
				});
			}
		});
	});

	$("#decline-call").click(function(){
		audio_play.pause();
		data["call_number"] = $("#sessionId").val();
		data["call_token"] = $("#token").val();
		$('#wait').addClass("loader");
		$.ajax({
			method: "POST",
			url: base_url+"/plugins/videoPlugin/ajax/decline-call",
			data:{data},
			success:function(data){
				if(data === "ok"){
					$('#video_chat_accept').modal('hide');
					$('#wait').removeClass("loader");
					$.getScript(base_url+"/plugins/videoPlugin/js/script.js");
					$("#incoming-call").html("");
					$(".modal-backdrop.fade.show").remove();
				}
			}
		});
	});
	
});