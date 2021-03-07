<?php

	function checkVideo($cat_id,$child_id){
	  global $db;
	  $cat = $db->select("categories",array('cat_id'=>$cat_id))->fetch();
	  $catVideo = $cat->video;
	  $child = $db->select("categories_children",array("child_id"=>$child_id))->fetch();
	  $childVideo = $child->video;
	  // if category video enabled and subcategory video not disabled or category video disabled and subcategory video enabled
	  if(($catVideo == 1 and $childVideo!='0') or ($catVideo == 0 and $childVideo=='1')){
	    return true;
	  }else{
	    // if category video disabled or subcategory video disabled
	    return false;
	  }
	}
