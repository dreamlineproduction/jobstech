<?php
session_start();
require_once "../includes/db.php";
if (!isset($_SESSION["seller_user_name"])) {
    echo "<script>window.open('../login','_self')</script>";
}

function ranom_unique_string() {
    return substr(md5(time()), 0, 16);
}

//-- Show Edit Chapter Popup
if (!empty($_POST['action']) && $_POST['action'] == 'get_single_chapter') {
    $id = $_POST['id'];
    $title = $_SESSION['course_details']['chapters'][$id]['chapter'];
    $html = "";
    $html .= '<form action="" method="post" id="edit_chapter_frm" name="edit_chapter_frm">';
        $html .= '<input type="hidden" name="action" value="edit_chapter">';
        $html .= '<input type="hidden" name="id" value="'.$id.'">';
        $html .= '<div class="form-group">';
            $html .= '<label for="name">Chapter Title</label>';
            $html .= '<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="'.$title.'">';
            $html .= '<small id="name-error" class="form-text text-muted">Provide a chapter name</small>';
        $html .= '</div>';
        $html .= '<button type="submit" class="btn btn-primary">Submit</button>';
    $html .= '</form>';

    $response['status'] = 1;
    $response['html'] = $html;
    echo json_encode($response);
}

if (!empty($_POST['action']) && $_POST['action'] == 'edit_chapter') {
    
    $name = strip_tags($_POST['name']);
    $id = $_POST['id'];

    if ($name == "") {
        $response['name'] = "Name is a required field";
        $response['status'] = 0;
    } else {
        $_SESSION['course_details']['chapters'][$id]['chapter'] = $name;       
        $response["html"] = get_chapters();
    }


    echo json_encode($response);
}

if (!empty($_POST['action']) && $_POST['action'] == 'add_chapter') {
    
    $name = strip_tags($_POST['name']);

    if ($name == "") {
        $response['name'] = "Name is a required field";
        $response['status'] = 0;
    } else {
        $index = ranom_unique_string();
        if (empty($_SESSION['course_details'])) {
            $_SESSION['course_details']['chapters'][$index] = array('chapter' => $name);
        } else {
            $_SESSION['course_details']['chapters'][$index] = array('chapter' => $name);
        }
        
        $response["html"] = get_chapters();
    }


    echo json_encode($response);
}


if (!empty($_POST['action']) && $_POST['action'] == 'delete_chapter') {

    $id = $_POST['id'];

    if (!empty($_SESSION['course_details']['chapters'])) {
        unset($_SESSION['course_details']['chapters'][$id]);
    }

    $response["html"] = get_chapters();  
    echo json_encode($response);  
}


if (!empty($_POST['action']) && $_POST['action'] == 'delete_overview_image') {

    if (!empty($_SESSION['course_details']['overview']['image_id'])) {
        unset($_SESSION['course_details']['overview']['image_id']);
    }

    $response["html"] = get_chapters();  
    echo json_encode($response);  
}

if (!empty($_POST['action']) && $_POST['action'] == 'delete_lesson') {

    $lesson_id = $_POST['lesson_id'];
    $chapter_id = $_POST['chapter_id'];

    if (!empty($_SESSION['course_details'])) {
        unset($_SESSION['course_details']['chapters'][$chapter_id]['lesson'][$lesson_id]);
    }

    $response["html"] = get_lesson($chapter_id);  
    echo json_encode($response);  
}



if (!empty($_POST['action']) && $_POST['action'] == 'add_lesson' && $_POST['lesson_type'] == "youtube") {
    //print_r($_POST);

    $error = false;
    if ($_POST['lesson_title'] == "") {
        $response['lesson_title'] = "This field is required.";
        $error = true;
    }

    if ($_POST['youtube_url'] == "") {
        $response['youtube_url'] = "This field is required.";
        $error = true;
    } else {
        if(validate_youtube_url($_POST['youtube_url']) == false) {
            $response['youtube_url'] = "Please enter a valid youtube url";
            $error = true;
        }
    }

    if ($_POST['lessonduration'] == "") {
        $response['lessonduration'] = "This field is required.";
        $error = true;
    }

    if ($_POST['lessonsummary'] == "") {
        $response['lessonsummary'] = "This field is required.";
        $error = true;
    }

    if ($error == true) {
        $response['status'] = 0;
    } else {
        $lessonArray = array(
                                'lesson_type' => $_POST['lesson_type'],
                                'lesson_title' => $_POST['lesson_title'],
                                'youtube_url' => $_POST['youtube_url'],
                                'lessonduration' => $_POST['lessonduration'],
                                'lessonsummary' => $_POST['lessonsummary']                                
                            );

        $id = $_POST['chapter_id'];
        $index = ranom_unique_string();
        $_SESSION['course_details']['chapters'][$id]['lesson'][$index] =  $lessonArray;
        $response['status'] = 1;
        $response['html'] = get_lesson($id);
    }

    echo json_encode($response);
}

if (!empty($_POST['action']) && $_POST['action'] == 'add_lesson' && $_POST['lesson_type'] == "vimeo") {
    //print_r($_POST);

    $error = false;
    if ($_POST['lesson_title'] == "") {
        $response['lesson_title'] = "This field is required.";
        $error = true;
    }

    if ($_POST['vimeo_url'] == "") {
        $response['vimeo_url'] = "This field is required.";
        $error = true;
    } else {

        $res = validate_vimeo_url($_POST['vimeo_url']);

        if ($res['video_type'] != 'vimeo') {
            $response['vimeo_url'] = "Please enter a valid vimeo url";
            $error = true;
        }

    }

    if ($_POST['lessonduration'] == "") {
        $response['lessonduration'] = "This field is required.";
        $error = true;
    }

    if ($_POST['lessonsummary'] == "") {
        $response['lessonsummary'] = "This field is required.";
        $error = true;
    }

    if ($error == true) {
        $response['status'] = 0;
    } else {
        $lessonArray = array(
                                'lesson_type' => $_POST['lesson_type'],
                                'lesson_title' => $_POST['lesson_title'],
                                'vimeo_url' => $_POST['vimeo_url'],
                                'lessonduration' => $_POST['lessonduration'],
                                'lessonsummary' => $_POST['lessonsummary']                                
                            );

        $id = $_POST['chapter_id'];
        $index = ranom_unique_string();
        $_SESSION['course_details']['chapters'][$id]['lesson'][$index] =  $lessonArray;
        $response['status'] = 1;
        $response['html'] = get_lesson($id);
    }

    echo json_encode($response);
}



//  If lesson type if video file
if (!empty($_POST['action']) && $_POST['action'] == 'add_lesson' && $_POST['lesson_type'] == "video_file") {
    $error = false;
    if ($_POST['lesson_title'] == "") {
        $response['lesson_title'] = "This field is required.";
        $error = true;
    }

    if (empty($_POST['video_id'])) {
        $response['video_id'] = "Please upload a video file";
        $error = true;
    }

    if ($error == true) {
        $response['status'] = 0;
    } else {
        $lessonArray = array(
                                'lesson_type' => $_POST['lesson_type'],
                                'lesson_title' => $_POST['lesson_title'],
                                'video_id' => $_POST['video_id'],
                                'lessonduration' => $_POST['lessonduration']                                
                            );

        $id = $_POST['chapter_id'];
        $index = ranom_unique_string();
        $_SESSION['course_details']['chapters'][$id]['lesson'][$index] =  $lessonArray;
        $response['status'] = 1;
        $response['html'] = get_lesson($id);
    }

    echo json_encode($response);
}

//  If lesson type video url
if (!empty($_POST['action']) && $_POST['action'] == 'add_lesson' && $_POST['lesson_type'] == "video_url") {
    $error = false;
    if ($_POST['lesson_title'] == "") {
        $response['lesson_title'] = "This field is required.";
        $error = true;
    }

    if (empty($_POST['video_url'])) {
        $response['video_url'] = "This field is required";
        $error = true;
    }

    if ($error == true) {
        $response['status'] = 0;
    } else {
        $lessonArray = array(
                                'lesson_type' => $_POST['lesson_type'],
                                'lesson_title' => $_POST['lesson_title'],
                                'video_url' => $_POST['video_url'],
                                'lessonduration' => $_POST['lessonduration']                                
                            );

        $id = $_POST['chapter_id'];
        $index = ranom_unique_string();

        $_SESSION['course_details']['chapters'][$id]['lesson'][$index] =  $lessonArray;
        $response['status'] = 1;
        $response['html'] = get_lesson($id);
    }

    echo json_encode($response);
}

//  If lesson type document
if (!empty($_POST['action']) && $_POST['action'] == 'add_lesson' && $_POST['lesson_type'] == "document") {
    $error = false;
    if ($_POST['lesson_title'] == "") {
        $response['lesson_title'] = "This field is required.";
        $error = true;
    }

    if (empty($_POST['document_id'])) {
        $response['document_id'] = "Please select a document";
        $error = true;
    }

    if ($error == true) {
        $response['status'] = 0;
    } else {
        $index = ranom_unique_string();
        $lessonArray = array(
                                'lesson_type' => $_POST['lesson_type'],
                                'lesson_title' => $_POST['lesson_title'],
                                'document_id' => $_POST['document_id'],
                                'lessonduration' => $_POST['lessonduration']                                
                            );

        $id = $_POST['chapter_id'];
        $_SESSION['course_details']['chapters'][$id]['lesson'][$index] =  $lessonArray;
        $response['status'] = 1;
        $response['html'] = get_lesson($id);
    }

    echo json_encode($response);
}

//  If lesson type document
if (!empty($_POST['action']) && $_POST['action'] == 'add_lesson' && $_POST['lesson_type'] == "image") {
    $error = false;
    if ($_POST['lesson_title'] == "") {
        $response['lesson_title'] = "This field is required.";
        $error = true;
    }

    if (empty($_POST['image_id'])) {
        $response['image_id'] = "Please select a image";
        $error = true;
    }

    if ($error == true) {
        $response['status'] = 0;
    } else {
        $index = ranom_unique_string();
        $lessonArray = array(
                                'lesson_type' => $_POST['lesson_type'],
                                'lesson_title' => $_POST['lesson_title'],
                                'image_id' => $_POST['image_id'],
                                'lessonduration' => $_POST['lessonduration']                                
                            );

        $id = $_POST['chapter_id'];
        $_SESSION['course_details']['chapters'][$id]['lesson'][$index] =  $lessonArray;
        $response['status'] = 1;
        $response['html'] = get_lesson($id);
    }

    echo json_encode($response);
}

if (!empty($_POST['action']) && $_POST['action'] == 'edit_lesson') {
    $cid = $_POST['chapter_id'];
    $lid = $_POST['lesson_id'];

    $lesson_type = $_SESSION['course_details']['chapters'][$cid]['lesson'][$lid]['lesson_type'];
    //['lesson'][$lid]['lesson_type'];
    

    if ($lesson_type == "youtube") {
        $error = false;
        if ($_POST['lesson_title'] == "") {
            $response['lesson_title'] = "This field is required.";
            $error = true;
        }

        if ($_POST['youtube_url'] == "") {
            $response['youtube_url'] = "This field is required.";
            $error = true;
        } else {
            if(validate_youtube_url($_POST['youtube_url']) == false) {
                $response['youtube_url'] = "Please enter a valid youtube url";
                $error = true;
            }
        }

        if ($_POST['lessonduration'] == "") {
            $response['lessonduration'] = "This field is required.";
            $error = true;
        }

        if ($_POST['lessonsummary'] == "") {
            $response['lessonsummary'] = "This field is required.";
            $error = true;
        }

        if ($error == true) {
            $response['status'] = 0;
        } else {
            $lessonArray = array(   
                                    'lesson_type' => 'youtube',
                                    'lesson_title' => $_POST['lesson_title'],
                                    'youtube_url' => $_POST['youtube_url'],
                                    'lessonduration' => $_POST['lessonduration'],
                                    'lessonsummary' => $_POST['lessonsummary']                                
                                );

            $id = $_POST['chapter_id'];
            $_SESSION['course_details']['chapters'][$cid]['lesson'][$lid] =  $lessonArray;
            $response['status'] = 1;
            $response['id'] = $id;
            $response['html'] = get_lesson($id);
        }
        echo json_encode($response);
    } else if ($lesson_type == "vimeo") {
        $error = false;
        if ($_POST['lesson_title'] == "") {
            $response['lesson_title'] = "This field is required.";
            $error = true;
        }

        if ($_POST['vimeo_url'] == "") {
            $response['vimeo_url'] = "This field is required.";
            $error = true;
        } else {

            $res = validate_vimeo_url($_POST['vimeo_url']);

            if ($res['video_type'] != 'vimeo') {
                $response['vimeo_url'] = "Please enter a valid vimeo url";
                $error = true;
            }

        }

        if ($_POST['lessonduration'] == "") {
            $response['lessonduration'] = "This field is required.";
            $error = true;
        }

        if ($_POST['lessonsummary'] == "") {
            $response['lessonsummary'] = "This field is required.";
            $error = true;
        }

        if ($error == true) {
            $response['status'] = 0;
        } else {
            $lessonArray = array(
                                    'lesson_type' => 'vimeo',
                                    'lesson_title' => $_POST['lesson_title'],
                                    'vimeo_url' => $_POST['vimeo_url'],
                                    'lessonduration' => $_POST['lessonduration'],
                                    'lessonsummary' => $_POST['lessonsummary']                                
                                );

            $id = $_POST['chapter_id'];
            $_SESSION['course_details']['chapters'][$cid]['lesson'][$lid] =  $lessonArray;

            // $response['status'] = 1;
            // $response['html'] = get_lesson($id);

            $response['status'] = 1;
            $response['id'] = $id;
            $response['html'] = get_lesson($id);
        }
        echo json_encode($response);
    } else if($lesson_type == 'video_file') {

        $error = false;
        if ($_POST['lesson_title'] == "") {
            $response['lesson_title'] = "This field is required.";
            $error = true;
        }

        if (empty($_POST['video_id'])) {
            $response['video_id'] = "Please upload a video file";
            $error = true;
        }

        if ($error == true) {
            $response['status'] = 0;
        } else {
            $lessonArray = array(
                                    'lesson_type' => 'video_file',
                                    'lesson_title' => $_POST['lesson_title'],
                                    'video_id' => $_POST['video_id'],
                                    'lessonduration' => ''                                
                                );

            
            $_SESSION['course_details']['chapters'][$cid]['lesson'][$lid] =  $lessonArray;
            $response['status'] = 1;
            $response['html'] = get_lesson($cid);
            $response['id'] = $cid;
        }

        echo json_encode($response);
    } else if($lesson_type == 'video_url') {
        $error = false;
        if ($_POST['lesson_title'] == "") {
            $response['lesson_title'] = "This field is required.";
            $error = true;
        }

        if (empty($_POST['video_url'])) {
            $response['video_url'] = "This field is required";
            $error = true;
        }

        if ($error == true) {
            $response['status'] = 0;
        } else {
            $lessonArray = array(
                                    'lesson_type' => 'video_url',
                                    'lesson_title' => $_POST['lesson_title'],
                                    'video_url' => $_POST['video_url'],
                                    'lessonduration' => ''                                
                                );

            $id = $_POST['chapter_id'];

            $_SESSION['course_details']['chapters'][$id]['lesson'][$lid] =  $lessonArray;
            $response['status'] = 1;
            $response['html'] = get_lesson($id);
        }

        echo json_encode($response);
    }
}   

if (!empty($_GET['action']) && $_GET['action'] == 'array') {
    echo "<pre>";
    //unset($_SESSION['course_details']);
    @print_r($_SESSION['course_details']);
    echo "</pre>";
}

if (!empty($_POST['action']) && $_POST['action'] == 'show_add_lesson_popup') {

    $html = '<form>
                <div class="form-group">
                <label for="select-chapter">Select Chapter</label>';

    $html .=  '<select class="form-control" id="chapter" name="chapter">';
    if (!empty($_SESSION['course_details']['chapters'])) {
        $x=1;
        foreach ($_SESSION['course_details']['chapters'] as $key => $row) {     
            $html .=  '<option value="'.$key.'|Chapter '.$x.': '.$row['chapter'].'">Chapter '.$x.': '.$row['chapter'].'</option>';
            $x++;
        }
    }                

    $html .=  '</select>';
    $html .= '<div class="error chapter_error"></div>';
    $html .= '</div>';
    
    $html .= '<div class="form-group">
            <label for="exampleInputEmail1">Select Lesson Type</label>
            <select class="form-control" name="lesson_type" id="lesson_type">
                <option value="" selected disabled>Select Lesson Type</option>
                <option value="Youtube">Youtube</option>
                <option value="Vimeo">Vimeo</option>
                <option value="Video-file">Video file</option>
                <option value="Video-url">Video url [ .mp4 ]</option>
                <option value="Document">Document</option>
                <option value="Image-file">Image file</option>
            </select>
        </div>
        <div class="error type_error"></div>
    </form>';

    $response["html"] = $html;  
    echo json_encode($response); 
}


// Save Course Details in session
if (!empty($_POST['action']) && $_POST['action'] == 'save_course_details') {
    if (!empty($_POST['step']) && $_POST['step'] == 'one') {
        $_SESSION['course_details']['general_details'] = $_POST;        
        $response["status"] = 1;  
        echo json_encode($response); 
        exit;
    }

    if (!empty($_POST['step']) && $_POST['step'] == 'two') {
        $_SESSION['course_details']['requirements'] = $_POST;        
        $response["status"] = 1;  
        echo json_encode($response); 
        exit;
    }

    if (!empty($_POST['step']) && $_POST['step'] == 'three') {
        $_SESSION['course_details']['outcomes'] = $_POST;        
        $response["status"] = 1;  
        echo json_encode($response); 
        exit;
    }

    if (!empty($_POST['step']) && $_POST['step'] == 'four') {
        $_SESSION['course_details']['pricing'] = $_POST;        
        $response["status"] = 1;  
        echo json_encode($response); 
        exit;
    }

    if (!empty($_POST['step']) && $_POST['step'] == 'five') {
        $_SESSION['course_details']['overview'] = $_POST;        
        $response["status"] = 1;  
        echo json_encode($response); 
        exit;
    }

    if (!empty($_POST['step']) && $_POST['step'] == 'six') {
//        $_SESSION['course_details']['overview'] = $_POST;
//        $response["status"] = 1;
//        echo json_encode($response);

        $course_overview_provider_code = [
            'youtube' => 0,
            'vimeo' => 1,
            'upload' => 2
        ];

        $insert_array = [
            'seller_id' => $login_seller_id,
            'title' => $_SESSION['course_details']['general_details']['course_title'],
            'short_description' => $_SESSION['course_details']['general_details']['short_descrption'],
            'description' => $_SESSION['course_details']['general_details']['description'],
            'category' => $_SESSION['course_details']['general_details']['cat_id'],
            'sub_category' => $_SESSION['course_details']['general_details']['sub_category'],
            'level' => $_SESSION['course_details']['general_details']['level'],
            'language' => $_SESSION['course_details']['general_details']['language'],
            'requirement_1' => $_SESSION['course_details']['requirements']['requirement1'],
            'requirement_2' => $_SESSION['course_details']['requirements']['requirement2'],
            'requirement_3' => $_SESSION['course_details']['requirements']['requirement3'],
            'requirement_4' => $_SESSION['course_details']['requirements']['requirement4'],
            'requirement_5' => $_SESSION['course_details']['requirements']['requirement5'],
            'outcomes_1' => $_SESSION['course_details']['outcomes']['Outcomes1'],
            'outcomes_2' => $_SESSION['course_details']['outcomes']['Outcomes2'],
            'outcomes_3' => $_SESSION['course_details']['outcomes']['Outcomes3'],
            'outcomes_4' => $_SESSION['course_details']['outcomes']['Outcomes4'],
            'outcomes_5' => $_SESSION['course_details']['outcomes']['Outcomes5'],
            'price' => $_SESSION['course_details']['pricing']['price'],
            'discounted_price' => $_SESSION['course_details']['pricing']['discounted_price'],
            'course_overview_provider' => $course_overview_provider_code[strtolower($_SESSION['course_details']['overview']['course_overview_provider'])],
            'course_preview_video_url' => $_SESSION['course_details']['overview']['video_url'],
        ];

        $db->insert('courses', $insert_array);

        $course_id = $db->lastInsertId();

        foreach ($_SESSION['course_details']['chapters'] as $chapter) {
            $now = date('Y-m-d H:i:s');
            $db->insert('course_chapters', [
                'course_id' => $course_id,
                'title' => $chapter['chapter'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $chapter_id = $db->lastInsertId();

            foreach ($chapter['lesson'] as $lesson) {
                $lesson_file = false;
                if ($lesson['lesson_type'] == 'youtube' || $lesson['lesson_type'] == 'vimeo') {
                    $url = $lesson[$lesson['lesson_type'] . '_url'];
                } elseif ($lesson['lesson_type'] == 'video_url') {
                    $url = $lesson[$lesson['lesson_type']];
                } else {
                    $lesson_file = true;
                    $url = NULL;
                }

                $now = date('Y-m-d H:i:s');
                $insert_array = [
                    'chapter_id' => $chapter_id,
                    'type' => $lesson['lesson_type'],
                    'title' => $lesson['lesson_title'],
                    'url' => $url,
                    'duration' => $lesson['lessonduration'],
                    'summary' => $lesson['lessonsummary'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $db->insert('course_lessons', $insert_array);
                $lesson_id = $db->lastInsertId();

                if ($lesson_file) {
                    if ($lesson['lesson_type'] == 'video_file') {
                        $file_id = $lesson['video_id'];
                    } elseif ($lesson['lesson_type'] == 'document') {
                        $file_id = $lesson['document_id'];
                    } else {
                        $file_id = $lesson['image_id'];
                    }

                    $video = $db->select('temp_files', ['id' => $file_id])->fetch();

                    if (!empty($video)) {
                        $filename_parts = explode('.', $video->name);
                        $ext = end($filename_parts);
                        $new_filename = $lesson_id . '.' . $ext;

                        rename('../temp_images/' . $video->name, '../lesson_files/' . $new_filename);
//                        uploadToS3('lesson_files/' . $new_filename, '../temp_images/' . $video->name);

                        $url = $new_filename;
                        $db->update('course_lessons', ['url' => $url], ['id' => $lesson_id]);
                    }
                }
            }
        }

        $response["status"] = 1;
        echo json_encode($response);
        exit;
    }

}


if (!empty($_POST['action']) && $_POST['action'] == 'get_category') {

    $category_id = $_POST['category_id'];
    $get_c_cats = $db->select("categories_children", ["child_parent_id" => $category_id,]);

    $html = '<option value=""> Select A Sub Category </option>';
    while ($row_c_cats = $get_c_cats->fetch()) {
        $child_id = $row_c_cats->child_id;
        $get_meta = $db->select("child_cats_meta", [
                        "child_id" => $child_id,
                        "language_id" => $siteLanguage,
                    ]);
        $row_meta = $get_meta->fetch();
        $child_title = $row_meta->child_title;
        $html .= "<option value='$child_id'> $child_title </option>";
    }

    $response["html"] = $html;  
    $response["status"] = 1;  
    echo json_encode($response); 
}

if (!empty($_POST['action']) && $_POST['action'] == 'get_single_lesson') {
    $cid = $_POST['c_id'];
    $lid = $_POST['l_id'];
    $name = $_POST['name'];
    $lesson = $_SESSION['course_details']['chapters'][$cid]['lesson'][$lid];

    if ($lesson['lesson_type'] == "youtube") {
        $html = '<form id="edit_youtube_lesson_frm" name="edit_youtube_lesson_frm" action="" method="post">';        
        $html .= '<div class="modal-body">';
            $html .= '<input type="hidden" name="chapter_id" id="chapter_id" value="'.$cid.'">';
            $html .= '<input type="hidden" name="lesson_id" id="lesson_id" value="'.$lid.'">';
            $html .= '<div class="alert alert-success" id="chapter">';
                $html .= $name;
            $html .= '</div>';

            $html .= '<div class="Youtube lesson-box">';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Lesson Title</label>';                            
                    $html .= '<input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title" value="'.$lesson['lesson_title'].'">';
                    $html .= '<p class="error lesson_title_error"></p>';
                $html .= '</div>';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Youtube url</label>';
                    $html .= '<input type="url" class="form-control" id="youtube_url" name="youtube_url" placeholder="Youtube URL" value="'.$lesson['youtube_url'].'">';
                    $html .= '<p class="error youtube_url_error"></p>';
                $html .= '</div>';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Duration</label>';
                    $html .= '<input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration" value="'.$lesson['lessonduration'].'">';
                    $html .= '<p class="error lessonduration_error"></p>';
                $html .= '</div>';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Summary</label>';
                    $html .= '<textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary">'.$lesson['lessonsummary'].'</textarea>';
                    $html .= '<p class="error lessonsummary_error"></p>';
                $html .= '</div>';
            $html .= '</div>';

        
        $html .= '</div>';
        $html .= '<div class="modal-footer">';
                    $html .= '<input type="hidden" name="action" value="edit_lesson">';
                    $html .= '<button type="submit" class="btn btn-success">Update</button>';
        $html .= '</div>';
        $html .= '</form>';    

    } else if ($lesson['lesson_type'] == "vimeo") {
        $html = '<form id="edit_vimeo_lesson_frm" name="edit_vimeo_lesson_frm" action="" method="post">';        
        $html .= '<div class="modal-body">';
            $html .= '<input type="hidden" name="chapter_id" id="chapter_id" value="'.$cid.'">';
            $html .= '<input type="hidden" name="lesson_id" id="lesson_id" value="'.$lid.'">';
            $html .= '<div class="alert alert-success" id="chapter">';
                $html .= $name;
            $html .= '</div>';

            $html .= '<div class="lesson-box">';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Lesson Title</label>';                            
                    $html .= '<input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title" value="'.$lesson['lesson_title'].'">';
                    $html .= '<p class="error lesson_title_error"></p>';
                $html .= '</div>';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Vimeo url</label>';
                    $html .= '<input type="url" class="form-control" id="vimeo_url" name="vimeo_url" placeholder="Vimeo URL" value="'.$lesson['vimeo_url'].'">';
                    $html .= '<p class="error vimeo_url_error"></p>';
                $html .= '</div>';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Duration</label>';
                    $html .= '<input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration" value="'.$lesson['lessonduration'].'">';
                    $html .= '<p class="error lessonduration_error"></p>';
                $html .= '</div>';
                $html .= '<div class="form-group">';
                    $html .= '<label class="">Summary</label>';
                    $html .= '<textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary">'.$lesson['lessonsummary'].'</textarea>';
                    $html .= '<p class="error lessonsummary_error"></p>';
                $html .= '</div>';
            $html .= '</div>';

        
        $html .= '</div>';
        $html .= '<div class="modal-footer">';
                    $html .= '<input type="hidden" name="action" value="edit_lesson">';
                    $html .= '<button type="submit" class="btn btn-success">Update</button>';
        $html .= '</div>';
        $html .= '</form>';
    } else if ($lesson['lesson_type'] == "video_file") {

        $html = '<form id="edit_video_lesson_frm" name="edit_video_lesson_frm" action="" method="post">';        
            $html .= '<div class="modal-body">';
                $html .= '<input type="hidden" name="chapter_id" id="chapter_id" value="'.$cid.'">';
                $html .= '<input type="hidden" name="lesson_id" id="lesson_id" value="'.$lid.'">';
                $html .= '<div class="alert alert-success" id="chapter">';
                    $html .= $name;
                $html .= '</div>';

                $html .= '<div class="lesson-box">';

                    $html .= '<div class="form-group">';
                        $html .= '<label class="">Lesson Title</label>';
                        $html .= '<input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title" value="'.$lesson['lesson_title'].'">';
                        $html .= '<p class="error lesson_title_error"></p>';
                    $html .= '</div>';            

                    $html .= '<script type="text/javascript" src="https://cdn.jwplayer.com/libraries/hfiS1ZF7.js"></script>';
                    $html .= '<div id="lesson_video_edit">Video</div>';
                    
                    $video_info = $db->select("temp_files", ["id" => $lesson['video_id']]);
                    $video_data = $video_info->fetch();

                    $url = $site_url.'/temp_images/'.$video_data->name;
                    $html .= '<div id="lesson_video_edit_preview"></div>';                 
                    $html .= '<div id="video_info_edit"><input type=\'hidden\' name=\'video_id\' id=\'video_id\' value='.$lesson['video_id'].'></div>';
                    $html .= '<div class="error" id="lesson_video_error"></div>';

                $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="modal-footer">';
                        $html .= '<input type="hidden" name="action" value="edit_lesson">';
                        $html .= '<button type="submit" class="btn btn-success">Update</button>';
            $html .= '</div>';
        $html .= '</form>';


        
        // $child_title = $row_meta->child_title;

        // Update Filename after insert
        // $update_request = $db->update("temp_files",array("name" => $newFileName),array("id" => $id));
        // $response['name'] = $newFileName;
        // $response['id'] = $id;
        // $response['status'] = 1;
        // $response['html'] = $html;
        // $response['video_info'] = '<input type=\'text\' name=\'video_id\' id=\'video_id\' value='.$id.'>';
        $v_code = "<script type=\"text/javascript\">
                            var player = jwplayer('lesson_video_edit_preview');
                            player.setup({
                                file: '".$url."'                                
                            });
                        </script>";
        $response['video_code'] = $v_code;

   } else if ($lesson['lesson_type'] == "video_url") {
          $html = '<form id="edit_video_url_lesson_frm" name="edit_video_url_lesson_frm" action="" method="post">';        
            $html .= '<div class="modal-body">';
                $html .= '<input type="hidden" name="chapter_id" id="chapter_id" value="'.$cid.'">';
                $html .= '<input type="hidden" name="lesson_id" id="lesson_id" value="'.$lid.'">';
                $html .= '<div class="alert alert-success" id="chapter">';
                    $html .= $name;
                $html .= '</div>';

                $html .= '<div class="lesson-box">';
                        $html .= '<div class="form-group">';
                            $html .= '<label class="">Lesson Title</label>';
                            $html .= '<input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title" value="'.$lesson['lesson_title'].'">';
                            $html .= '<p class="error lesson_title_error"></p>';
                        $html .= '</div>';
                        $html .= '<div class="form-group">';
                            $html .= '<label class="">Video URL</label>';
                            $html .= '<input type="url" class="form-control" id="video_url" name="video_url" placeholder="Video URL" value="'.$lesson['video_url'].'">';
                            $html .= '<p class="error video_url_error"></p>';
                        $html .= '</div>';
                    $html .= '</div>';

            $html .= '</div>';
            $html .= '<div class="modal-footer">';
                        $html .= '<input type="hidden" name="action" value="edit_lesson">';
                        $html .= '<button type="submit" class="btn btn-success">Update</button>';
            $html .= '</div>';
        $html .= '</form>';
    }

    $response["html"] = $html;  
    $response["status"] = 1;  
    echo json_encode($response); 
}

// function get_single_lesson(){
//     print_r($_POST);
// }


function get_lesson($id) {
    $html = '';

    // print_r($_SESSION['course_details'][$id]['lesson']);
    // exit;
    if (!empty($_SESSION['course_details']['chapters'][$id]['lesson'])) {
        $i=1;
        foreach ($_SESSION['course_details']['chapters'][$id]['lesson'] as $key => $row) {

            $html .= '<div class="single-lesson-display mt-4">';
                $html .= '<div class="row">';
                    $html .= '<div class="col-md-11">';
                        $html .= '<h6 class="d-inline"><span class="font-weight-light">Lesson '.$i.' :</span> '.$row['lesson_title'].'</h6>';
                    $html .= '</div>';
                    $html .= '<div class="col-md-1">';
                        $html .= '<div class="dropdown chapter-dropdown">';     
                            $html .= '<i class="fa fa-ellipsis-h" aria-hidden="true" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>';
                            $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                $cname = get_chapter_name($id);
                                $html .= '<a class="dropdown-item" href="javascript:void(0);" onclick=\'show_edit_lesson_popup("'.$id.'","'.$key.'","'.$cname.'")\'>Edit</a>';   
                                $html .= '<a class="dropdown-item" onclick=\'delete_lesson("'.$id.'","'.$key.'")\' href="javascript:void(0);">Delete</a>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
            $i++;
        }
    }
    return $html;
}

function get_chapter_name($id) {

    if (!empty($_SESSION['course_details'])) {
        $i=1;
        foreach ($_SESSION['course_details']['chapters'] as $key => $row) {
            if ($key == $id) {
                return 'Chapter '.$i.' : '.$row['chapter'];
            }
            $i++;
        }
    }

}

function get_chapters() {
    $html = "";
    $sn = 1;    
    if (!empty($_SESSION['course_details']['chapters'])) {
        foreach ($_SESSION['course_details']['chapters'] as $key => $row) {                    
            $html .= "<div id=\"chapter-".$key."\" class=\"card created-lessons mt-4\">";
                $html .= "<div class=\"card-body\">";
                    $html .= "<h6 class=\"\">Chapter $sn: <strong>".$row['chapter']."</strong></h6>";
                    $html .= "<div class=\"edit-chapter-title\">";
                        $html .= "<div class=\"dropdown chapter-dropdown\">";             
                            $html .= "<i class=\"fa fa-ellipsis-h\" aria-hidden=\"true\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"></i>";
                            $html .= "<div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">";
                                $html .= "<a class=\"dropdown-item\" href=\"javascript:void(0)\" onclick=\"edit_chapter('".$key."')\">Edit</a>";
                                $html .= "<a class=\"dropdown-item\" data-id=".$key." onclick=\"delete_chapter('".$key."')\" href=\"javascript:void(0);\">Delete</a>";
                            $html .= "</div>";
                        $html .= "</div>";                                
                    $html .= "</div>";
                    $html .= "<div id=\"lesson-wrapper-".$key."\">";
                    $html .= get_lesson($key);
                    $html .= "</div>";
                $html .= "</div>";
            $html .= "</div>";
            $sn++;
        }
    }    
    return $html;
}

function validate_youtube_url($url) {   
    $url_parsed_arr = parse_url($url);
    if ($url_parsed_arr['host'] == "www.youtube.com" && $url_parsed_arr['path'] == "/watch" && substr($url_parsed_arr['query'], 0, 2) == "v=" && substr($url_parsed_arr['query'], 2) != "") {
        return true;
    } else {
       return false;
    }
}

function validate_vimeo_url($url) {
    $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
    $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);

    $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
    $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);

    //Then we want the video id which is:
    if($has_match_youtube) {
        $video_id = $yt_matches[5]; 
        $type = 'youtube';
    }
    elseif($has_match_vimeo) {
        $video_id = $vm_matches[5];
        $type = 'vimeo';
    }
    else {
        $video_id = 0;
        $type = 'none';
    }

    $data['video_id'] = $video_id;
    $data['video_type'] = $type;
    return $data;
}

$output_dir = "../temp_images/";
if(isset($_FILES["video_file_lesson"])){
    $response = array();
    $error =$_FILES["video_file_lesson"]["error"];
    if(!is_array($_FILES["video_file_lesson"]["name"])) {

        // Insert in Database
        $form_data['created_date'] = date("Y-m-d");
        $db->insert("temp_files",$form_data);  

        $id = $db->lastInsertId();
        $fileName = $_FILES["video_file_lesson"]["name"];

        // Upload File
        $imageArray = explode('.', $fileName);
        $extension = end($imageArray);
        $newFileName = $id.'.'.$extension;
        move_uploaded_file($_FILES["video_file_lesson"]["tmp_name"],$output_dir.$newFileName);
        $ret[]= $fileName;

        $url = $site_url.'/temp_images/'.$newFileName;

        $html = "<div class=\"d-block w-100\" id=\"player\"></div>
        <script type=\"text/javascript\">
            var player = jwplayer('lesson_video_preview');
            player.setup({
                file: '".$url."'                                
            });
        </script>";
        
        // Update Filename after insert
        $update_request = $db->update("temp_files",array("name" => $newFileName),array("id" => $id));
        $response['name'] = $newFileName;
        $response['id'] = $id;
        $response['status'] = 1;
        $response['html'] = $html;
        $response['video_info'] = '<input type=\'text\' name=\'video_id\' id=\'video_id\' value='.$id.'>';
        $response['url'] = $url;
    }
    
    echo json_encode($response);
}

$output_dir = "../temp_images/";
if(isset($_FILES["document_file_lesson"])){
    $response = array();
    $error =$_FILES["document_file_lesson"]["error"];
    if(!is_array($_FILES["document_file_lesson"]["name"])) {

        // Insert in Database
        $form_data['created_date'] = date("Y-m-d");
        $db->insert("temp_files",$form_data);  

        $id = $db->lastInsertId();
        $fileName = $_FILES["document_file_lesson"]["name"];

        // Upload File
        $imageArray = explode('.', $fileName);
        $extension = end($imageArray);
        $newFileName = $id.'.'.$extension;
        move_uploaded_file($_FILES["document_file_lesson"]["tmp_name"],$output_dir.$newFileName);
        $ret[]= $fileName;

        $url = $site_url.'/temp_images/'.$newFileName;

        $html = "<i class='fas " . ($extension == "pdf" ? "fa-file-pdf" : "fa-file-word") . "'></i><a href='".$url."'>Download</a>";
        
        // Update Filename after insert
        $update_request = $db->update("temp_files",array("name" => $newFileName),array("id" => $id));
        $response['name'] = $newFileName;
        $response['id'] = $id;
        $response['status'] = 1;
        $response['html'] = $html;
        $response['document_info'] = '<input type=\'text\' name=\'document_id\' id=\'document_id\' value='.$id.'>';
        
    }
    
    echo json_encode($response);
}

$output_dir = "../temp_images/";
if(isset($_FILES["lesson_image"]))
{
    $response = array();
    $error =$_FILES["lesson_image"]["error"];
    if(!is_array($_FILES["lesson_image"]["name"])) {

        // Insert in Database
        $form_data['created_date'] = date("Y-m-d");
        $db->insert("temp_files",$form_data);  

        $id = $db->lastInsertId();
        $fileName = $_FILES["lesson_image"]["name"];

        // Upload File
        $imageArray = explode('.', $fileName);
        $extension = end($imageArray);
        $newFileName = $id.'.'.$extension;
        move_uploaded_file($_FILES["lesson_image"]["tmp_name"],$output_dir.$newFileName);
        $ret[]= $fileName;

        $url = $site_url.'/temp_images/'.$newFileName;

        $html = "<div class='col-md-6'><img src='".$url."' class=\"w-100\"></div>";
        
        // Update Filename after insert
        $update_request = $db->update("temp_files",array("name" => $newFileName),array("id" => $id));
        $response['name'] = $newFileName;
        $response['id'] = $id;
        $response['status'] = 1;
        $response['html'] = $html;
        $response['image_info'] = '<input type=\'text\' name=\'image_id\' id=\'image_id\' value='.$id.'>';
        
    }
    
    echo json_encode($response);
}


file_put_contents('../log123.txt', '<pre>' . print_r($_SESSION, true) . '</pre>', FILE_APPEND);

?>