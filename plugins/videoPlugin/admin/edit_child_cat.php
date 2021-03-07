<?php 
  function escape($value){
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
  }

  $video = escape($row_edit->video);

  $editParentCat = $db->select("categories",array('cat_id'=>$child_parent_id));
  $rowParentCat = $editParentCat->fetch();
  $parentvideo = $rowParentCat->video;
  if($parentvideo == 1 and $video!='0'){
    $video = 1;
  }
?>
<div class="form-group row"><!--- form-group row Starts --->
  <label class="col-md-4 control-label">Enable Video Tutorials For This Sub Category : </label>
  <div class="col-md-6">
  	<input type="checkbox" name="video" value="1" <?php if($video == 1){echo "checked";} ?>> <label> Yes </label>
  </div>
</div><!--- form-group row Ends --->