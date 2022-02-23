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
    function removeImage($field, $url, $hash_code)
    {
        // fetch file name
        include("../../resources/connect.inc.php");
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM adverts_posts WHERE adverts_hashed =:xadverts_hashed");
        $stmt_sel->bindParam(':xadverts_hashed',$hash_code);
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

    // check request and get adverts info
    if(isset($_POST['action']) && ($_POST['action'] == "get_adv")) {
        // Get all about adverts
        $hashed_id = $_POST['hashed_id'];
        $stmt=$db_connect->prepare("SELECT * FROM adverts_posts WHERE adverts_hashed='$hashed_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for advert not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }
    // check request and add adv info
    if(isset($_POST['action']) && ($_POST['action'] == "save_adv")) {
        $errorMSG = "";
        $adverts_hashed = generateRandomString(27);
        $adverts_type = $_POST['adverts_type'];
        $adverts_dimension = $_POST['adverts_dimension'];
        $adverts_category = $_POST['adverts_category'];
        $adverts_title = $_POST['adverts_title'];
        $adverts_briefing = $_POST['adverts_briefing'];
        $adverts_campaign_days = implode(",", $_POST['adverts_campaign_days']);
        $adverts_organisation = $_POST['adverts_organisation'];
        $adverts_start_date = $_POST['adverts_start_date'];
        $adverts_end_date = $_POST['adverts_end_date'];
        $adverts_url = $_POST['adverts_url'];
        $adverts_video_url = $_POST['adverts_video_url'];
        $adverts_active_status = 0;
        $adverts_click_count = 0;
        $adverts_created_by = $neo_user_code;
        $adverts_created_at = date('Y-m-d H:i:s');

        if ($adverts_title == '') {
            $errorMSG = "Title of advert is required";
        }
        if ($adverts_type == '') {
            $errorMSG = "Select the ad type. Field is required.";
        }
        if ($adverts_category == '') {
            $errorMSG = "Category of ad is required";
        }
        if ($adverts_campaign_days == '') {
            $errorMSG = "Ad days to display is required";
        }
        if ($adverts_dimension == '') {
            $errorMSG = "Dimension for this ad is required";
        }
        if ($adverts_organisation == '') {
            $errorMSG = "Organisation publishing this ad is required";
        }
        if ($adverts_start_date == '') {
            $errorMSG = "Ad campaign start date is required";
        }
        if ($adverts_end_date == '') {
            $errorMSG = "Ad campaign end date is required";
        }

        // image insert
        $image = '';

        $image_url = UPLOADING_PATH."advsImages/";
        if($_FILES["adverts_cover_image"]["name"] != ''){ $image = upload_image("adverts_cover_image", $image_url, $adverts_hashed); } else{ $image = ""; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("
                INSERT INTO adverts_posts (adverts_hashed, adverts_type, adverts_dimension, adverts_category, adverts_title, adverts_briefing, adverts_organisation, adverts_campaign_days, adverts_start_date, adverts_end_date, adverts_url, adverts_video_url, adverts_cover_image, adverts_active_status, adverts_click_count, adverts_created_by, adverts_created_at) 
                VALUES (:xadverts_hashed, :xadverts_type, :xadverts_dimension, :xadverts_category, :xadverts_title, :xadverts_briefing, :xadverts_organisation, :xadverts_campaign_days, :xadverts_start_date, :xadverts_end_date, :xadverts_url, :xadverts_video_url, :xadverts_cover_image, :xadverts_active_status, :xadverts_click_count, :xadverts_created_by, :xadverts_created_at )");
            $result02 = $stmt02->execute(
                array(
                    ':xadverts_hashed' => $adverts_hashed,
                    ':xadverts_type' => $adverts_type,
                    ':xadverts_dimension' => $adverts_dimension,
                    ':xadverts_category' => $adverts_category,
                    ':xadverts_title' => $adverts_title,
                    ':xadverts_briefing' => $adverts_briefing,
                    ':xadverts_organisation' => $adverts_organisation,
                    ':xadverts_campaign_days' => $adverts_campaign_days,
                    ':xadverts_start_date' => $adverts_start_date,
                    ':xadverts_end_date' => $adverts_end_date,
                    ':xadverts_url' => $adverts_url,
                    ':xadverts_video_url' => $adverts_video_url,
                    ':xadverts_cover_image' => $image,
                    ':xadverts_active_status' => $adverts_active_status,
                    ':xadverts_click_count' => $adverts_click_count,
                    ':xadverts_created_by' => $adverts_created_by,
                    ':xadverts_created_at' => $adverts_created_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." added an ad campaign with ID: ".$adverts_hashed;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully added an ad campaign";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and update adv info
    if(isset($_POST['action']) && ($_POST['action'] == "update_adv")) {
        $errorMSG = "";
        $adverts_hashed = $_POST['hidden_hashed'];
        $adverts_type = $_POST['ed_adverts_type'];
        $adverts_dimension = $_POST['ed_adverts_dimension'];
        $adverts_category = $_POST['ed_adverts_category'];
        $adverts_title = $_POST['ed_adverts_title'];
        $adverts_briefing = $_POST['ed_adverts_briefing'];
        $prev_adverts_campaign_days = $_POST['prev_adverts_campaign_days'];
        $adverts_organisation = $_POST['ed_adverts_organisation'];
        $adverts_start_date = $_POST['ed_adverts_start_date'];
        $adverts_end_date = $_POST['ed_adverts_end_date'];
        $adverts_url = $_POST['ed_adverts_url'];
        $adverts_video_url = $_POST['ed_adverts_video_url'];
        $adverts_updated_at = date('Y-m-d H:i:s');

        if ($adverts_title == "") {
            $errorMSG = "Title of advert is required";
        }
        if ($adverts_type == "") {
            $errorMSG = "Select the ad type. Field is required.";
        }
        if ($adverts_category == "") {
            $errorMSG = "Category of ad is required";
        }
        if (isset($_POST['ed_adverts_campaign_days']) == "" && $prev_adverts_campaign_days != "") {
            $adverts_campaign_days = $_POST['prev_adverts_campaign_days'];
        }
        elseif (isset($_POST['ed_adverts_campaign_days']) != "" ) {
            $adverts_campaign_days = implode(",", $_POST['ed_adverts_campaign_days']);
        }
        elseif (isset($_POST['ed_adverts_campaign_days']) == "" && $prev_adverts_campaign_days == "") {
            $errorMSG = "Ad days to display is required";
        }
        if ($adverts_dimension == "") {
            $errorMSG = "Dimension for this ad is required";
        }
        if ($adverts_organisation == "") {
            $errorMSG = "Organisation publishing this ad is required";
        }
        if ($adverts_start_date == "") {
            $errorMSG = "Ad campaign start date is required";
        }
        if ($adverts_end_date == "") {
            $errorMSG = "Ad campaign end date is required";
        }

        // image insert
        $image = '';
        $image_url = UPLOADING_PATH."advsImages/";

        if($_FILES["ed_adverts_cover_image"]["name"] != ''){
            removeImage("adverts_cover_image", $image_url, $adverts_hashed);
            $image = upload_image("ed_adverts_cover_image", $image_url, $adverts_hashed);
        } else{ $image = $_POST['hidden_adverts_cover_image']; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE adverts_posts SET  adverts_type = :xadverts_type, adverts_dimension = :xadverts_dimension, adverts_category = :xadverts_category, adverts_title = :xadverts_title, adverts_briefing = :xadverts_briefing, adverts_organisation = :xadverts_organisation, adverts_campaign_days = :xadverts_campaign_days, adverts_start_date = :xadverts_start_date, adverts_end_date = :xadverts_end_date, adverts_url = :xadverts_url, adverts_video_url = :xadverts_video_url, adverts_cover_image = :xadverts_cover_image, adverts_updated_at = :xadverts_updated_at WHERE adverts_hashed=:xadverts_hashed ");
            $result02 = $stmt02->execute(
                array(
                    ':xadverts_hashed' => $adverts_hashed,
                    ':xadverts_type' => $adverts_type,
                    ':xadverts_dimension' => $adverts_dimension,
                    ':xadverts_category' => $adverts_category,
                    ':xadverts_title' => $adverts_title,
                    ':xadverts_briefing' => $adverts_briefing,
                    ':xadverts_organisation' => $adverts_organisation,
                    ':xadverts_campaign_days' => $adverts_campaign_days,
                    ':xadverts_start_date' => $adverts_start_date,
                    ':xadverts_end_date' => $adverts_end_date,
                    ':xadverts_url' => $adverts_url,
                    ':xadverts_video_url' => $adverts_video_url,
                    ':xadverts_cover_image' => $image,
                    ':xadverts_updated_at' => $adverts_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." edited an ad campaign with ID: ".$adverts_hashed;
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the ad campaign";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and delete adv info
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_adv" && isset($_POST['del_adv_id']) !="") {
        $del_adverts_hashed = $_POST['del_adv_id'];
        $adverts_active_status = 3;
        // fetch file name
        $stmt_select = $db_connect->prepare('SELECT adverts_cover_image FROM adverts_posts WHERE adverts_hashed =:xadverts_hashed');
        $stmt_select->bindParam(':xadverts_hashed',$del_adverts_hashed);
        $stmt_select->execute();
        while($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow  = $del_row['adverts_cover_image'];
        }

        // remove file from directory
        if ($imgRow == "") 
        {
            $stmt_delete = $db_connect->prepare('UPDATE adverts_posts SET adverts_active_status=:xadverts_active_status, adverts_deleted_at=:xadverts_deleted_at WHERE adverts_hashed =:xadverts_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xadverts_hashed' => $del_adverts_hashed,
                    ':xadverts_active_status' => $adverts_active_status,
                    ':xadverts_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        else 
        {       
            if ($imgRow  != "") { unlink(UPLOADING_PATH."advsImages/".$imgRow); }

            $stmt_delete = $db_connect->prepare('UPDATE adverts_posts SET adverts_cover_image="", adverts_active_status=:xadverts_active_status, adverts_deleted_at=:xadverts_deleted_at WHERE adverts_hashed =:xadverts_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xadverts_hashed' => $del_adverts_hashed,
                    ':xadverts_active_status' => $adverts_active_status,
                    ':xadverts_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        // delete file name from database
        

        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted an ad campaign with ID: ".$del_adverts_hashed;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Ad campaign was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Ad campaign could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }
    // Activate and deactivate adv
    if(isset($_POST['action']) && ($_POST['action'] == "activate_adv"))
    {
        $up_adv_id = $_POST['up_adv_id'];
        $up_adverts_active_status     = $_POST['up_adv_active_status'];

        if ($up_adverts_active_status == 1){ $new_adv_active_status = 0; } else { $new_adv_active_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE adverts_posts SET adverts_active_status =:upadverts_active_status, adverts_updated_at=:upadverts_updated_at WHERE adverts_hashed=:upadverts_hashed ");
        $result01 = $stmt01->execute(
            array(
                ':upadverts_hashed'     => $up_adv_id,
                ':upadverts_active_status' => $new_adv_active_status,
                ':upadverts_updated_at'         => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of an ad campaign with ID: ".$up_adv_id;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_adv_active_status == 0) {
                $msg = "The ad campaign was disabled successfully.";
            } else {
                $msg = "The ad campaign was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of the ad campaign could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }

?>