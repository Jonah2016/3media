<?php
    
    require_once("../../resources/auth.inc.php");

    // Upload image 
    function upload_image($field, $url)
    {
        if(isset($_FILES[$field])) {
            $extension = explode('.', $_FILES[$field]['name']);
            $new_name = rand(100,1000).date('Y') . '.' . $extension[1];
            $destination = $url . $new_name;
            move_uploaded_file($_FILES[$field]['tmp_name'], $destination);
            return $new_name;
        }
    }
    // Remove image 
    function removeImage($field, $url, $sett_id)
    {
        // fetch file name
        include("../../resources/connect.inc.php");
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM general_settings WHERE sett_id=:xsett_id");
        $stmt_sel->bindParam(':xsett_id',$sett_id);
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



    // check request and get settings info
    if(isset($_POST['action']) && ($_POST['action'] == "get_settings")) {
        // Get all about general_settings
        $sett_id = $_POST['sett_id'];
        $stmt=$db_connect->prepare("SELECT * FROM general_settings WHERE sett_id='$sett_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for general settings not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }

    // check request and update settings info
    if(isset($_POST['action']) && ($_POST['action'] == "save_settings")) {
        $errorMSG = "";
        $sett_id = 2065;
        $sett_site_name = $_POST['sett_site_name'];
        $sett_site_tagline = $_POST['sett_site_tagline'];
        $sett_site_address = $_POST['sett_site_address'];
        $sett_site_phone1 = $_POST['sett_site_phone1'];
        $sett_site_phone2 = $_POST['sett_site_phone2'];
        $sett_site_phone3 = $_POST['sett_site_phone3'];
        $sett_site_email = $_POST['sett_site_email'];
        $sett_voting_opened = $_POST['sett_voting_opened'];
        $sett_mail_server = $_POST['sett_mail_server'];
        $sett_mail_passwod = $_POST['sett_mail_passwod'];
        $sett_mail_address = $_POST['sett_mail_address'];
        $sett_mail_port = $_POST['sett_mail_port'];
        $sett_sms_api = $_POST['sett_sms_api'];
        $sett_sms_api_number = $_POST['sett_sms_api_number'];
        $sett_sms_api_key = $_POST['sett_sms_api_key'];
        $sett_sms_api_auth = $_POST['sett_sms_api_auth'];
        $sett_site_fb = $_POST['sett_site_fb'];
        $sett_site_twitter = $_POST['sett_site_twitter'];
        $sett_site_instagram = $_POST['sett_site_instagram'];
        $sett_site_youtube = $_POST['sett_site_youtube'];
        $sett_site_linkedin = $_POST['sett_site_linkedin'];
        $sett_site_vimeo = $_POST['sett_site_vimeo'];
        $sett_site_tiktok = $_POST['sett_site_tiktok'];
        $sett_site_soundcloud = $_POST['sett_site_soundcloud'];
        $sett_updated_at = date('Y-m-d H:i:s');

        if (empty($sett_site_name )) {
           $errorMSG = "Site name field is required.";
        }
        if (empty($sett_site_address)) {
           $errorMSG = "Site address field is required.";
        }
        if (empty($sett_site_phone1)) {
           $errorMSG = "Active contact number field is required.";
        }
        if (empty($sett_site_email)) {
           $errorMSG = "Site email field is required.";
        }

        // image insert
        $original_logo = '';
        $black_logo = '';
        $white_logo = '';
        $image_url = UPLOADING_PATH."system/";
        if(!empty($_FILES["sett_logo_colored"]['name'])) {
            removeImage("sett_logo_colored", $image_url, $sett_id);
            $original_logo = upload_image("sett_logo_colored", $image_url);
        } else{
            $original_logo = $_POST['hid_sett_logo_colored'];
        }
        if(!empty($_FILES["sett_logo_black"]['name'])) {
            removeImage("sett_logo_black", $image_url, $sett_id);
            $black_logo = upload_image("sett_logo_black", $image_url);
        } else{
            $black_logo = $_POST['hid_sett_logo_black'];
        } 
        if(!empty($_FILES["sett_logo_white"]['name'])) {
            removeImage("sett_logo_white", $image_url, $sett_id);
            $white_logo = upload_image("sett_logo_white", $image_url);
        } else{
            $white_logo = $_POST['hid_sett_logo_white'];
        }
        if(!empty($_FILES["sett_season_banner"]['name'])) {
            removeImage("sett_season_banner", $image_url, $sett_id);
            $season_banner = upload_image("sett_season_banner", $image_url);
        } else{
            $season_banner = $_POST['hid_sett_season_banner'];
        }


        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE general_settings SET sett_site_name=:xsett_site_name, sett_site_tagline=:xsett_site_tagline, sett_site_address=:xsett_site_address, sett_site_phone1=:xsett_site_phone1, sett_site_phone2=:xsett_site_phone2, sett_site_phone3=:xsett_site_phone3, sett_site_email=:xsett_site_email, sett_voting_opened=:xsett_voting_opened, sett_mail_server=:xsett_mail_server, sett_mail_passwod=:xsett_mail_passwod, sett_mail_address=:xsett_mail_address, sett_mail_port=:xsett_mail_port, sett_sms_api=:xsett_sms_api, sett_sms_api_number=:xsett_sms_api_number, sett_sms_api_key=:xsett_sms_api_key, sett_sms_api_auth=:xsett_sms_api_auth, sett_site_fb=:xsett_site_fb, sett_site_twitter=:xsett_site_twitter, sett_site_instagram=:xsett_site_instagram, sett_site_youtube=:xsett_site_youtube, sett_site_linkedin=:xsett_site_linkedin, sett_site_vimeo=:xsett_site_vimeo, sett_site_tiktok=:xsett_site_tiktok,  sett_site_soundcloud=:xsett_site_soundcloud, sett_logo_colored=:xsett_logo_colored, sett_logo_black=:xsett_logo_black, sett_logo_white=:xsett_logo_white, sett_season_banner=:xsett_season_banner, sett_updated_at =:xsett_updated_at
            WHERE sett_id=:xsett_id ");
            $result02 = $stmt02->execute(
                array(
                    ':xsett_id' => $sett_id,
                    ':xsett_site_name' => $sett_site_name,
                    ':xsett_site_tagline' => $sett_site_tagline,
                    ':xsett_site_address' => $sett_site_address,
                    ':xsett_site_phone1' => $sett_site_phone1,
                    ':xsett_site_phone2' => $sett_site_phone2,
                    ':xsett_site_phone3' => $sett_site_phone3,
                    ':xsett_site_email' => $sett_site_email,
                    ':xsett_voting_opened' => $sett_voting_opened,
                    ':xsett_mail_server' => $sett_mail_server,
                    ':xsett_mail_passwod' => $sett_mail_passwod,
                    ':xsett_mail_address' => $sett_mail_address,
                    ':xsett_mail_port' => $sett_mail_port,
                    ':xsett_sms_api' => $sett_sms_api,
                    ':xsett_sms_api_number' => $sett_sms_api_number,
                    ':xsett_sms_api_key' => $sett_sms_api_key,
                    ':xsett_sms_api_auth' => $sett_sms_api_auth,
                    ':xsett_site_fb' => $sett_site_fb,
                    ':xsett_site_twitter' => $sett_site_twitter,
                    ':xsett_site_instagram' => $sett_site_instagram,
                    ':xsett_site_youtube' => $sett_site_youtube,
                    ':xsett_site_linkedin' => $sett_site_linkedin,
                    ':xsett_site_vimeo' => $sett_site_vimeo,
                    ':xsett_site_tiktok' => $sett_site_tiktok,
                    ':xsett_site_soundcloud' => $sett_site_soundcloud,
                    ':xsett_logo_colored' => $original_logo,
                    ':xsett_logo_black' => $black_logo,
                    ':xsett_logo_white' => $white_logo,
                    ':xsett_season_banner' => $season_banner,
                    ':xsett_updated_at' => $sett_updated_at,
                )
            );

            if(!empty($result02)) {

                // Record activity history
                $action = $user_full_name." update site settings";
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the site settings and configurations ";
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