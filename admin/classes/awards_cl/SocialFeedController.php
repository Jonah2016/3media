<?php
    // include Database connection file
    require_once("../../resources/auth.inc.php");

    // check request and get social media feed info
    if(isset($_POST['action']) && ($_POST['action'] == "get_social_feedback")) {
        // Get all about social media feed
        $awsoc_id = $_POST['awsoc_id'];
        $stmt=$db_connect->prepare("SELECT * FROM award_social_feed WHERE awsoc_id='$awsoc_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for social media feed not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }
    // check request and add social media feed info
    if(isset($_POST['action']) && ($_POST['action'] == "save_social_feedback")) {
        $errorMSG = "";
        $awsoc_type = $_POST['awsoc_type'];
        $awsoc_url = $_POST['awsoc_url']; 
        $awsoc_created_at = date('Y-m-d H:i:s');

        if ($awsoc_type == "") {
            $errorMSG = " Social media feed type field is required.";
        } 
        if ($awsoc_url == "") {
            $errorMSG = " Social media feed url field is required.";
        }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("INSERT INTO award_social_feed (awsoc_type, awsoc_url, awsoc_created_at) VALUES (:aawsoc_type, :aawsoc_url, :aawsoc_created_at)");
            $result02 = $stmt02->execute(
                array(
                    ':aawsoc_type' => $awsoc_type,
                    ':aawsoc_url' => $awsoc_url,
                    ':aawsoc_created_at' => $awsoc_created_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." added an social media feed with a uRL: ".$awsoc_url;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully added a social media feed";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and update social media feed info
    if(isset($_POST['action']) && ($_POST['action'] == "update_social_feedback")) {
        $errorMSG = "";
        $awsoc_id = $_POST['hidden_id'];
        $awsoc_type = $_POST['ed_awsoc_type'];
        $awsoc_url = $_POST['ed_awsoc_url'];
        $awsoc_updated_at = date('Y-m-d H:i:s');

        if ($awsoc_type == "") {
            $errorMSG = " social media feed type field is required.";
        } 
        if ($awsoc_url == "") {
            $errorMSG = " social media feed url field is required.";
        }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE award_social_feed SET 
            awsoc_type=:aawsoc_type, awsoc_url=:aawsoc_url, awsoc_updated_at=:aawsoc_updated_at WHERE awsoc_id=:aawsoc_id ");
            $result02 = $stmt02->execute(
                array(
                    ':aawsoc_id' => $awsoc_id,
                    ':aawsoc_type' => $awsoc_type,
                    ':aawsoc_url' => $awsoc_url,
                    ':aawsoc_updated_at' => $awsoc_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." edited a social media feed with ID: ".$awsoc_id;
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
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_award_category" && isset($_POST['del_awsoc_id']) !="") {
        $del_awsoc_id = $_POST['del_awsoc_id'];
        $stmt_delete = $db_connect->prepare('DELETE FROM award_social_feed WHERE awsoc_id =:xawsoc_id');
        $success_delete = $stmt_delete->execute(array(':xawsoc_id' => $del_awsoc_id));
        // delete file name from database
        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted a social media feed with ID: ".$del_awsoc_id;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Social media feed was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Social media feed could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }


?>