<?php
$form_errors = Flash::render("form_errors");
$form_data = Flash::render("form_data");
if (empty($form_data)) {
    $form_data = $input->post();
}
?>

<style type="text/css">    
    .tab-pane{
        display: none;
    }

    .tab-pane.active{
        display: block;
    }

    .error{
        color: #f44336;
    }
</style>


<section class="signup-step-container">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-9">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" class="disabled" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Basic</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step2" class="disabled" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Requirements</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" class="disabled" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>Outcomes</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" class="disabled" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i>Pricing</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step5" class="disabled" data-toggle="tab" aria-controls="step5" role="tab"><span class="round-tab">5</span> <i>Media</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step6" class="disabled" data-toggle="tab" aria-controls="step6" role="tab"><span class="round-tab">6</span> <i>Curriculum</i></a>
                                </li>
                            </ul>
                        </div>
        
                            <div class="tab-content" id="main_form">                                
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <form role="form" action="" class="login-box" name="create_course_form" id="create_course_form">
                                        <h4 class="text-center">Course Details</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course title *</label> 
                                                    <input class="form-control" type="text" name="course_title" id="course_title" placeholder="Title" value="<?php echo (!empty($_SESSION['course_details']['general_details']['course_title']) ? $_SESSION['course_details']['general_details']['course_title'] : '');?>"> 
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Short description *</label> 
                                                    <textarea class="form-control" id="short_descrption" name="short_descrption" rows="3" placeholder="Short Description"><?php echo (!empty($_SESSION['course_details']['general_details']['short_descrption']) ? $_SESSION['course_details']['general_details']['short_descrption'] : '');?></textarea> 
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description *</label> 
                                                    <textarea class="form-control" id="description" name="description" rows="8"><?php echo (!empty($_SESSION['course_details']['general_details']['description']) ? $_SESSION['course_details']['general_details']['description'] : '');?></textarea> 
                                                </div>
                                            </div>                                        
                                            <div class="col-md-12">
                                                <select name="cat_id" id="cat_id" class="form-control mb-3"  >
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
                                                        <!-- <option <?php //if (@$form_data["proposal_cat_id"] == $cat_id) {
                                                            echo "selected";
                                                        //} ?> value="<?//= $cat_id ?>"> <?//= $cat_title ?> </option> -->


                                                        <option <?php if (@$_SESSION['course_details']['general_details']['cat_id'] == $cat_id) {
                                                            echo "selected";
                                                        } ?> value="<?= $cat_id ?>"> <?= $cat_title ?> </option>

                                                        
                                                        <?php
                                                        }
                                                        ?>
                                                </select>
                                                <small class="form-text text-danger"><?= ucfirst(@$form_errors["proposal_cat_id"]) ?></small>

                                                <select  id="sub_category" name="sub_category" class="form-control" >
                                                    <option value="" class="hidden"> Select A Sub Category </option>
                                                    <?php if (@$_SESSION['course_details']['general_details']['cat_id']) { ?>
                                                        <option value="" class="hidden"> Select A Sub Category </option>
                                                    <?php
                                                        $get_c_cats = $db->select("categories_children", [
                                                            "child_parent_id" => $_SESSION['course_details']['general_details']['cat_id'],
                                                        ]);
                                                        while ($row_c_cats = $get_c_cats->fetch()) {
                                                            $child_id = $row_c_cats->child_id;
                                                            $get_meta = $db->select("child_cats_meta", [
                                                                            "child_id" => $child_id,
                                                                            "language_id" => $siteLanguage,
                                                                        ]);
                                                            $row_meta = $get_meta->fetch();
                                                            $child_title = $row_meta->child_title;
                                                            echo "<option " . (@$_SESSION['course_details']['general_details']['sub_category'] == $child_id ? "selected" : "") ." value='$child_id'> $child_title </option>";
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
                                            <li><button type="submit" class="btn btn-success next-step" data-form-name="1" id="form-1">Continue</button></li>
                                        </ul>
                                    </form>
                                </div>
                                
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <form role="form" action="" class="login-box" name="course_requirement" id="course_requirement">
                                        <h4 class="text-center">Requirements</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="Requirements">Requirements 1</label>
                                                    <input type="text" class="form-control" id="requirement1"  name="requirement1" placeholder="Provide requirements" value="<?php echo (!empty($_SESSION['course_details']['requirements']['requirement1']) ? $_SESSION['course_details']['requirements']['requirement1'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Requirements">Requirements 2</label>
                                                    <input type="text" class="form-control" id="requirement2"  name="requirement2" placeholder="Provide requirements" value="<?php echo (!empty($_SESSION['course_details']['requirements']['requirement2']) ? $_SESSION['course_details']['requirements']['requirement2'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Requirements">Requirements 3</label>
                                                    <input type="text" class="form-control" id="requirement3"  name="requirement3" placeholder="Provide requirements" value="<?php echo (!empty($_SESSION['course_details']['requirements']['requirement3']) ? $_SESSION['course_details']['requirements']['requirement3'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Requirements">Requirements 4</label>
                                                    <input type="text" class="form-control" id="requirement4"  name="requirement4" placeholder="Provide requirements" value="<?php echo (!empty($_SESSION['course_details']['requirements']['requirement4']) ? $_SESSION['course_details']['requirements']['requirement4'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Requirements">Requirements 5</label>
                                                    <input type="text" class="form-control" id="requirement5"  name="requirement5" placeholder="Provide requirements" value="<?php echo (!empty($_SESSION['course_details']['requirements']['requirement5']) ? $_SESSION['course_details']['requirements']['requirement5'] : '');?>">
                                                </div>
                                            </div> 
                                        </div>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-success prev-step">Back</button></li>                                        
                                            <li><button type="submit" class="btn btn-success next-step">Continue</button></li>
                                        </ul>
                                    </form>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <form role="form" action="" class="login-box" name="outcomes" id="outcomes">
                                        <h4 class="text-center">Outcomes</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="Outcomes">Outcomes 1</label>
                                                    <input type="text" class="form-control" id="Outcomes1" name="Outcomes1" placeholder="Provide Outcome" value="<?php echo (!empty($_SESSION['course_details']['outcomes']['Outcomes1']) ? $_SESSION['course_details']['outcomes']['Outcomes1'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Outcomes2">Outcomes 2</label>
                                                    <input type="text" class="form-control" id="Outcomes2" name="Outcomes2" placeholder="Provide Outcome" value="<?php echo (!empty($_SESSION['course_details']['outcomes']['Outcomes2']) ? $_SESSION['course_details']['outcomes']['Outcomes2'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Outcomes3">Outcomes 3</label>
                                                    <input type="text" class="form-control" id="Outcomes3" name="Outcomes3" placeholder="Provide Outcome" value="<?php echo (!empty($_SESSION['course_details']['outcomes']['Outcomes3']) ? $_SESSION['course_details']['outcomes']['Outcomes3'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Outcomes4">Outcomes 4</label>
                                                    <input type="text" class="form-control" id="Outcomes4" name="Outcomes4" placeholder="Provide Outcome" value="<?php echo (!empty($_SESSION['course_details']['outcomes']['Outcomes4']) ? $_SESSION['course_details']['outcomes']['Outcomes4'] : '');?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Outcomes5">Outcomes 5</label>
                                                    <input type="text" class="form-control" id="Outcomes5" name="Outcomes5"  placeholder="Provide Outcome" value="<?php echo (!empty($_SESSION['course_details']['outcomes']['Outcomes5']) ? $_SESSION['course_details']['outcomes']['Outcomes5'] : '');?>">
                                                </div>
                                            </div>     
                                        </div>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-success prev-step">Back</button></li>                                        
                                            <li><button type="submit" class="btn btn-success next-step">Continue</button></li>
                                        </ul>
                                    </form>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step4">
                                    <form role="form" action="" class="login-box" name="course_price" id="course_price">
                                        <h4 class="text-center">Pricing</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course price ($)  *</label> 
                                                    <input class="form-control" type="number" name="price" id="price" placeholder="Enter course course price" value="<?php echo (!empty($_SESSION['course_details']['pricing']['price']) ? $_SESSION['course_details']['pricing']['price'] : '');?>"> 
                                                </div>
                                                <div class="form-group">
                                                    <label>Discounted price ($) <small>Leave 0 if no discount avalaible</small></label> 
                                                    <input class="form-control" type="number" name="discounted_price" id="discounted_price" placeholder="Enter discounted price" value="<?php echo (!empty($_SESSION['course_details']['pricing']['discounted_price']) ? $_SESSION['course_details']['pricing']['discounted_price'] : '');?>"> 
                                                </div>                                      
                                            </div> 
                                        </div>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                            <li><button type="submit" class="btn btn-success next-step">Continue</button></li>
                                        </ul>
                                    </form>
                                </div>

                                <div class="tab-pane" role="tabpanel" id="step5">
                                    <form role="form" action="" class="login-box" name="course_overview" id="course_overview">                                    
                                        <h4 class="text-center">Course Overview</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="course-provider-source">Course overview provider</label>
                                                    <select class="form-control" id="course_overview_provider" name="course_overview_provider">
                                                        <option value="youtube" <?php echo @($_SESSION['course_details']['overview']['course_overview_provider'] == 'youtube') ? 'selected' : '';?>>Youtube</option>
                                                        <option value="vimeo" <?php echo @($_SESSION['course_details']['overview']['course_overview_provider'] == 'vimeo') ? 'selected' : '';?>>Vimeo</option>
                                                        <option value="direct_upload" <?php echo @($_SESSION['course_details']['overview']['course_overview_provider'] == 'direct_upload') ? 'selected' : '';?>>Upload from your system</option>        
                                                    </select>
                                                </div>
                                                <div class="form-group" id="video_url_block" <?php echo @($_SESSION['course_details']['overview']['course_overview_provider'] == 'direct_upload') ? 'style=display:none;' : '';?>>
                                                    <label>Course preview video url</label> 
                                                    <input class="form-control" type="text" name="video_url" id="video_url" placeholder="Enter video url" value="<?php echo @$_SESSION['course_details']['overview']['video_url'];?>"> 
                                                    <div class="error" id="video_url_error"></div>
                                                </div>

                                                <div class="form-group" id="image_upload_block" <?php echo @($_SESSION['course_details']['overview']['course_overview_provider'] == 'direct_upload') ? 'style=display:block;' : 'style=display:none;';?>>
                                                    <div id="direct_upload">Image</div>
                                                    <div id="image-thumbnail">                                                        
                                                        <?php if(!empty($_SESSION['course_details']['overview']['image_id'])){?>
                                                        <div id="image_box">                                                            
                                                            <?php 
                                                            $get_cat = $db->select("temp_files",array('id' => $_SESSION['course_details']['overview']['image_id']));
                                                            $name = $get_cat->fetch()->name;
                                                            ?>
                                                            <img width="200" src="<?php echo $site_url;?>/temp_images/thumb/<?php echo $name;?>" class="img-thumbnail">
                                                            <input type="hidden" name="image_id" id="image_id" value="56">
                                                            <div class="clearfix"></div>
                                                            <button type="button" class="btn btn-danger" style="margin-top:10px;" onclick="confirmDeleteImage();">Delete</button>
                                                            <div>&nbsp;</div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="error" id="video_url_error"></div>
                                                    <div class="error" id="image_url_error"></div>
                                                </div>
                                                <!-- <div class="form-group imgUp">
                                                    <label>Course Thumbnail</label> 
                                                    <div class="imagePreview"></div>
                                                    <label class="btn btn-primary">
    									    			Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
    			                                    </label>
                                                </div>     -->                                    
                                            </div> 
                                        </div>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                            <li><button type="submit" class="btn btn-success next-step">Continue</button></li>
                                        </ul>
                                    </form>
                                </div>

                                <div class="tab-pane" role="tabpanel" id="step6">
                                    <h4 class="text-center">Curriculum</h4>
                                    <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 text-right">                                 
                                        <a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#add_section"> <i class="fa fa-plus" aria-hidden="true"></i> Add Chapter</a>
                                        <a class="btn btn-outline-primary" href="javascript:void(0);" onclick="show_lesson_modal();" role="button" > <i class="fa fa-plus" aria-hidden="true"></i> Add lesson</a> 
                                        <!-- data-toggle="modal" data-target="#add_lesson" -->
                                    </div>

                                    <div class="col-md-12 mt-4 mb-5" id="course-wrapper">
                                        
                                        <?php
                                        if(!empty($_SESSION['course_details']['chapters'])){
                                            $i=1;
                                            foreach($_SESSION['course_details']['chapters'] as $key => $chapter) {
                                        ?>
                                        <div id="chapter-<?php echo $key;?>" class="card created-lessons mt-4">
                                            <div class="card-body">
                                                <h6 class="">Chapter <?php echo $i;?>: <strong><?php echo $chapter['chapter']?></strong></h6>
                                                <div class="edit-chapter-title">
                                                    <div class="dropdown chapter-dropdown">
                                                        <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="edit_chapter('<?php echo $key;?>')">Edit</a>
                                                            <a class="dropdown-item" data-id="0" onclick="delete_chapter('<?php echo $key;?>')" href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php if(!empty($chapter['lesson'])) { ?>
                                                <?php $x=1;?>
                                                <div id="lesson-wrapper-<?php echo $key;?>">
                                                    <?php foreach ($chapter['lesson'] as $lesson_key => $lesson) {  ?>
                                                    <div class="single-lesson-display mt-4">
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <h6 class="d-inline"><span class="font-weight-light">Lesson <?php echo $x;?> :</span> <?php echo $lesson['lesson_title']?></h6>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="dropdown chapter-dropdown">
                                                                    <i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="show_edit_lesson_popup('<?=$key?>','<?=$lesson_key?>','Chapter <?php echo $i;?>: <strong><?php echo $chapter['chapter']?>')" >Edit</a>
                                                                        <a class="dropdown-item" onclick="delete_lesson('<?=$key?>','<?=$lesson_key?>')" href="javascript:void(0);">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php $x++; } 
                                                }
                                                ?>                                                
                                            </div>
                                        </div>   
                                        <?php 
                                            $i++;
                                            } 
                                        }
                                    ?>
                                    </div>

                                    <div class="col-md-12 mt-4 mb-5 d-none">                                  
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
                            <li><button type="button" class="btn btn-success prev-step">Back</button></li>                                                                        
                            <li><button onclick="publish_course();" type="button" class="btn btn-success next-step">Finish</button></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            
        </div>
    </div>
    </div>
</div>
</section>
<?php include "sections/create/modals-courses.php"; ?>


    <script type="text/javascript">

        function publish_course() {
           Swal.fire({
  title: 'Do you want to save the changes?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: `Save`,
  denyButtonText: `Don't save`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    Swal.fire('Saved!', '', 'success')
  } else if (result.isDenied) {
    Swal.fire('Changes are not saved', '', 'info')
  }
})

        }


        $(document).ready(function () {
        
        
        $("#cat_id").change(function(e){
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: {action : 'get_category',category_id: $(this).val()},
                success:function(data){
                    if (data.status == 1) {
                        $("#sub_category").html(data.html);
                    }                    
                }
            });
        });

        // ------------step-wizard-------------
        //$('.nav-tabs > li a[title]').tooltip();
    
        //Wizard
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target);    
            if (target.parent().hasClass('disabled')) {
                return false;
            }
        });        

        //**** Step #1 form *****/
        $("#create_course_form").validate({
            rules: {
                course_title: "required",
                short_descrption: "required",
                description: "required",   
                cat_id: "required",
                sub_category: "required",                 
            },
            messages: {
                course_title: "Title field is required.",
                short_descrption: "Short description field is required.",
                description: "Description field is required.",
                proposal_cat_id: "Please select a category.",
                proposal_child_id: "Please select a sub category.",
            },
            submitHandler: function(form) {                
                var form_data = $("#create_course_form").serializeArray();
                form_data[form_data.length] = { name: 'action', value: 'save_course_details'};
                form_data[form_data.length] = { name: 'step', value: 'one'};
                
                // Save Detail in DB
                $.ajax({
                    url:"<?php echo $site_url?>/proposals/action_course",
                    method:"POST",
                    dataType: 'json',
                    data: form_data,
                    success:function(data){
                        var active = $('.wizard .nav-tabs li.active');
                        active.next().removeClass('disabled');
                        $("#step1").removeClass("active");
                        $("#step2").addClass("active");
                        nextTab(active);
                    }
                });
            },            
        });  

        //**** Step #2 form *****/
        $("#course_requirement").submit(function(e){
            e.preventDefault();

            var form_data = $("#course_requirement").serializeArray();
            form_data[form_data.length] = { name: 'action', value: 'save_course_details'};
            form_data[form_data.length] = { name: 'step', value: 'two'};
            // Save Detail in DB
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: form_data,
                success:function(data){
                    var active = $('.wizard .nav-tabs li.active');
                    active.next().removeClass('disabled');
                    $("#step2").removeClass("active");
                    $("#step3").addClass("active");
                    nextTab(active);
                }
            });            
        });

        //**** Step #3 form *****/
        $("#outcomes").submit(function(e){
            e.preventDefault();

            var form_data = $("#outcomes").serializeArray();
            form_data[form_data.length] = { name: 'action', value: 'save_course_details'};
            form_data[form_data.length] = { name: 'step', value: 'three'};

            // Save Detail in DB
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: form_data,
                success:function(data){
                    var active = $('.wizard .nav-tabs li.active');
                    active.next().removeClass('disabled');
                    $("#step3").removeClass("active");
                    $("#step4").addClass("active");
                    nextTab(active);
                }
            });            
        });

        //**** Step #4 form *****/
        $("#course_price").validate({
            rules: {
                price: {
                  required: true,
                  number: true
                } ,
                discounted_price: {
                  required: true,
                  number: true
                }                     
            },
            messages: {
                price: {
                    required: "Price field is required.",
                    number: "Please enter a valid number."  
                },
                discounted_price: {
                    required: "Discounted price field is required.",
                    number: "Please enter a valid number."  
                },                
            },
            submitHandler: function(form) {                
                var form_data = $("#course_price").serializeArray();
                form_data[form_data.length] = { name: 'action', value: 'save_course_details'};
                form_data[form_data.length] = { name: 'step', value: 'four'};

                // Save Detail in DB
                $.ajax({
                    url:"<?php echo $site_url?>/proposals/action_course",
                    method:"POST",
                    dataType: 'json',
                    data: form_data,
                    success:function(data){
                        var active = $('.wizard .nav-tabs li.active');
                        active.next().removeClass('disabled');
                        $("#step4").removeClass("active");
                        $("#step5").addClass("active");
                        nextTab(active);
                    }
                });

            },            
        });  

        $("#course_overview_provider").change(function(){
            var provider = $(this).val();

            if (provider == "youtube") {
                $("#video_url_block").css('display',"block");
                $("#image_upload_block").css('display',"none");
            }


            if (provider == "vimeo") {
                $("#video_url_block").css('display',"block");
                $("#image_upload_block").css('display',"none");
            }

            if (provider == "direct_upload") {
                $("#video_url_block").css('display',"none");
                $("#image_upload_block").css('display',"block");
            }

        });

        $("#course_overview").submit(function (event) {
            event.preventDefault();
            var provider = $("#course_overview_provider").val();
            var video_url = $("#video_url").val();

            if (provider == "youtube") {               
                if (video_url == "") {
                    $("#video_url_error").html("Please enter a valid youtube video URL");
                    return false;
                } else {
                    $("#video_url_error").html('');
                    var videoObj = parseVideo(video_url);
                    if (videoObj.id == "" || videoObj.type == undefined) {
                        $("#video_url_error").html("Please enter a valid youtube video URL");     
                        return false;
                    }
                }
            } 

            if (provider == "vimeo") {

                if (video_url == "") {
                    $("#video_url_error").html("Please enter a valid Vimeo video URL");
                    return false;
                } else {
                    $("#video_url_error").html('');
                    var videoObj = parseVideo(video_url);
                    console.log(videoObj)
                    if (videoObj.id == "" || videoObj.type == undefined) {
                        $("#video_url_error").html("Please enter a valid Vimeo video URL"); 
                        return false;    
                    }
                }
            }

            if (provider == "direct_upload") {
                //course_overview
                if($("#image_id").length == 0) {
                    $("#image_url_error").html("Please select a Image");     
                    return false;
                }
            }

            var form_data = $("#course_overview").serializeArray();
            form_data[form_data.length] = { name: 'action', value: 'save_course_details'};
            form_data[form_data.length] = { name: 'step', value: 'five'};
            // Save Detail in DB
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: form_data,
                success:function(data){
                    var active = $('.wizard .nav-tabs li.active');
                    active.next().removeClass('disabled');
                    $("#step5").removeClass("active");
                    $("#step6").addClass("active");
                    nextTab(active);
                }
            });

            //https://www.youtube.com/watch?v=ZHKQgmpabD8           
        });


        var settings = {
            url: "<?php echo $site_url?>/proposals/upload_course_thumbnail",
            dragDrop:false,
            multiple: false,
            fileName: "myfile",
            allowedTypes:"jpg,png,gif,jpeg",
            showProgress: true,
            returnType:"json",
            showAbort: false,
            statusBarWidth: "400",
            showDone: false,
            uploadStr: "Select a Image",
            onSuccess:function(files,data,xhr)
            {
                if(data.status == 1){
                    $("#image-thumbnail").html('');
                    var urlImage = '<?php echo $site_url?>/temp_images/thumb/'+data.name;
                    var html = '<div id="image_box"><img width="200" src='+urlImage+' class="img-thumbnail"/><input type="hidden" name="image_id" id="image_id" value='+data.id+'><div class="clearfix"></div><button type="button" class="btn btn-danger" style="margin-top:10px;" onclick="confirmDeleteImage();">Delete</button><div>&nbsp;</div></div>';
                    $(html).hide().appendTo("#image-thumbnail").fadeIn(1000);
                }            
            },
            afterUploadAll:function(){
                $(".ajax-file-upload-statusbar").remove();
                $("#imageError").html('').hide();
            },
            onSubmit:function(){
            },
            deleteCallback: function(data,pd)
            {}
        }
        var uploadObj = $("#direct_upload").uploadFile(settings);       

        $(".prev-step").click(function (e) {
            var active = $('.wizard .nav-tabs li.active');
            prevTab(active);
        });




        // $(".prev-step").click(function (e) {
        //     var active = $('.wizard .nav-tabs li.active');
        //     prevTab(active);
        // });
});

function confirmDeleteImage()
{
    if(confirm("Are you sure you want to delete")){
        $target = $("#image_box");
        $target.hide('slow', function(){ $target.remove(); });

        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data:{action:'delete_overview_image'},
            success:function(data){
                console.log("Image deleted successfully.");
            }
        });

    } else {
        return false;
    }
}


function nextTab(elem) {
    //$(elem).next().find('a[data-toggle="tab"]').click();

    $(elem).removeClass('active').next().addClass('active');
}
function prevTab(elem) {
    //$(elem).prev().find('a[data-toggle="tab"]').click();
    $(elem).removeClass('active').prev().addClass('active');
    var prevE = $(elem).prev().find('a').attr("href");
    var curE = $(elem).find('a').attr("href");
    $(curE).removeClass('active');
    $(prevE).addClass('active');    
}


// $('.nav-tabs').on('click', 'li', function() {
//     $('.nav-tabs li.active').removeClass('active');
//     $(this).addClass('active');
// });

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


    
function matchYoutubeUrl(url) {
    var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    var matches = url.match(p);
    if(matches){
        return matches[1];
    }
    return false;
}      
</script>