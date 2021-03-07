$(document).ready(function(){
  $("#video").click(function(){
    if(this.checked){
      $("#videoSettings").removeClass("d-none");  // checked
      $("#videoSettings input*").attr("required","required");
      $("#videoSettings input*").attr("min","1");
    }else{
      $("#videoSettings").addClass("d-none");  // unchecked
      $("#videoSettings input*").removeAttr("required");
      $("#videoSettings input*").removeAttr("min");
    }
  });
});