<form action="" method="post"><!--- form Starts --->
   
   <input type="hidden" name="file_name" value="dusupay_order_completed.php">

   <div class="form-group">
      <textarea name="content" class="form-control" id="duspay_order_completed" name="code" rows="45"><?= get_file("dusupay_order_completed.php"); ?></textarea>
   </div>

   <div class="form-group mb-0">
      <a href="#" class="btn btn-success float-left preview-email">
         <i class="fa fa-eye"></i> Preview
      </a>
      <button type="submit" name="update" class="btn btn-success float-right"> 
         <i class="fa fa-floppy-o"></i> Save Changes
      </button> 
   </div>

</form><!--- form Ends --->
<script>
  var editor = CodeMirror.fromTextArea(document.getElementById("duspay_order_completed"), {
   lineNumbers: true,
   styleActiveLine: true,
   theme : "dracula",
	mode : "shell",
	styleSelectedText : true,
	matchBrackets : true,
	styleActiveLine : true,
	lineWrapping : true,
	nonEmpty : true,
   matchBrackets: true
  
  });
 
</script>