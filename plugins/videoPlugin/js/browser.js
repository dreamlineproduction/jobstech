var browsers = ["Opera", "Edge", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
var userbrowser, useragent = navigator.userAgent;

for(var i = 0; i < browsers.length; i++){
  if(useragent.indexOf(browsers[i]) > -1 ){
    userbrowser = browsers[i];
    break;
  }
};

$(document).on("click", ".call-button", function(){
  if(userbrowser == "MSIE" || userbrowser == "Trident" || userbrowser == "Edge"){
    swal({
      type: 'info',
      text: 'your browser is not supported for video call features please use google chrome.',
      timer: 2000,
      onOpen: function(){
        swal.showLoading();
      }
    });
  }
});