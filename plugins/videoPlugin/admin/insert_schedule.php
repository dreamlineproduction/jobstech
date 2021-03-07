<?php
@session_start();
if(!isset($_SESSION['admin_email'])){
  echo "<script>window.open('login','_self');</script>";
}else{

?>
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1><i class="menu-icon fa fa-clock-o"></i> Insert Video Schedule</h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li class="active">Insert Video Schedule</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="container">
<div class="row"><!--- 2 row Starts --->
  <div class="col-lg-12"><!--- col-lg-12 Starts --->
  <?php 
  $form_errors = Flash::render("form_errors");
  $form_data = Flash::render("form_data");
  if(is_array($form_errors)){
  ?>
  <div class="alert alert-danger"><!--- alert alert-danger Starts --->
  <ul class="list-unstyled mb-0">
  <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
  <li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
  <?php } ?>
  </ul>
  </div><!--- alert alert-danger Ends --->
  <?php } ?>
    <div class="card"><!--- card Starts --->
      <div class="card-header"><!--- card-header Starts --->
        <h4 class="h4">Insert Video Schedule</h4>
      </div><!--- card-header Ends --->
      <div class="card-body"><!--- card-body Starts --->
        <form action="" method="post" enctype="multipart/form-data"><!--- form Starts --->
          <div class="form-group row"><!--- form-group row Starts --->
            <label class="col-md-4 control-label"> Schedule Title : </label>
            <div class="col-md-6">
              <input type="text" name="title" class="form-control" required="">
            </div>
          </div><!--- form-group row Ends --->
          <div class="form-group row"><!--- form-group row Starts --->
            <label class="col-md-4 control-label"> Schedule Duration <span class="small text-lead">(in days)</span> : </label>
            <div class="col-md-6">
              <input type="number" name="duration" class="form-control" required="">
            </div>
          </div><!--- form-group row Ends --->
          <div class="form-group row"><!--- form-group row Starts --->
            <label class="col-md-4 control-label"></label>
            <div class="col-md-6">
              <input type="submit" value="Insert Schedule" class="btn btn-success form-control">
            </div>
          </div><!--- form-group row Ends --->
        </form><!--- form Ends --->
      </div><!--- card-body Ends --->
    </div><!--- card Ends --->
  </div><!--- col-lg-12 Ends --->
</div><!--- 2 row Ends --->
<?php
if(isset($_POST['title']) and isset($_POST['duration'])){
  $rules = array("title" => "required","duration" => "required");
  $messages = array("title" => "Video Schedule Title Is Required.");
  $val = new Validator($_POST,$rules,$messages);
  if($val->run() == false){
    Flash::add("form_errors",$val->get_all_errors());
    Flash::add("form_data",$_POST);
    echo "<script> window.open('index?insert_schedule','_self');</script>";
  }else{
    $data = $input->post();
    $insert_schedule = $db->insert("video_schedules",$data);
    if($insert_schedule){
      successRedirect("Video Schedule Inserted successfully.","index?view_schedules");
    }
  }
}
?>
</div>
<?php } ?>