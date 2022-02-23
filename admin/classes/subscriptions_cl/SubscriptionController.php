<?php
    
    // include Database connection file
    require_once("../../resources/auth.inc.php");

    // Activate and deactivate subscription
    if(isset($_POST['action']) && ($_POST['action'] == "activate_subscription"))
    {
        $up_subs_id = $_POST['up_subs_id'];
        $up_subs_active_status = $_POST['up_subs_active_status'];
        if ($up_subs_active_status == "1") {
            $new_subs_active_status = 0;
        } else {
            $new_subs_active_status = 1;
        }

        $stmt01 =  $db_connect->prepare("  
        UPDATE subscriptions SET subs_active_status =:upsubs_active_status, subs_updated_at =:upsubs_updated_at WHERE subs_id=:upsubs_id ");
        $result01 = $stmt01->execute(
            array(
                ':upsubs_id' => $up_subs_id,
                ':upsubs_active_status' => $new_subs_active_status,
                ':upsubs_updated_at' => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a subscription with ID: ".$up_subs_id;
            $act_status = "status";
            log_history($neo_user_code, $action, $act_status);

            $msg = "The status of this subscription message was successfully changed";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of this subscription message could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }
    // Delete subscription
    if(isset($_POST['action']) && ($_POST['action'] == "delete_subscription")) {

        $del_subs_id = $_POST['del_subs_id'];
        $stmt_subs_delete = $db_connect->prepare("UPDATE subscriptions SET subs_active_status=3, subs_deleted_at=:del_subs_deleted_at WHERE subs_id =:delid");
        $success_subs_delete = $stmt_subs_delete->execute(
            array(
                ':delid' => $del_subs_id,
                ':del_subs_deleted_at' => date('Y-m-d H:i:s')
            )
        );

        if($success_subs_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted a subscription with ID: ".$del_subs_id;
            $act_status = "status";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Subscription was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Subscription could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }

?>