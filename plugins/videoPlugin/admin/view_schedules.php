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
        <h1><i class="menu-icon fa fa-clock-o"></i> Video Schedules </h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li class="active"><a href="index?insert_schedule" class="btn btn-success">
            <i class="fa fa-plus-circle text-white"></i> <span class="text-white">Add Video Schedule</span>
            </a>
          </li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <!--- 2 row Starts --->
    <div class="col-lg-12">
      <!--- col-lg-12 Starts --->
      <div class="card">
        <!--- card Starts --->
        <div class="card-header">
          <!--- card-header Starts --->
          <h4 class="h4">
            <i class="fa fa-money-bill-alt"></i> View All Video Schedules
          </h4>
        </div>
        <!--- card-header Ends --->
        <div class="card-body">
          <!--- card-body Starts --->
          <table class="table table-bordered">
            <!--- table table-bordered table-hover Starts --->
            <thead>
              <tr>
                <th>Title</th>
                <th>Duration <span class="small text-lead">(in days)</span></th>
                <th width="200px">Action</th>
              </tr>
            </thead>
            <tbody>
              <!--- tbody Starts --->
              <?php
                $get_schedules = $db->select("video_schedules");
                while($schedule = $get_schedules->fetch()){
                $id = $schedule->id;
                $title = $schedule->title;
                $duration = $schedule->duration;
              ?>
              <tr>
                <td><?php echo $title; ?></td>
                <td><?php echo $duration; ?></td>
                <td>
                  <a href="index?delete_schedule=<?php echo $id; ?>" onclick="return confirm('You are about to delete this category, do you wish to proceed ?');" class="btn btn-danger">
                  <i class="fa fa-trash text-white"></i> <span class="text-white">Delete</span>
                  </a>
                  <a href="index?edit_schedule=<?php echo $id; ?>" class="btn btn-success">
                  <i class="fa fa-trash text-white"></i> <span class="text-white">Edit</span>
                  </a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
            <!--- tbody Ends --->
          </table>
          <!--- table table-bordered table-hover Ends --->
        </div>
        <!--- card-body Ends --->
      </div>
      <!--- card Ends --->
    </div>
    <!--- col-lg-12 Ends --->
  </div>
  <!--- 2 row Ends --->
</div>
<?php } ?>