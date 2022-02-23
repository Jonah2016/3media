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
    function removeImage($field, $url, $abt_id)
    {
        // fetch file name
        include("../../resources/connect.inc.php");
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM about_page WHERE abt_id=:xabt_id");
        $stmt_sel->bindParam(':xabt_id',$abt_id);
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


    // check request and get about info
    if(isset($_POST['action']) && ($_POST['action'] == "get_about")) {
        // Get all about about_page
        $abt_id = $_POST['abt_id'];
        $stmt=$db_connect->prepare("SELECT * FROM about_page WHERE abt_id='$abt_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for about page not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }


    // check request and update settings info
    if(isset($_POST['action']) && ($_POST['action'] == "save_about")) {
        $errorMSG = "";
        $abt_id = 2066;
        $abt_organisation_name = $_POST['abt_organisation_name'];
        $abt_brief_description = $_POST['abt_brief_description'];
        $abt_full_description = $_POST['abt_full_description'];
        $abt_updated_at = date('Y-m-d H:i:s');

        if (empty($abt_organisation_name )) {
           $errorMSG = "Company name field is required.";
        }
        if (empty($abt_brief_description)) {
           $errorMSG = "Summarized description of company is required.";
        }
        if (empty($abt_full_description)) {
           $errorMSG = "Full description of company is required.";
        }

        // image insert
        $image_one = '';
        $image_two = '';
        $image_three = '';
        $image_url = UPLOADING_PATH."system/";
        if(!empty($_FILES["abt_photo_one"]['name'])) {
            removeImage("abt_photo_one", $image_url, $abt_id);
            $image_one = upload_image("abt_photo_one", $image_url);
        } else{
            $image_one = $_POST['hid_abt_photo_one'];
        }
        if(!empty($_FILES["abt_photo_two"]['name'])) {
            removeImage("abt_photo_two", $image_url, $abt_id);
            $image_two = upload_image("abt_photo_two", $image_url);
        } else{
            $image_two = $_POST['hid_abt_photo_two'];
        } 
        if(!empty($_FILES["abt_photo_three"]['name'])) {
            removeImage("abt_photo_three", $image_url, $abt_id);
            $image_three = upload_image("abt_photo_three", $image_url);
        } else{
            $image_three = $_POST['hid_abt_photo_three'];
        }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE about_page SET abt_organisation_name=:xabt_organisation_name, abt_brief_description=:xabt_brief_description, abt_full_description=:xabt_full_description, abt_photo_one=:xabt_photo_one, abt_photo_two=:xabt_photo_two, abt_photo_three=:xabt_photo_three, abt_updated_at =:xabt_updated_at
            WHERE abt_id=:xabt_id ");
            $result02 = $stmt02->execute(
                array(
                    ':xabt_id' => $abt_id,
                    ':xabt_organisation_name' => $abt_organisation_name,
                    ':xabt_brief_description' => $abt_brief_description,
                    ':xabt_full_description' => $abt_full_description, 
                    ':xabt_photo_one' => $image_one,
                    ':xabt_photo_two' => $image_two,
                    ':xabt_photo_three' => $image_three, 
                    ':xabt_updated_at' => $abt_updated_at,
                )
            );

            if(!empty($result02)) {

                // Record activity history
                $action = $user_full_name." update about page details";
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the about page ";
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