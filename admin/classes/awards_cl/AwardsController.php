<?php
    // include Database connection file
    require_once("../../resources/auth.inc.php");

    // Upload image in add function
    function upload_image($field, $url, $hash_code)
    {
        if(isset($_FILES[$field])) {
            $extension = explode('.', $_FILES[$field]['name']);
            $new_name = $hash_code.'_'.rand(100,1000).'_'.date('Ymd'). '.' . $extension[1];
            $destination = $url . $new_name;
            move_uploaded_file($_FILES[$field]['tmp_name'], $destination);
            return $new_name;
        }
    }
    // remove image in add function
    function removeImage($field, $table, $url, $del_field, $hash_code)
    {
        // fetch file name
        include("../../resources/connect.inc.php");
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM ".$table." WHERE ".$del_field." =:xawc_hashed");
        $stmt_sel->bindParam(':xawc_hashed',$hash_code);
        $stmt_sel->execute();
        while($del_row=$stmt_sel->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow = $del_row[$field];
        }       
        // remove file from directory
        if ($imgRow != "") 
        {
            unlink($url.$imgRow);
        }
        else{
            return false;
        }
    }

    // check request and get award category info
    if(isset($_POST['action']) && ($_POST['action'] == "get_award_category")) {
        // Get all about award category
        $hashed_id = $_POST['hashed_id'];
        $stmt=$db_connect->prepare("SELECT * FROM award_categories WHERE awc_hashed='$hashed_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for award category not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }
    // check request and add award category info
    if(isset($_POST['action']) && ($_POST['action'] == "save_award_category")) {
        $errorMSG = "";
        $awc_hashed = generateRandomString(27);
        $awc_title = $_POST['awc_title'];
        $awc_description = $_POST['awc_description'];
        $awc_year = implode(",", $_POST['awc_year']);
        $awc_active_status = 1;
        $awc_created_at = date('Y-m-d H:i:s');

        if ($awc_title == "") {
            $errorMSG = " Award category title field is required.";
        } 
        if ($awc_description == "") {
            $errorMSG = " Award category description field is required.";
        }
        if ($awc_year == "") {
            $errorMSG = " Atleast one award category year field is required.";
        } 
        if ($_FILES["awc_cover_image"] == "") {
            $errorMSG = " Award category cover image field is required.";
        } 

        // image insert
        $image = '';
        $image_url = UPLOADING_PATH."awards/";

        if($_FILES["awc_cover_image"]["name"] != ''){ $image = upload_image("awc_cover_image", $image_url, $awc_hashed); } else{ $image = ""; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("INSERT INTO award_categories (awc_hashed, awc_title, awc_description, awc_year, awc_cover_image, awc_active_status, awc_created_at) VALUES (:aawc_hashed, :aawc_title, :aawc_description, :aawc_year, :aawc_cover_image, :aawc_active_status, :aawc_created_at)");
            $result02 = $stmt02->execute(
                array(
                    ':aawc_hashed' => $awc_hashed,
                    ':aawc_title' => $awc_title,
                    ':aawc_description' => $awc_description,
                    ':aawc_year' => $awc_year,
                    ':aawc_cover_image' => $image,
                    ':aawc_active_status' => $awc_active_status,
                    ':aawc_created_at' => $awc_created_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." added an award category with ID: ".$awc_hashed;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully added an award category";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and update award category info
    if(isset($_POST['action']) && ($_POST['action'] == "update_award_category")) {
        $errorMSG = "";
        $awc_hashed = $_POST['hidden_hashed'];
        $awc_title = $_POST['ed_awc_title'];
        $awc_description = $_POST['ed_awc_description'];
        $awc_year = implode(",", $_POST['ed_awc_year']);
        $hidden_awc_cover_image = $_POST['hidden_awc_cover_image'];
        $awc_active_status = 1;
        $awc_updated_at = date('Y-m-d H:i:s');

        if ($awc_title == "") {
            $errorMSG = " Award category title field is required.";
        } 
        if ($awc_description == "") {
            $errorMSG = " Award category description field is required.";
        }
        if ($awc_year == "") {
            $errorMSG = " Atleast one award category year field is required.";
        } 
        if ($_FILES["ed_awc_cover_image"]["name"] == "" && $hidden_awc_cover_image=="") {
            $errorMSG = " Award category cover image field is required.";
        } 

        // image insert
        $image = '';
        $image_url = UPLOADING_PATH."awards/";

        if($_FILES["ed_awc_cover_image"]["name"] != ''){
            removeImage("awc_cover_image", "award_categories", $image_url, "awc_hashed", $awc_hashed);
            $image = upload_image("ed_awc_cover_image", $image_url, $awc_hashed);
        } else{ $image = $_POST['hidden_awc_cover_image']; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE award_categories SET 
            awc_title=:aawc_title, awc_description=:aawc_description, awc_year=:aawc_year, awc_cover_image=:aawc_cover_image, awc_active_status=:aawc_active_status, awc_updated_at=:aawc_updated_at WHERE awc_hashed=:aawc_hashed ");
            $result02 = $stmt02->execute(
                array(
                    ':aawc_hashed' => $awc_hashed,
                    ':aawc_title' => $awc_title,
                    ':aawc_description' => $awc_description,
                    ':aawc_year' => $awc_year,
                    ':aawc_cover_image' => $image,
                    ':aawc_active_status' => $awc_active_status,
                    ':aawc_updated_at' => $awc_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." edited an award category with ID: ".$awc_hashed;
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the award caregory";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and award caregory info
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_award_category" && isset($_POST['del_awc_id']) !="") {
        $del_awc_hashed = $_POST['del_awc_id'];
        $awc_active_status = 3;
        // fetch file name
        $stmt_select = $db_connect->prepare('SELECT awc_cover_image FROM award_categories WHERE awc_hashed =:xawc_hashed');
        $stmt_select->bindParam(':xawc_hashed',$del_awc_hashed);
        $stmt_select->execute();
        while($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow  = $del_row['awc_cover_image'];
        }

        // remove file from directory
        if ($imgRow == "") 
        {
            $stmt_delete = $db_connect->prepare('UPDATE award_categories SET awc_active_status=:xawc_active_status, awc_deleted_at=:xawc_deleted_at WHERE awc_hashed =:xawc_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xawc_hashed' => $del_awc_hashed,
                    ':xawc_active_status' => $awc_active_status,
                    ':xawc_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        else 
        {       
            if ($imgRow  != "") { unlink(UPLOADING_PATH."awards/".$imgRow); }
            $stmt_delete = $db_connect->prepare('UPDATE award_categories SET awc_cover_image="", awc_active_status=:xawc_active_status, awc_deleted_at=:xawc_deleted_at WHERE awc_hashed =:xawc_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xawc_hashed' => $del_awc_hashed,
                    ':xawc_active_status' => $awc_active_status,
                    ':xawc_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        // delete file name from database

        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted an award category with ID: ".$del_awc_hashed;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Award caregory was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Award caregory could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }
    // Activate and deactivate award category
    if(isset($_POST['action']) && ($_POST['action'] == "activate_award_category"))
    {
        $up_awc_id = $_POST['up_awc_id'];
        $up_awc_active_status     = $_POST['up_awc_active_status'];

        if ($up_awc_active_status == 1){ $new_awc_active_status = 0; } else { $new_awc_active_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE award_categories SET awc_active_status =:upawc_active_status, awc_updated_at=:upupdated_at WHERE awc_hashed=:upawc_hashed ");
        $result01 = $stmt01->execute(
            array(
                ':upawc_hashed'     => $up_awc_id,
                ':upawc_active_status' => $new_awc_active_status,
                ':upupdated_at'         => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a category award with ID: ".$up_awc_id;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_awc_active_status == 0) {
                $msg = "The category award was disabled successfully.";
            } else {
                $msg = "The category award was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of the category award could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }


    // check request and get about award info
    if(isset($_POST['action']) && ($_POST['action'] == "get_about_award")) {
        // Get all about award
        $award_id = $_POST['award_id'];
        $stmt=$db_connect->prepare("SELECT * FROM about_award WHERE award_id='$award_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for about award not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }
    // check request and update about award info
    if(isset($_POST['action']) && ($_POST['action'] == "save_about_award")) {
        $errorMSG = "";
        $award_id = 2064;
        $award_description = $_POST['award_description'];
        $hid_award_cover_image = $_POST['hid_award_cover_image'];
        $award_updated_at = date('Y-m-d H:i:s');
 
        if ($award_description == "") {
            $errorMSG = " Award description field is required.";
        }
        if ($_FILES["award_cover_image"] == "" && $hid_award_cover_image=="") {
            $errorMSG = " Award category cover image field is required.";
        } 

        // image insert
        $image = '';
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image_url = UPLOADING_PATH."awards/";

        if($_FILES["award_cover_image"]["name"] != ''){
            removeImage("award_cover_image", "about_award", $image_url, "award_id", $award_id);
            $image = upload_image("award_cover_image", $image_url, $award_id);
        } else{ $image = $_POST['hid_award_cover_image']; }

        if($_FILES["award_photo_one"]["name"] != ''){
            removeImage("award_photo_one", "about_award", $image_url, "award_id", $award_id);
            $image1 = upload_image("award_photo_one", $image_url, $award_id);
        } else{ $image1 = $_POST['hid_award_photo_one']; }

        if($_FILES["award_photo_two"]["name"] != ''){
            removeImage("award_photo_two", "about_award", $image_url, "award_id", $award_id);
            $image2 = upload_image("award_photo_two", $image_url, $award_id);
        } else{ $image2 = $_POST['hid_award_photo_two']; }

        if($_FILES["award_photo_three"]["name"] != ''){
            removeImage("award_photo_three", "about_award", $image_url, "award_id", $award_id);
            $image3 = upload_image("award_photo_three", $image_url, $award_id);
        } else{ $image3 = $_POST['hid_award_photo_three']; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE about_award SET 
            award_description=:aaward_description, award_cover_image=:aaward_cover_image, award_photo_one=:aaward_photo_one, award_photo_two=:aaward_photo_two, award_photo_three=:aaward_photo_three, award_updated_at=:aaward_updated_at WHERE award_id=:aaward_id ");
            $result02 = $stmt02->execute(
                array(
                    ':aaward_id' => $award_id, 
                    ':aaward_description' => $award_description,
                    ':aaward_cover_image' => $image,
                    ':aaward_photo_one' => $image1, 
                    ':aaward_photo_two' => $image2, 
                    ':aaward_photo_three' => $image3, 
                    ':aaward_updated_at' => $award_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." updated the about section of the award ";
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the award description";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }

?>