<?php
    
    // include Database connection file
    require_once("../../resources/auth.inc.php");

    // Activate and deactivate contact
    if(isset($_POST['action']) && ($_POST['action'] == "activate_contact"))
    {
        $up_con_id = $_POST['up_con_id'];
        $up_con_active_status = $_POST['up_con_active_status'];
        if ($up_con_active_status == "1") {
            $new_con_active_status = 0;
        } else {
            $new_con_active_status = 1;
        }

        $stmt01 =  $db_connect->prepare("  
        UPDATE contacts SET con_active_status =:upcon_active_status, con_updated_at =:upcon_updated_at WHERE con_id=:upcon_id ");
        $result01 = $stmt01->execute(
            array(
                ':upcon_id' => $up_con_id,
                ':upcon_active_status' => $new_con_active_status,
                ':upcon_updated_at' => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a contact with ID: ".$up_con_id;
            $act_status = "status";
            log_history($neo_user_code, $action, $act_status);

            $msg = "The status of this contact message was successfully changed";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of this contact message could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }


    // Delete contact
    if(isset($_POST['action']) && ($_POST['action'] == "delete_contact")) {

        $del_con_id = $_POST['del_con_id'];
        $stmt_con_delete = $db_connect->prepare("UPDATE contacts SET con_active_status=3, con_deleted_at=:del_con_deleted_at WHERE con_id =:delid");
        $success_con_delete = $stmt_con_delete->execute(
            array(
                ':delid' => $del_con_id,
                ':del_con_deleted_at' => date('Y-m-d H:i:s')
            )
        );

        if($success_con_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted a contact with ID: ".$del_con_id;
            $act_status = "status";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Contact message was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Contact message could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }


?>