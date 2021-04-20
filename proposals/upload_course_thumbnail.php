<?php
session_start();
require_once "../includes/db.php";
if (!isset($_SESSION["seller_user_name"])) {
    echo "<script>window.open('../login','_self')</script>";
}

use Intervention\Image\ImageManagerStatic as Image;




$output_dir = "../temp_images/";
if(isset($_FILES["myfile"]))
{
    $response = array();
    $error =$_FILES["myfile"]["error"];
    if(!is_array($_FILES["myfile"]["name"])) {
        // Insert in Database
        $form_data['created_date'] = date("Y-m-d");
        $db->insert("temp_files",$form_data);  

        $id = $db->lastInsertId();
        $fileName = $_FILES["myfile"]["name"];

        // Upload File
        $imageArray = explode('.', $fileName);
        $extension = end($imageArray);
        $newFileName = $id.'.'.$extension;
        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$newFileName);
        $ret[]= $fileName;

        
        // Resize Image
        $img = Image::make($output_dir.$newFileName);
        $img->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($output_dir.'thumb/'.$newFileName);

        
        // Update Filename after insert
        $update_request = $db->update("temp_files",array("name" => $newFileName),array("id" => $id));
        $response['name'] = $newFileName;
        $response['id'] = $id;
        $response['status'] = 1;
    }
    
    echo json_encode($response);
}

?>