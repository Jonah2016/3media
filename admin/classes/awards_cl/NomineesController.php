<?php
    // include Database connection file
    require_once("../../resources/auth.inc.php");
    
    function generateRandomString1($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

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
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM award_nominees WHERE awn_hashed =:xawn_hashed");
        $stmt_sel->bindParam(':xawn_hashed',$hash_code);
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
    if(isset($_POST['action']) && ($_POST['action'] == "get_nominee")) {
        // Get all about nominee
        $hashed_id = $_POST['hashed_id'];
        $stmt=$db_connect->prepare("SELECT * FROM award_nominees WHERE awn_hashed='$hashed_id' ");
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
    // check request and add nominee info
    if(isset($_POST['action']) && ($_POST['action'] == "save_nominee")) {
        $errorMSG = "";
        $awn_hashed = generateRandomString1(27);
        $awn_category = $_POST['awn_category'];
        $awn_type = $_POST['awn_type'];
        $awn_year = $_POST['awn_year'];
        $awn_biography = $_POST['awn_biography'];
        $awn_win_status = 0;
        $awn_active_status = 1;
        $awn_created_at = date('Y-m-d H:i:s');

        if ($awn_category == "") {
            $errorMSG = " Nomination category field is required.";
        }
        if ($awn_type == "") {
            $errorMSG = " Nomination type field is required.";
        } 
        if ($awn_type == "single" && $_POST['awn_fullname_one'] == "") {
            $errorMSG = " Nominee name field is required.";
        }
        if ($awn_type == "group" && $_POST['awn_fullname_two'] == "") {
            $errorMSG = " Nominees names field is required.";
        } 
        if ($awn_year == "") {
            $errorMSG = " Nomination year field is required.";
        }
        if ($_FILES["awn_cover_image"] == "") {
            $errorMSG = " Nominee image field is required.";
        } 

        if ($awn_type == "single" && $_POST['awn_fullname_one'] != "") {
            $awn_fullname = $_POST['awn_fullname_one'];
        } else if ($awn_type == "group" && $_POST['awn_fullname_two'] != "") {
            $awn_fullname = $_POST['awn_fullname_two'];
        }

        // image insert
        $image = '';
        $image_url = UPLOADING_PATH."awards/";

        if($_FILES["awn_cover_image"]["name"] != ''){ $image = upload_image("awn_cover_image", $image_url, $awn_hashed); } else{ $image = ""; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("INSERT INTO award_nominees (awn_hashed, awn_category, awn_fullname, awn_type, awn_year, awn_biography, awn_win_status, awn_cover_image, awn_active_status, awn_created_at) VALUES (:aawn_hashed, :aawn_category, :aawn_fullname, :aawn_type, :aawn_year, :aawn_biography, :aawn_win_status, :aawn_cover_image, :aawn_active_status, :aawn_created_at)");
            $result02 = $stmt02->execute(
                array(
                    ':aawn_hashed' => $awn_hashed,
                    ':aawn_category' => $awn_category,
                    ':aawn_fullname' => $awn_fullname,
                    ':aawn_type' => $awn_type,
                    ':aawn_year' => $awn_year,
                    ':aawn_biography' => $awn_biography,
                    ':aawn_win_status' => $awn_win_status,
                    ':aawn_cover_image' => $image,
                    ':aawn_active_status' => $awn_active_status,
                    ':aawn_created_at' => $awn_created_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." added nominee with ID: ".$awn_hashed;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully added a nominee";
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
    if(isset($_POST['action']) && ($_POST['action'] == "update_nominee")) {
        $errorMSG = "";
        $awn_hashed = $_POST['hidden_hashed'];
        $awn_category = $_POST['ed_awn_category'];
        $awn_type = $_POST['ed_awn_type'];
        $awn_year = $_POST['ed_awn_year'];
        $awn_biography = $_POST['ed_awn_biography'];
        $hidden_awn_cover_image = $_POST['hidden_awn_cover_image'];
        $awn_updated_at = date('Y-m-d H:i:s');

        if ($awn_category == "") {
            $errorMSG = " Nomination category field is required.";
        } 
        if ($awn_type == "") {
            $errorMSG = " Nomination type field is required.";
        } 
        if ($awn_type == "single" && $_POST['ed_awn_fullname_one'] == "") {
            $errorMSG = " Nominee name field is required.";
        }
        if ($awn_type == "group" && $_POST['ed_awn_fullname_two'] == "") {
            $errorMSG = " Nominees names field is required.";
        } 
        if ($awn_year == "") {
            $errorMSG = " Nomination year field is required.";
        } 
        if ($_FILES["ed_awn_cover_image"]["name"] == "" && $_POST['hidden_awn_cover_image']=="") {
            $errorMSG = " Nominee image field is required.";
        } 

        if ($awn_type == "single" && $_POST['ed_awn_fullname_one'] != "") {
            $awn_fullname = $_POST['ed_awn_fullname_one'];
        } else if ($awn_type == "group" && $_POST['ed_awn_fullname_two'] != "") {
            $awn_fullname = $_POST['ed_awn_fullname_two'];
        }

        // image insert
        $image = '';
        $image_url = UPLOADING_PATH."awards/";

        if($_FILES["ed_awn_cover_image"]["name"] != ''){
            removeImage("awn_cover_image", $image_url, $awn_hashed);
            $image = upload_image("ed_awn_cover_image", $image_url, $awn_hashed);
        } else{ $image = $_POST['hidden_awn_cover_image']; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE award_nominees SET 
            awn_category=:aawn_category, awn_fullname=:aawn_fullname, awn_type=:aawn_type, awn_year=:aawn_year, awn_biography=:aawn_biography, awn_cover_image=:aawn_cover_image, awn_updated_at=:aawn_updated_at WHERE awn_hashed=:aawn_hashed ");
            $result02 = $stmt02->execute(
                array(
                    ':aawn_hashed' => $awn_hashed,
                    ':aawn_category' => $awn_category,
                    ':aawn_fullname' => $awn_fullname,
                    ':aawn_type' => $awn_type,
                    ':aawn_year' => $awn_year,
                    ':aawn_biography' => $awn_biography,
                    ':aawn_cover_image' => $image,
                    ':aawn_updated_at' => $awn_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." edited nominee with ID: ".$awn_hashed;
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the nominee";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and delete nominee info
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_nominee" && isset($_POST['del_awn_id']) !="") {
        $del_awn_hashed = $_POST['del_awn_id'];
        $awn_active_status = 3;
        // fetch file name
        $stmt_select = $db_connect->prepare('SELECT awn_cover_image FROM award_nominees WHERE awn_hashed =:xawn_hashed');
        $stmt_select->bindParam(':xawn_hashed',$del_awn_hashed);
        $stmt_select->execute();
        while($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow  = $del_row['awn_cover_image'];
        }

        // remove file from directory
        if ($imgRow == "") 
        {
            $stmt_delete = $db_connect->prepare('UPDATE award_nominees SET awn_active_status=:xawn_active_status, awn_deleted_at=:xawn_deleted_at WHERE awn_hashed =:xawn_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xawn_hashed' => $del_awn_hashed,
                    ':xawn_active_status' => $awn_active_status,
                    ':xawn_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        else 
        {       
            if ($imgRow  != "") { unlink(UPLOADING_PATH."awards/".$imgRow); }
            $stmt_delete = $db_connect->prepare('UPDATE award_nominees SET awn_cover_image="", awn_active_status=:xawn_active_status, awn_deleted_at=:xawn_deleted_at WHERE awn_hashed =:xawn_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xawn_hashed' => $del_awn_hashed,
                    ':xawn_active_status' => $awn_active_status,
                    ':xawn_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        // delete file name from database

        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted nominee with ID: ".$del_awn_hashed;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Nominee was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Nominee could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }
    // Activate and deactivate nominee
    if(isset($_POST['action']) && ($_POST['action'] == "activate_nominee"))
    {
        $up_awn_id = $_POST['up_awn_id'];
        $up_awn_active_status     = $_POST['up_awn_active_status'];

        if ($up_awn_active_status == 1){ $new_awn_active_status = 0; } else { $new_awn_active_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE award_nominees SET awn_active_status =:upawn_active_status, awn_updated_at=:upupdated_at WHERE awn_hashed=:upawn_hashed ");
        $result01 = $stmt01->execute(
            array(
                ':upawn_hashed'     => $up_awn_id,
                ':upawn_active_status' => $new_awn_active_status,
                ':upupdated_at'         => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a nominee with ID: ".$up_awn_id;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_awn_active_status == 0) {
                $msg = "The nominee was disabled successfully.";
            } else {
                $msg = "The nominee was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of the nominee could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }
    // Enable or disable winner
    if(isset($_POST['action']) && ($_POST['action'] == "activate_winner"))
    {
        $up_awn_id = $_POST['up_awn_id'];
        $up_awn_win_status     = $_POST['up_awn_win_status'];

        if ($up_awn_win_status == 1){ $new_awn_win_status = 0; } else { $new_awn_win_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE award_nominees SET awn_win_status =:upawn_win_status, awn_updated_at=:upupdated_at WHERE awn_hashed=:upawn_hashed ");
        $result01 = $stmt01->execute(
            array(
                ':upawn_hashed'     => $up_awn_id,
                ':upawn_win_status' => $new_awn_win_status,
                ':upupdated_at'         => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the win status of a nominee with ID: ".$up_awn_id;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_awn_win_status == 0) {
                $msg = "The nominee winner status was reversed successfully.";
            } else {
                $msg = "The nominee winner status was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The winner status of the nominee could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }

?>