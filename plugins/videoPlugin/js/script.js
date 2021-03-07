$(document).ready(function(){
	
	var base_url = $("#custom-js").data("base-url");

	var stopInterval = function(intervalId, callback){
		clearInterval(intervalId);
		callback();
	}

	var incoming_call = function(){
		$.ajax({
		type:"POST",
		url: base_url+"/plugins/videoPlugin/ajax/incoming-call"
		}).done(function(data){
			if(data !== "failed"){
				$("#incoming-call").html(data);
			}else{
				setTimeout(incoming_call, 4000);
			}
		});
	}
	incoming_call();

	var ended_call = function(){
		$.ajax({
		type:"POST",
		url: base_url+"/plugins/videoPlugin/ajax/ended-call",
		}).done(function(data){
			if(data !== "failed") {
				$("#incoming-call").html(data);
			}else{
			  setTimeout(ended_call, 4000);
			}
		});
	}
	ended_call();
});