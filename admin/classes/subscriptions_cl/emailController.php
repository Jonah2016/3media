<?php
    // include Database connection file
    require_once("../../resources/auth.inc.php");


    // check request and get email draft info
    if(isset($_POST['action']) && ($_POST['action'] == "get_draft")) {
        // Get all about email draft
        $ed_id = $_POST['ed_id'];
        $stmt=$db_connect->prepare("SELECT * FROM email_drafts WHERE ed_id='$ed_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for email draft not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }


    // check request and save draft info
    if(isset($_POST['action']) && $_POST['action'] == "save_draft") {
        $errorMSG = "";
        $ed_title = $_POST['ed_title'];
        $ed_body = $_POST['ed_body'];
        $ed_active_status = 1;
        $ed_created_by = $neo_user_code;
        $ed_created_at = date('Y-m-d H:i:s');

        if ($ed_title == '') {
            $errorMSG = "Subject of the email is required.";
        }
        if (strlen($ed_title) < 5) {
            $errorMSG = "Subject of the email should be more than 5 characters.";
        }
        if ($ed_body == '') {
            $errorMSG = "Body of the email is required.";
        }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("INSERT INTO email_drafts (ed_title, ed_body, ed_active_status, ed_created_by, ed_created_at) VALUES (:xed_title, :xed_body, :xed_active_status, :xed_created_by, :xed_created_at)");
            $result02 = $stmt02->execute(
                array(
                    ':xed_title' => $ed_title,
                    ':xed_body' => $ed_body,
                    ':xed_active_status' => $ed_active_status,
                    ':xed_created_by' => $ed_created_by,
                    ':xed_created_at' => $ed_created_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." added an email draft with title: ".$ed_title;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully save an email draft";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }

    // check request and send draft info
    if(isset($_POST['action']) && $_POST['action'] == "send_draft" ) {
        $errorMSG = "";
        $ed_title = $_POST['ed_title'];
        $ed_body = htmlspecialchars($_POST['ed_body']);
        $ed_created_by = $neo_user_code;

        if ($ed_title == '') {
            $errorMSG = "Subject of the email is required.";
        }
        if (strlen($ed_title) < 5) {
            $errorMSG = "Subject of the email should be more than 5 characters.";
        }
        if ($ed_body == '') {
            $errorMSG = "Body of the email is required.";
        }

        // Execute Query
        if(empty($errorMSG))
        { 
            // Select subscription
            $subscriber_email_array = [];
            $sql=$db_connect->prepare("SELECT subs_email FROM subscriptions WHERE subs_active_status=1 ");
            $sql->execute();
            if($sql->rowCount() > 0)
            {
                while($qry_row=$sql->fetch(PDO::FETCH_ASSOC)) {
                    $email_address = $qry_row['subs_email'];
                    array_push($subscriber_email_array, ['email'=> $email_address]);
                }
            }

            if(!empty($subscriber_email_array))
            {
                $counter = 0;
                foreach ($subscriber_email_array as $sub_info) {
                    //Set email server parameters
                    ini_set('SMTP','smtp.secureserver.net');
                    ini_set("SMTP","3music.tv");
                    ini_set("smtp_port","465");
                    ini_set("sendmail_from", 'shout@3music.tv'); 

                    $count = $counter++;

                    $to = $sub_info['email'];
                    $subject = $ed_title;
                    // Sender 
                    $from = 'shout@3music.tv'; 
                    $fromName = '3Music Networks';          
                    // Email body content 
                    $message = $ed_body;
                    // Header parameters
                    $header = "From: shout@3music.tv \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    // Send email 
                    try {
                        $sendMail = mail ($to,$subject,$message,$header);
                        $mail_success = 1; 
                    } catch (Exception $e) {
                        $mail_success = 0;  
                    }
                    if($sendMail == true) {$mail_success = 1;} else { $mail_success = 0; }
                }
            }
            else{
                $mail_success = 0;
            }

            if($mail_success == 0) {
                $errorMSG = "Error! Bulk email was not successfully sent. ";
                echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
                exit;
            } else {
                // Record activity history
                $action = $user_full_name." sent a bulk email with title: ".$ed_title;
                $act_status = "send";
                log_history($neo_user_code, $action, $act_status);

                $msg = "The bulk email was sent successfully";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }    
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }

    // check request and send draft info
    if(isset($_POST['action']) && $_POST['action'] == "save_send_draft") {
        $errorMSG = "";
        $ed_title = $_POST['ed_title'];
        $ed_body = htmlspecialchars($_POST['ed_body']);
        $ed_body1 = $_POST['ed_body'];
        $ed_active_status = 1;
        $ed_created_by = $neo_user_code;
        $ed_created_at = date('Y-m-d H:i:s');

        if ($ed_title == '') {
            $errorMSG = "Subject of the email is required.";
        }
        if (strlen($ed_title) < 5) {
            $errorMSG = "Subject of the email should be more than 5 characters.";
        }
        if ($ed_body == '') {
            $errorMSG = "Body of the email is required.";
        }

        // Execute Query
        if(empty($errorMSG))
        {
            // Save draft 
            $stmt02 = $db_connect->prepare("INSERT INTO email_drafts (ed_title, ed_body, ed_active_status, ed_created_by, ed_created_at) VALUES (:xed_title, :xed_body, :xed_active_status, :xed_created_by, :xed_created_at)");
            $result02 = $stmt02->execute(
                array(
                    ':xed_title' => $ed_title,
                    ':xed_body' => $ed_body1,
                    ':xed_active_status' => $ed_active_status,
                    ':xed_created_by' => $ed_created_by,
                    ':xed_created_at' => $ed_created_at
                )
            );

            // Select subscription
            $subscriber_email_array = [];
            $sql=$db_connect->prepare("SELECT subs_email FROM subscriptions WHERE subs_active_status=1 ");
            $sql->execute();
            if($sql->rowCount() > 0)
            {
                while($qry_row=$sql->fetch(PDO::FETCH_ASSOC)) {
                    $email_address = $qry_row['subs_email'];
                    array_push($subscriber_email_array, ['email'=> $email_address]);
                }
            }

            if(!empty($subscriber_email_array))
            {
                $counter = 0;
                foreach ($subscriber_email_array as $sub_info) {
                    //Set email server parameters
                    ini_set('SMTP','smtp.secureserver.net');
                    ini_set("SMTP","3music.tv");
                    ini_set("smtp_port","465");
                    ini_set("sendmail_from", 'shout@3music.tv'); 
                    
                    $count = $counter++;

                    $to = $sub_info['email'];
                    $subject = $ed_title;
                    // Sender 
                    $from = 'shout@3music.tv'; 
                    $fromName = '3Music Networks';          
                    // Email body content 
                    $message = $ed_body;
                    // Header parameters
                    $header = "From: shout@3music.tv \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    // Send email 
                    try {
                        $sendMail = mail ($to,$subject,$message,$header);
                        $mail_success = 1; 
                    } catch (Exception $e) {
                        $mail_success = 0;  
                    }
                    if($sendMail == true) {$mail_success = 1;} else { $mail_success = 0; }
                }
            }
            else{
                $mail_success = 0;
            }

            if(empty($result02) && $mail_success == 0) {
                $errorMSG = "Error! Bulk email was not successfully sent. ";
                echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
                exit;
            } else {
                // Record activity history
                $action = $user_full_name." sent a bulk email with title: ".$ed_title;
                $act_status = "send";
                log_history($neo_user_code, $action, $act_status);

                $msg = "The bulk email was sent successfully";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }    
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }


    // check request and update draft info
    if(isset($_POST['action']) && ($_POST['action'] == "update_draft")) {
        $errorMSG = "";
        $ed_title = $_POST['ed_title'];
        $ed_body = $_POST['ed_body'];
        $ed_active_status = 1;
        $ed_updated_at = date('Y-m-d H:i:s');

        if ($ed_title == '') {
            $errorMSG = "Subject of the email is required.";
        }
        if (strlen($ed_title) < 5) {
            $errorMSG = "Subject of the email should be more than 5 characters.";
        }
        if ($ed_body == '') {
            $errorMSG = "Body of the email is required.";
        }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE email_drafts SET 
            ed_title=:xed_title, ed_body=:xed_body, ed_active_status=:xed_active_status, ed_updated_at=:xed_updated_at WHERE ed_id=:xed_id ");
            $result02 = $stmt02->execute(
                array(
                    ':xed_id' => $ed_id,
                    ':xed_title' => $ed_title,
                    ':xed_body' => $ed_body,
                    ':xed_active_status' => $ed_active_status,
                    ':xed_updated_at' => $ed_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." edited an email draft with ID: ".$ed_id;
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated an email draft";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and delete draft info
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_draft" && isset($_POST['del_ed_id']) !="") {
        $del_ed_id = $_POST['del_ed_id'];
        $ed_active_status = 3;

        $stmt_delete = $db_connect->prepare('UPDATE email_drafts SET ed_active_status=:xed_active_status, ed_deleted_at=:xed_deleted_at WHERE ed_id =:xed_id');
        $success_delete = $stmt_delete->execute(
            array(
                ':xed_id' => $del_ed_id,
                ':xed_active_status' => $ed_active_status,
                ':xed_deleted_at' => date('Y-m-d H:i:s')
            )
        );
        
        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted an email draft with ID: ".$del_ed_id;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Draft was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Draft could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }


    // Activate and deactivate draft
    if(isset($_POST['action']) && ($_POST['action'] == "activate_draft"))
    {
        $up_ed_id = $_POST['up_ed_id'];
        $up_ed_active_status = $_POST['up_ed_active_status'];
        if ($up_ed_active_status == 1) {
            $new_ed_active_status = 0;
        } else {
            $new_ed_active_status = 1;
        }

        $stmt01 =  $db_connect->prepare("  
        UPDATE email_drafts SET ed_active_status =:uped_active_status, ed_updated_at =:uped_updated_at WHERE ed_id=:uped_id ");
        $result01 = $stmt01->execute(
            array(
                ':uped_id' => $up_ed_id,
                ':uped_active_status' => $new_ed_active_status,
                ':uped_updated_at' => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a draft with ID: ".$up_ed_id;
            $act_status = "status";
            log_history($neo_user_code, $action, $act_status);

            $msg = "The status of this draft message was successfully changed";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of this draft message could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }


?>