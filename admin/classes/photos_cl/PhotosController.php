<?php
    // include Database connection file
    require_once("../../resources/auth.inc.php");

    // check request and get settings details
    if(isset($_POST['action']) && ($_POST['action'] == "get_photos")) {
        // Get all settings
        $stmt=$db_connect->prepare("SELECT * FROM photos");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                  $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }
    
    // check request and add photos info
    if(isset($_POST['action']) && ($_POST['action'] == "save_photos")) {
        $errorMSG = "";
        $photo_hashed = generateRandomString(27);
        $photo_title = $_POST['photo_title'];
        $photo_date = $_POST['photo_date'];
        $photo_img_caption = $_POST['photo_img_caption'];
        $photo_active_status = 1;
        $photo_created_at = date('Y-m-d H:i:s');
        
        if ($photo_title == "") {
            $errorMSG = " Photo(s) title field is required.";
        }  
        if ($photo_img_caption == "") {
            $errorMSG = " You forgot the image caption. This field is required.";
        } 


        if ($_POST['photo_link'] == "" && $_FILES['photo_image']['name'] == "") {
            $errorMSG = "Make sure either an image is selected or the url is added";
        }

        if (!empty($_POST["photo_link"])) { 
            $sep_links = explode(',', $_POST["photo_link"]);
            foreach ($sep_links as $url => $val){ 
                if (!filter_var($val, FILTER_VALIDATE_URL)) {
                    $errorMSG = "A URL is invalid, please make sure URLs are valid";
                }
            }
        }

        if (isset($_FILES["photo_image"]['name']) && (sizeof($_FILES["photo_image"]['name']) > 50)) {
            $errorMSG = "Number of allowable photo upload exceeded (should not exceed 50).";
        }

        // Execute Query
        if(empty($errorMSG))
        {
            // Image insert
            if ($_POST["photo_link"]=="" && isset($_FILES["photo_image"]['name']) && (sizeof($_FILES["photo_image"]['name']) > 1)) { 
                $upload_images = array();
                $upload_dir = UPLOADING_PATH."gallery_photos/";
                foreach($_FILES['photo_image']['name'] as $key=>$val){       
                    $filename = $_FILES['photo_image']['name'][$key];
                    $fileTmp = $_FILES['photo_image']['tmp_name'][$key]; 
                    $fileExtn = explode('.', $filename);
                    $new_filename = ($filename != "") ? $photo_hashed.'_'.rand(100,1000).'_'.date('Ymd'). '.'.$fileExtn[1] : "";                  
                    $destination = $upload_dir.$new_filename; 

                    if(is_uploaded_file($fileTmp)) {			
                        if(move_uploaded_file($fileTmp, $destination)){
                            $upload_images[] = $destination;
                            $photo_link = "";
                            $stmt01 = $db_connect->prepare("
                            INSERT INTO photos (photo_hashed, photo_title, photo_image, photo_date, photo_link, photo_img_caption, photo_active_status, photo_created_at) 
                            VALUES (:xphoto_hashed, :xphoto_title, :xphoto_image, :xphoto_date, :xphoto_link, :xphoto_img_caption, :xphoto_active_status, :xphoto_created_at )
                            ");
                            $result01 = $stmt01->execute(
                                array(
                                    ':xphoto_hashed' => $photo_hashed,
                                    ':xphoto_title' => $photo_title,
                                    ':xphoto_image' => $new_filename,
                                    ':xphoto_date' => $photo_date,
                                    ':xphoto_link' => $photo_link, 
                                    ':xphoto_img_caption' => $photo_img_caption,
                                    ':xphoto_active_status' => $photo_active_status,
                                    ':xphoto_created_at' => $photo_created_at
                                )
                            );
                        } 
                    }
                }                 
                if(!empty($result01)) {
                    // Record activity history
                    $action = $user_full_name." added photos with ID: ".$photo_hashed;
                    $act_status = "added";
                    log_history($neo_user_code, $action, $act_status);

                    $msg = "You have successfully added photos";
                    echo json_encode(['code'=>200, 'msg'=>$msg]);
                    exit;
                }   
            }
            else if ($_POST["photo_link"]=="" && isset($_FILES["photo_image"]['name']) && (sizeof($_FILES["photo_image"]['name']) <= 1)) {
                
                $filename =  implode ("", $_FILES['photo_image']['name']);
                $fileTmp = implode("", $_FILES['photo_image']['tmp_name']); 
                $extension = explode('.', $filename); 
                $new_name = ($filename != "") ? $photo_hashed.'_'.rand(100,1000).'_'.date('Ymd'). '.' . $extension[1] : "";
                $destination = UPLOADING_PATH.'gallery_photos/' . $new_name;
                move_uploaded_file($fileTmp, $destination);

                $new_filename = $new_name;
                $photo_link = "";
                $stmt01 = $db_connect->prepare("
                INSERT INTO photos (photo_hashed, photo_title, photo_image, photo_date, photo_link, photo_img_caption, photo_active_status, photo_created_at) 
                VALUES (:xphoto_hashed, :xphoto_title, :xphoto_image, :xphoto_date, :xphoto_link, :xphoto_img_caption, :xphoto_active_status, :xphoto_created_at )
                ");
                $result01 = $stmt01->execute(
                    array(
                        ':xphoto_hashed' => $photo_hashed,
                        ':xphoto_title' => $photo_title,
                        ':xphoto_image' => $new_filename,
                        ':xphoto_date' => $photo_date,
                        ':xphoto_link' => $photo_link, 
                        ':xphoto_img_caption' => $photo_img_caption,
                        ':xphoto_active_status' => $photo_active_status,
                        ':xphoto_created_at' => $photo_created_at
                    )
                );
                            
                if(!empty($result01)) {
                    // Record activity history
                    $action = $user_full_name." added a photo with ID: ".$photo_hashed;
                    $act_status = "added";
                    log_history($neo_user_code, $action, $act_status);

                    $msg = "You have successfully added a photo";
                    echo json_encode(['code'=>200, 'msg'=>$msg]);
                    exit;
                }    
            }
            // URL insert
            elseif (isset($_POST["photo_link"]) && !empty($_POST["photo_link"])) {               
                $links = $_POST['photo_link'];
                $individual_links = explode(',', $links);
                if (sizeof($individual_links) > 1) {
                    foreach ($individual_links as $link){
                        $photo_link = $link;
                        $image = "";                    
                        $stmt02 = $db_connect->prepare("
                        INSERT INTO photos (photo_hashed, photo_title, photo_image, photo_date, photo_link, photo_img_caption, photo_active_status, photo_created_at) 
                        VALUES (:xphoto_hashed, :xphoto_title, :xphoto_image, :xphoto_date, :xphoto_link, :xphoto_img_caption, :xphoto_active_status, :xphoto_created_at )
                        ");
                        $result02 = $stmt02->execute(
                            array(
                                ':xphoto_hashed' => $photo_hashed,
                                ':xphoto_title' => $photo_title,
                                ':xphoto_image' => $image,
                                ':xphoto_date' => $photo_date,
                                ':xphoto_link' => $photo_link, 
                                ':xphoto_img_caption' => $photo_img_caption,
                                ':xphoto_active_status' => $photo_active_status,
                                ':xphoto_created_at' => $photo_created_at
                            )
                        );
                    }  
                } else{
                    $photo_link = $_POST['photo_link'];
                    $image = "";                    
                    $stmt02 = $db_connect->prepare("
                    INSERT INTO photos (photo_hashed, photo_title, photo_image, photo_date, photo_link, photo_img_caption, photo_active_status, photo_created_at) 
                    VALUES (:xphoto_hashed, :xphoto_title, :xphoto_image, :xphoto_date, :xphoto_link, :xphoto_img_caption, :xphoto_active_status, :xphoto_created_at )
                    ");
                    $result02 = $stmt02->execute(
                        array(
                            ':xphoto_hashed' => $photo_hashed,
                            ':xphoto_title' => $photo_title,
                            ':xphoto_image' => $image,
                            ':xphoto_date' => $photo_date,
                            ':xphoto_link' => $photo_link, 
                            ':xphoto_img_caption' => $photo_img_caption,
                            ':xphoto_active_status' => $photo_active_status,
                            ':xphoto_created_at' => $photo_created_at
                        )
                    ); 
                }

                if(!empty($result02)) {
                    // Record activity history
                    $action = $user_full_name." added a photo with ID: ".$photo_hashed;
                    $act_status = "added";
                    log_history($neo_user_code, $action, $act_status);

                    $msg = "You have successfully added a photo";
                    echo json_encode(['code'=>200, 'msg'=>$msg]);
                    exit;
                }  
            }
   
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }

    // check request and delete photo info
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_photos" && isset($_POST['del_photos_id']) !="") {
        $del_photos_id  = $_POST['del_photos_id'];
        // fetch image name
        $stmt_select = $db_connect->prepare('SELECT photo_image FROM photos WHERE photo_id =:delid');
        $stmt_select->bindParam(':delid',$del_photos_id);
        $stmt_select->execute();
        while($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow = $del_row['photo_image'];
        }
        
        // remove image from directory
        if ($imgRow != "") 
        {
            unlink(UPLOADING_PATH."gallery_photos/".$imgRow);
            $stmt_delete = $db_connect->prepare('DELETE FROM photos WHERE photo_id =:delid');
            $stmt_delete->bindParam(':delid',$del_photos_id);
            $success_delete  = $stmt_delete->execute(); 
        }
        else 
        {       
            $stmt_delete = $db_connect->prepare('DELETE FROM photos WHERE photo_id =:delid');
            $stmt_delete->bindParam(':delid',$del_photos_id);
            $success_delete  = $stmt_delete->execute(); 
        }
        // delete image name from database

        if($success_delete)
        {
            $msg = "Photo was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Error! Photo could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }

    // Activate and deactivate photos
    if(isset($_POST['action']) && ($_POST['action'] == "activate_photos"))
    {
        $up_photo_id = $_POST['up_photo_id'];
        $up_photo_active_status = $_POST['up_photo_active_status'];

        if ($up_photo_active_status == 1){ $new_photo_active_status = 0; } else { $new_photo_active_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE photos SET photo_active_status =:upphoto_active_status, photo_updated_at=:upupdated_at WHERE photo_id=:upphoto_id ");
        $result01 = $stmt01->execute(
            array(
                ':upphoto_id'     => $up_photo_id,
                ':upphoto_active_status' => $new_photo_active_status,
                ':upupdated_at'         => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a photo with ID: ".$up_photo_id;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_photo_active_status == 0) {
                $msg = "Photo was disabled successfully.";
            } else {
                $msg = "Photo was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of the photo could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }