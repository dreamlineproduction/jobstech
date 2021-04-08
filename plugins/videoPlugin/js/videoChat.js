var base_url = $("#videoChatModalJs").data("base-url");
var order_id = $("#videoChatModalJs").data("order-id");
var proposal_id = $("#videoChatModalJs").data("proposal-id");
var id = $("#videoChatModalJs").data("id");
var call_number = $("#videoChatModalJs").data("call-number");
var name = $("#videoChatModalJs").data("name");
var login_seller_id = $("#videoChatModalJs").data("login-seller-id");
var seller_id = $("#videoChatModalJs").data("seller-id");
var buyer_id = $("#videoChatModalJs").data("buyer-id");
var call_number = $("#videoChatModalJs").data("call-number");
var order_minutes = $("#videoChatModalJs").data("order-minutes");

$(document).ready(function(){

	initializeSession($("#sessionId").val(),$("#token").val());

	/// Archiving Code
	$('.stop-archive').hide();
	$('.download-archive').hide();

	$('.start-archive').click(function(){
		$('#wait').addClass("loader");
		$.ajax({
			method: "POST",
			url: base_url+"/plugins/videoPlugin/ajax/start-archive",
			data: { sessionId: call_number },
			success: function(data) {
				$('#wait').removeClass("loader");
			}
		});
	});

	$('.stop-archive').click(function() {
		$('#wait').addClass("loader");
		$.ajax({
			method: "POST",
			url: base_url+"/plugins/videoPlugin/ajax/stop-archive",
			data: { archiveId: archiveID },
			success: function(data) {
				$('#wait').removeClass("loader");
				$(this).hide();
			}
		});
	});

	$('.download-archive').click(function() {
		$('#wait').addClass("loader");
		$.ajax({
			 method: "POST",
			 url: base_url+"/plugins/videoPlugin/ajax/download-archive",
			 data: { archiveId: archiveID },
			 success: function(data) {
				$('#wait').removeClass("loader");
				window.open(data,'_blank');
			 }
		});
	});

	$('.open-messages').click(function(){
		$('#wait').addClass("loader");
		$.ajax({
			method: "POST",
			url: base_url+"/plugins/videoPlugin/chat/chat_modal",
			data: { call_id : id },
			success: function(data) {
				$('.chat-modal').html(data);
				$('#wait').removeClass("loader");
			}
		});
	});

	setInterval(function(){
	 $.ajax({
	   method: "POST",
	   url: base_url+"/plugins/videoPlugin/ajax/count_messages",
	   data: {call_id: id}
	 }).done(function(data){
	 	if(data > 0){
	 		$(".count-messages").removeClass("d-none");
	   	$(".count-messages").html(data);
	   }else{
	   	$(".count-messages").addClass("d-none");
	   	$(".count-messages").html("");
	   }
	 });
	},2000);

});

/*
myInterval = setInterval(function(){
	$.ajax({
		url:base_url+"/plugins/videoPlugin/ajax/view-call-status",
		type:"POST",
		data:{call_number: call_number },
	}).done(function(data){
		data = $.parseJSON(data);
		if(data.status == "declined"){
			clearInterval(myInterval);
			$("#subscriber").addClass("bg-dark");
			$("subscriber-stream,#subscriber-ringing,#subscriber-ended").addClass("d-none");
			$("#subscriber-declined").removeClass("d-none");
		}

		if(order_minutes != "0:00" & buyer_id == login_seller_id){	
			if(data.order_minutes == "0:00"){
			  clearInterval(myInterval);
			  if(confirm("Owh! Looks like your purchased time for this video session just finished.")){
		 	  	window.open('order_details?order_id='+order_id,'_self');
		 	  }
		  }
	  }

	  if(seller_id == login_seller_id & order_minutes != "0:00"){
		if(data.order_minutes == "0:00"){
			clearInterval(myInterval);
			if(confirm(""+name+"’s Purchased time for this video session has completed. You can proceed by calling "+name+" and video call will start again, otherwise you can extend the order time.")){
				window.open('order_details?order_id='+order_id,'_self');
			}else{
				var call_number = $("#sessionId").val();
		      $.ajax({
		        method: "POST",
		        url: base_url+"/plugins/videoPlugin/ajax/end-call",
		        data: {call_number: call_number},
		        success: function(data){
		        	if(data == "ok"){ 
		 	  			window.open('order_details?order_id='+order_id,'_self');
		         }
		        }
		   	});
		  }
		}
	  }

	});
},5000);*/
