<?php
  function escape($value){
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
  }
  $opentok_api_key = escape($row_general_settings->opentok_api_key);
  $opentok_api_secret = escape($row_general_settings->opentok_api_secret);
?>
<div class="row"><!--- 1 row Starts --->
	<div class="col-lg-12"><!--- col-lg-12 Starts --->
    <?php
    $form_errors = Flash::render("opentok_errors");
    if(is_array($form_errors)){
    ?>
    <div class="alert alert-danger"><!--- alert alert-danger Starts --->
      <ul class="list-unstyled mb-0">
        <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
          <li class="list-unstyled-item"><?= escape($i); ?>. <?= escape(ucfirst($error)); ?></li>
        <?php } ?>
      </ul>
    </div><!--- alert alert-danger Ends --->
    <?php } ?>
		<div class="card mb-5"><!--- card mb-5 Starts --->
			<div class="card-header"><!--- card-header Starts --->
				<h4 class="h4"><i class="fa fa-video-camera"></i> Video Chat Settings </h4>
			</div><!--- card-header Ends --->
			<div class="card-body"><!--- card-body Starts --->
			  <form method="post" enctype="multipart/form-data"><!--- form Starts --->

			    <div class="form-group row"><!--- form-group row Starts --->
			    <label class="col-md-3 control-label"> Vonage Api Key : </label>
			    <div class="col-md-6">
			      <input type="text" name="opentok_api_key" class="form-control" value="<?= $opentok_api_key; ?>" required=""/>
			    </div>
			    </div><!--- form-group row Ends --->

			    <div class="form-group row"><!--- form-group row Starts --->
			    <label class="col-md-3 control-label"> Vonage Api Secret : </label>
			    <div class="col-md-6">
			      <input type="text" name="opentok_api_secret" class="form-control" value="<?= $opentok_api_secret; ?>" required=""/>
			    </div>
			    </div><!--- form-group row Ends --->

			    <div class="form-group row"><!--- form-group row Starts --->
			    <label class="col-md-3 control-label"></label>
			    <div class="col-md-6">
			      <input type="submit" name="video_settings_update" class="form-control btn btn-success" value="Update Video Chat Settings">
			    </div>
			    </div><!--- form-group row Ends --->

			  </form><!--- form Ends --->
			</div><!--- card-body Ends --->
		</div><!--- card mb-5 Ends --->
	</div><!--- col-lg-12 Ends --->
</div><!--- 1 row Starts --->

<?php

// $get_sellers = $db->query("select * from sellers WHERE NOT EXISTS (SELECT * FROM seller_settings WHERE sellers.seller_id = seller_settings.seller_id)");
// while($row_sellers = $get_sellers->fetch()){
// 	$seller_id = $row_sellers->seller_id;
// 	$db->insert("seller_settings",array("seller_id"=>$seller_id));
// }

if(isset($_POST['video_settings_update'])){
  // validating the video chat settings
  $rules = array(
    "opentok_api_key" => "required",
    "opentok_api_secret" => "required",
  );
  $val = new Validator($_POST,$rules);
  if($val->run() == false){
    Flash::add("opentok_errors",$val->get_all_errors());
    redirect("index?general_settings");
  }else{

	  $data = $input->post();
	  unset($data['video_settings_update']);
	  
	  $update_general_settings = $db->update("general_settings",$data);
	  if($update_general_settings){

		 $get_proposals = $db->query("select * from proposals WHERE NOT EXISTS (SELECT * FROM proposal_videosettings WHERE proposals.proposal_id = proposal_videosettings.proposal_id)");
		 while($row_proposals = $get_proposals->fetch()){
			$proposal_id =$row_proposals->proposal_id;
		   $db->insert("proposal_videosettings",array("proposal_id"=>$proposal_id,"enable"=>0));  
		 }

	    $insert_log = $db->insert_log($admin_id,"video_chat_settings","","updated");
	    successRedirect("Video Chat Settings has been updated successfully","index?api_settings");
	  
	  }
  }
}
?>