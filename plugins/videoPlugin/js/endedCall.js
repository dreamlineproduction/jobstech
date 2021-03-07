$(document).ready(function(){
	var base_url = $("#endedCallJs").data("base-url");
	audio_play.pause();
	$('#ended_call_modal').modal({ backdrop: 'static', show: true });
	$(".close-button").click(function(){
		$('#ended_call_modal').modal('hide');
		$("#incoming-call").html("");
		$(".modal-backdrop.fade.show").remove();
		$.getScript(base_url+"/plugins/videoPlugin/js/script.js");
	});
});