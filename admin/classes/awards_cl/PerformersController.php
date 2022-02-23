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
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM award_performers WHERE awp_hashed =:xawp_hashed");
        $stmt_sel->bindParam(':xawp_hashed',$hash_code);
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

    // check request and get nominee info
    if(isset($_POST['action']) && ($_POST['action'] == "get_performer")) {
        // Get all about nominee
        $hashed_id = $_POST['hashed_id'];
        $stmt=$db_connect->prepare("SELECT * FROM award_performers WHERE awp_hashed='$hashed_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for nominee not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }
    // check request and add performer info
    if(isset($_POST['action']) && ($_POST['action'] == "save_performer")) {
        $errorMSG = "";
        $awp_hashed = generateRandomString(27);
        $awp_year = $_POST['awp_year'];
        $awp_fullname = $_POST['awp_fullname'];
        $awp_description = $_POST['awp_description'];
        $awp_active_status = 1;
        $awp_created_at = date('Y-m-d H:i:s');

        if ($awp_fullname == "") {
            $errorMSG = " Performer name field is required.";
        }
        if ($awp_year == "") {
            $errorMSG = " Performing year field is required.";
        }
        if ($_FILES["awp_image"] == "") {
            $errorMSG = " Performer image field is required.";
        } 

        // image insert
        $image = '';
        $image_url = UPLOADING_PATH."awards/";

        if($_FILES["awp_image"]["name"] != ''){ $image = upload_image("awp_image", $image_url, $awp_hashed); } else{ $image = ""; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("INSERT INTO award_performers (awp_hashed, awp_fullname,awp_year, awp_description, awp_image, awp_active_status, awp_created_at) VALUES (:aawp_hashed, :aawp_fullname,  :aawp_year, :aawp_description, :aawp_image, :aawp_active_status, :aawp_created_at)");
            $result02 = $stmt02->execute(
                array(
                    ':aawp_hashed' => $awp_hashed,
                    ':aawp_fullname' => $awp_fullname,
                    ':aawp_year' => $awp_year,
                    ':aawp_description' => $awp_description,
                    ':aawp_image' => $image,
                    ':aawp_active_status' => $awp_active_status,
                    ':aawp_created_at' => $awp_created_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." added performer with ID: ".$awp_hashed;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully added a performer";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and update nominee info
    if(isset($_POST['action']) && ($_POST['action'] == "update_performer")) {
        $errorMSG = "";
        $awp_hashed = $_POST['hidden_hashed'];
        $awp_year = $_POST['ed_awp_year'];
        $awp_fullname = $_POST['ed_awp_fullname'];
        $awp_description = $_POST['ed_awp_description'];
        $hidden_awp_image = $_POST['hidden_awp_image'];
        $awp_active_status = 1;
        $awp_updated_at = date('Y-m-d H:i:s');

        if ($awp_fullname == "") {
            $errorMSG = " Performer name field is required.";
        }  
        if ($awp_year == "") {
            $errorMSG = " Performing year field is required.";
        } 
        if ($_FILES["ed_awp_image"]["name"] == "" && $_POST['hidden_awp_image']=="") {
            $errorMSG = " Performer image field is required.";
        } 

        // image insert
        $image = '';
        $image_url = UPLOADING_PATH."awards/";

        if($_FILES["ed_awp_image"]["name"] != ''){
            removeImage("awp_image", $image_url, $awp_hashed);
            $image = upload_image("ed_awp_image", $image_url, $awp_hashed);
        } else{ $image = $_POST['hidden_awp_image']; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE award_performers SET 
            awp_fullname=:aawp_fullname, awp_year=:aawp_year, awp_description=:aawp_description, awp_image=:aawp_image, awp_active_status=:aawp_active_status, awp_updated_at=:aawp_updated_at WHERE awp_hashed=:aawp_hashed ");
            $result02 = $stmt02->execute(
                array(
                    ':aawp_hashed' => $awp_hashed,
                    ':aawp_fullname' => $awp_fullname,
                    ':aawp_year' => $awp_year,
                    ':aawp_description' => $awp_description,
                    ':aawp_image' => $image,
                    ':aawp_active_status' => $awp_active_status,
                    ':aawp_updated_at' => $awp_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." edited performer with ID: ".$awp_hashed;
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the performer";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and delete performer info
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_performer" && isset($_POST['del_awp_id']) !="") {
        $del_awp_hashed = $_POST['del_awp_id'];
        $awp_active_status = 3;
        // fetch file name
        $stmt_select = $db_connect->prepare('SELECT awp_image FROM award_performers WHERE awp_hashed =:xawp_hashed');
        $stmt_select->bindParam(':xawp_hashed',$del_awp_hashed);
        $stmt_select->execute();
        while($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow  = $del_row['awp_image'];
        }

        // remove file from directory
        if ($imgRow == "") 
        {
            $stmt_delete = $db_connect->prepare('UPDATE award_performers SET awp_active_status=:xawp_active_status, awp_deleted_at=:xawp_deleted_at WHERE awp_hashed =:xawp_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xawp_hashed' => $del_awp_hashed,
                    ':xawp_active_status' => $awp_active_status,
                    ':xawp_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        else 
        {       
            if ($imgRow  != "") { unlink(UPLOADING_PATH."awards/".$imgRow); }
            $stmt_delete = $db_connect->prepare('UPDATE award_performers SET awp_image="", awp_active_status=:xawp_active_status, awp_deleted_at=:xawp_deleted_at WHERE awp_hashed =:xawp_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xawp_hashed' => $del_awp_hashed,
                    ':xawp_active_status' => $awp_active_status,
                    ':xawp_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        // delete file name from database

        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted performer with ID: ".$del_awp_hashed;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Performer was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Performer could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }
    // Activate and deactivate performer
    if(isset($_POST['action']) && ($_POST['action'] == "activate_performer"))
    {
        $up_awp_id = $_POST['up_awp_id'];
        $up_awp_active_status     = $_POST['up_awp_active_status'];

        if ($up_awp_active_status == 1){ $new_awp_active_status = 0; } else { $new_awp_active_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE award_performers SET awp_active_status =:upawp_active_status, awp_updated_at=:upupdated_at WHERE awp_hashed=:upawp_hashed ");
        $result01 = $stmt01->execute(
            array(
                ':upawp_hashed'     => $up_awp_id,
                ':upawp_active_status' => $new_awp_active_status,
                ':upupdated_at'    => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a performer with ID: ".$up_awp_id;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_awp_active_status == 0) {
                $msg = "The performer was disabled successfully.";
            } else {
                $msg = "The performer was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of the performer could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }

?>