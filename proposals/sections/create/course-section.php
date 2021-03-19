<?php

$form_errors = Flash::render("form_errors");
$form_data = Flash::render("form_data");
if (empty($form_data)) {
    $form_data = $input->post();
}
?>


<section class="signup-step-container">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-9">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Basic</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Requirements</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>Outcomes</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i>Pricing</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab"><span class="round-tab">5</span> <i>Media</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab"><span class="round-tab">6</span> <i>Curriculum</i></a>
                                </li>
                            </ul>
                        </div>
        
                        <form role="form" action="index.html" class="login-box">
                            <div class="tab-content" id="main_form">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <h4 class="text-center">Course Details</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Course title  *</label> 
                                                <input class="form-control" type="text" name="name" placeholder=""> 
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Short description  *</label> 
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> 
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description *</label> 
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea> 
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                        <select name="proposal_cat_id" id="category" class="form-control mb-3"  required="">
<option value="" class="hidden"> Select A Category </option>
<?php
$get_cats = $db->select("categories");
while ($row_cats = $get_cats->fetch()) {

    $cat_id = $row_cats->cat_id;
    $get_meta = $db->select("cats_meta", [
        "cat_id" => $cat_id,
        "language_id" => $siteLanguage,
    ]);
    $cat_title = $get_meta->fetch()->cat_title;
    ?>
<option <?php if (@$form_data["proposal_cat_id"] == $cat_id) {
    echo "selected";
} ?> value="<?= $cat_id ?>"> <?= $cat_title ?> </option>
<?php
}
?>
</select>
<small class="form-text text-danger"><?= ucfirst(
    @$form_errors["proposal_cat_id"]
) ?></small>
<select name="proposal_child_id" id="sub-category" class="form-control" required="">
<option value="" class="hidden"> Select A Sub Category </option>
<?php if (@$form_data["proposal_child_id"]) { ?>
<?php
$get_c_cats = $db->select("categories_children", [
    "child_parent_id" => $form_data["proposal_cat_id"],
]);
while ($row_c_cats = $get_c_cats->fetch()) {
    $child_id = $row_c_cats->child_id;
    $get_meta = $db->select("child_cats_meta", [
        "child_id" => $child_id,
        "language_id" => $siteLanguage,
    ]);
    $row_meta = $get_meta->fetch();
    $child_title = $row_meta->child_title;
    echo "<option " .
        ($form_data["proposal_cat_id"] == $child_id ? "selected" : "") .
        " value='$child_id'> $child_title </option>";
}
?>
<?php } ?>
</select>
                                        </div>


                                <div class="col-md-12">
                                <div class="form-group">
                                  <label for="Level">Level</label>
                                  <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Beginner</option>
                                    <option>Advanced</option>
                                    <option>Intermediate</option>
                                
                                  </select>
                                </div>
                                </div>

                                <div class="col-md-12">
                                <div class="form-group">
                                  <label for="language-made">Language made in</label>
                                  <select class="form-control" id="exampleFormControlSelect1">
                                  <?php include "sections/create/course-languages.php"; ?>
                                  
                                  </select>
                                </div>
                                </div>
                                        
                                        
                                        
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <h4 class="text-center">Requirements</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 1</label>
                                    <input type="text" class="form-control" id="Requirements1"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 2</label>
                                    <input type="text" class="form-control" id="Requirements2"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 3</label>
                                    <input type="text" class="form-control" id="Requirements3"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 4</label>
                                    <input type="text" class="form-control" id="Requirements4"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 5</label>
                                    <input type="text" class="form-control" id="Requirements5"  placeholder="Provide requirements">
                                        </div>
                                    </div>
 
                                   </div>
                                    
                                    
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <h4 class="text-center">Outcomes</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label for="Outcomes">Outcomes 1</label>
                                    <input type="text" class="form-control" id="Outcomes1"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes2">Outcomes 2</label>
                                    <input type="text" class="form-control" id="Outcomes2"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes3">Outcomes 3</label>
                                    <input type="text" class="form-control" id="Outcomes3"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes4">Outcomes 4</label>
                                    <input type="text" class="form-control" id="Outcomes4"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes5">Outcomes 5</label>
                                    <input type="text" class="form-control" id="Outcomes5"  placeholder="Provide Outcome">
                                        </div>
                                    </div>
 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step4">
                                    <h4 class="text-center">Pricing</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                                <label>Course price ($)  *</label> 
                                                <input class="form-control" type="number" name="name" placeholder="Enter course course price"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Discounted price ($) <small>Leave 0 if no discount avalaible</small></label> 
                                                <input class="form-control" type="number" name="name" placeholder="Enter discounted price"> 
                                            </div>
                                        
                                      
                                      
                                    </div>
 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>

                                <div class="tab-pane" role="tabpanel" id="step5">
                                    <h4 class="text-center">Course Overview</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
    <label for="course-provider-source">Course overview provider</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>Youtube</option>
      <option>Vimeo</option>
      <option>Upload from your system</option>
    
    </select>
  </div>
                                            <div class="form-group">
                                                <label>Course preview video url</label> 
                <input class="form-control" type="text" name="video-url" placeholder="Enter video url" value="https://www.youtube.com/watch?v=TXzLvYN-HSc"> 
                                            </div>

                                            <div class="form-group imgUp">
                                                <label>Course Thumbnail</label> 
                                                <div class="imagePreview"></div>
<label class="btn btn-primary">
										    			Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
				</label>
                                            </div>
                                        
                                      
                                      
                                    </div>
 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>




                                <div class="tab-pane" role="tabpanel" id="step6">
                                    <h4 class="text-center">Curriculum</h4>
                                    <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 text-right">
                                    
                                           

                                    <a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#add_section"> <i class="fa fa-plus" aria-hidden="true"></i> Add Chapter</a>
                                    <a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#add_lesson"> <i class="fa fa-plus" aria-hidden="true"></i> Add lesson</a>
                                        
                                      
                                      
                                    </div>

                                    <div class="col-md-12 mt-4 mb-5">
                                    
                                           

                                    <div class="card created-lessons mt-4">
                        <div class="card-body">
                            <h6 class="">Chapter 1: <strong>Demo Chapter</strong></h6>
                            <div class="edit-chapter-title">
                            <div class="dropdown chapter-dropdown">
 
  <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
 
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Edit</a>
    <a class="dropdown-item" href="#">Delete</a>
    
  </div>
</div>
                                
                                </div>
                            <div class="single-lesson-display mt-4">
                                <div class="row">
<div class="col-md-11">
<h6 class="d-inline"><span class="font-weight-light">Lesson 1 :</span> ACCA FA1 Recording Financial Transactions</h6>
</div>

<div class="col-md-1">
<div class="dropdown chapter-dropdown">
 
 <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   <a class="dropdown-item" href="#">Edit</a>
   <a class="dropdown-item" href="#">Delete</a>
   
 </div>
</div>

</div>

                                </div>
                                
                               
                            </div>
                            <div class="single-lesson-display mt-4">
                            <div class="row">
<div class="col-md-11">
<h6 class="d-inline"><span class="font-weight-light">Lesson 2 :</span> ACCA FA1 Recording Financial Transactions</h6>
</div>

<div class="col-md-1">
<div class="dropdown chapter-dropdown">
 
 <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   <a class="dropdown-item" href="#">Edit</a>
   <a class="dropdown-item" href="#">Delete</a>
   
 </div>
</div>

</div>

                                </div>
                            </div>
                            <div class="single-lesson-display mt-4">
                            <div class="row">
<div class="col-md-11">
<h6 class="d-inline"><span class="font-weight-light">Lesson 3 :</span> ACCA FA1 Recording Financial Transactions</h6>
</div>

<div class="col-md-1">
<div class="dropdown chapter-dropdown">
 
 <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   <a class="dropdown-item" href="#">Edit</a>
   <a class="dropdown-item" href="#">Delete</a>
   
 </div>
</div>

</div>

                                </div>
                            </div>
                            
                            </div>
                            </div>

                            <div class="card created-lessons mt-4">
                        <div class="card-body">
                            <h6 class="">Chapter 1: <strong>Demo Chapter</strong></h6>
                            <div class="edit-chapter-title">
                            <div class="dropdown chapter-dropdown">
 
  <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
 
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Edit</a>
    <a class="dropdown-item" href="#">Delete</a>
    
  </div>
</div>
                                
                                </div>
                            <div class="single-lesson-display mt-4">
                                <div class="row">
<div class="col-md-11">
<h6 class="d-inline"><span class="font-weight-light">Lesson 1 :</span> ACCA FA1 Recording Financial Transactions</h6>
</div>

<div class="col-md-1">
<div class="dropdown chapter-dropdown">
 
 <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   <a class="dropdown-item" href="#">Edit</a>
   <a class="dropdown-item" href="#">Delete</a>
   
 </div>
</div>

</div>

                                </div>
                                
                               
                            </div>
                            <div class="single-lesson-display mt-4">
                            <div class="row">
<div class="col-md-11">
<h6 class="d-inline"><span class="font-weight-light">Lesson 2 :</span> ACCA FA1 Recording Financial Transactions</h6>
</div>

<div class="col-md-1">
<div class="dropdown chapter-dropdown">
 
 <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   <a class="dropdown-item" href="#">Edit</a>
   <a class="dropdown-item" href="#">Delete</a>
   
 </div>
</div>

</div>

                                </div>
                            </div>
                            <div class="single-lesson-display mt-4">
                            <div class="row">
<div class="col-md-11">
<h6 class="d-inline"><span class="font-weight-light">Lesson 3 :</span> ACCA FA1 Recording Financial Transactions</h6>
</div>

<div class="col-md-1">
<div class="dropdown chapter-dropdown">
 
 <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   <a class="dropdown-item" href="#">Edit</a>
   <a class="dropdown-item" href="#">Delete</a>
   
 </div>
</div>

</div>

                                </div>
                            </div>
                            
                            </div>
                            </div>
                                        
                                      
                                      
                                    </div>




 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        
                                        <li><button type="button" class="btn btn-success next-step">Finish</button></li>
                                    </ul>
                                </div>


                                <div class="clearfix"></div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include "sections/create/modals-courses.php"; ?>


    <script>
    // ------------step-wizard-------------
$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var target = $(e.target);
    
        if (target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        nextTab(active);

    });
    $(".prev-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}


$('.nav-tabs').on('click', 'li', function() {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
});

$(".imgAdd").click(function(){
  $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
});
$(document).on("click", "i.del" , function() {
	$(this).parent().remove();
});
$(function() {
    $(document).on("change",".uploadFile", function()
    {
    		var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
      
    });
});



    
    </script>