<?php

  $cat = $db->select("categories",array('cat_id'=>$cat_id))->fetch();
  $catVideo = $cat->video;

  $child = $db->select("categories_children",array("child_id"=>$child_id))->fetch();
  $childVideo = $child->video;
  
  // if category video enabled and subcategory video not disabled or category video disabled and subcategory video enabled
  
  if(($catVideo == 1 and $childVideo!='0') or ($catVideo == 0 and $childVideo=='1')){
    $db->insert("proposal_videosettings",array("proposal_id"=>$proposal_id,"enable"=>1)); 
    $redirect = "video";
  }else{
    // if category video disabled or subcategory video disabled
    $db->insert("proposal_videosettings",array("proposal_id"=>$proposal_id,"enable"=>0));  
    $redirect = "instant_delivery";
  }