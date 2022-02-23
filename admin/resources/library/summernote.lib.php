<?php

    // include Database connection file
    require_once("../../resources/directories.inc.php");

    // Return the domain uri
    function url(){
      return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
      );
    }

    // Upload file into directory
    if (isset($_FILES['file']['name']) && isset($_POST['upload_directory']) && isset($_POST['action']) && $_POST['action']=='upload_file') {
        if (!$_FILES['file']['error']) {
            $folder_dir = $_POST['upload_directory'];
            $name = rand(100,1000).'_'.date('Ymd');

            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $name.'.'.$ext;
            $destination = '../../../uploads/'.$folder_dir.'/'.$filename; //change this directory
            $location = $_FILES["file"]["tmp_name"];
            move_uploaded_file($location, $destination);
            echo UPLOADS_PATH.$folder_dir.'/'.$filename;
        } else {
            echo 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
        }
    }

    // Delete file from directory
    if (isset($_POST['img_src']) && isset($_POST['delete_directory']) && isset($_POST['action']) && $_POST['action']=='remove_file') {
        $full_img_src = $_POST['img_src'];
        $folder_dir = $_POST['delete_directory'];

        $upload_dir_url = url().UPLOADS_PATH.$folder_dir.'/';
        $file_name = str_replace($upload_dir_url, '', $full_img_src); // striping url to get file name
        $upload_path = '../../../uploads/'.$folder_dir.'/'.$file_name; // path to delete from

        if(unlink($upload_path)){
            echo 'File removed successfully';
        } else {
            echo 'File could not be removed successfully';
        }
    }

?>