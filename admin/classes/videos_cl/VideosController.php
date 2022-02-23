<?php
    // include Database connection file
    require_once("../../resources/auth.inc.php");

    // Upload image in add function
function upload_image($field, $url, $hash_code)
{
    if (isset($_FILES[$field])) {
        $extension = explode('.', $_FILES[$field]['name']);
        $new_name = $hash_code.'_'.rand(100, 1000).'_'.date('Ymd'). '.' . $extension[1];
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
    $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM videos WHERE vid_hashed =:xvid_hashed");
    $stmt_sel->bindParam(':xvid_hashed', $hash_code);
    $stmt_sel->execute();
    while ($del_row=$stmt_sel->fetch(PDO::FETCH_ASSOC)) {
        extract($del_row);
        $imgRow = $del_row[$field];
    }
    // remove file from directory
    if ($imgRow != "") {
        unlink($url.$imgRow);
    } else {
        return false;
    }
}

    // check request and get video info
if (isset($_POST['action']) && ($_POST['action'] == "get_video")) {
    // Get all about video
    $hashed_id = $_POST['hashed_id'];
    $stmt=$db_connect->prepare("SELECT * FROM videos WHERE vid_hashed='$hashed_id' ");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $data = $row;
        }
    } else {
        $errorMSG = "Data for video not found!";
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
    // display JSON data
    echo json_encode($data);
    exit;
}
    // check request and add video info
if (isset($_POST['action']) && ($_POST['action'] == "save_video")) {
    $errorMSG = "";
    $vid_hashed = generateRandomString(27);
    $vid_category = $_POST['vid_category'];
    $vid_title = $_POST['vid_title'];
    $vid_author = $_POST['vid_author'];
    $vid_youtube_url = $_POST['vid_youtube_url'];
    $vid_description = $_POST['vid_description'];
    $vid_date = $_POST['vid_date'];
    $vid_img_caption = $_POST['vid_img_caption'];
    $vid_active_status = 1;
    $vid_created_at = date('Y-m-d H:i:s');

    if ($vid_category == "") {
        $errorMSG = " Video category field is required.";
    }
    if ($vid_title == "") {
        $errorMSG = " Video title field is required.";
    }
    if ($vid_date == "") {
        $errorMSG = " Video date field is required.";
    }
    if ($vid_author == "") {
        $errorMSG = " Video author field is required.";
    }
    if ($vid_youtube_url == "") {
        $errorMSG = " Youtube video URL field is required.";
    }
    if ($vid_img_caption == "") {
        $errorMSG = " You forgot the image caption. This field is required.";
    }

    // image insert
    $image = '';
    $image_url = UPLOADING_PATH."videos_thumbnails/";

    if ($_FILES["vid_thumbnail"]["name"] != '') {
        $image = upload_image("vid_thumbnail", $image_url, $vid_hashed);
    } else {
        $image = "";
    }

    // Execute Query
    if (empty($errorMSG)) {
        $stmt02 = $db_connect->prepare("INSERT INTO videos (vid_hashed, vid_category, vid_title, vid_author, vid_youtube_url, vid_description, vid_date, vid_thumbnail, vid_img_caption, vid_active_status, vid_created_at) VALUES (:avid_hashed, :avid_category, :avid_title, :avid_author, :avid_youtube_url, :avid_description, :avid_date, :avid_thumbnail, :avid_img_caption, :avid_active_status, :avid_created_at)");
        $result02 = $stmt02->execute(
            array(
                ':avid_hashed' => $vid_hashed,
                ':avid_category' => $vid_category,
                ':avid_title' => $vid_title,
                ':avid_author' => $vid_author,
                ':avid_youtube_url' => $vid_youtube_url,
                ':avid_description' => $vid_description,
                ':avid_date' => $vid_date,
                ':avid_thumbnail' => $image,
                ':avid_img_caption' => $vid_img_caption,
                ':avid_active_status' => $vid_active_status,
                ':avid_created_at' => $vid_created_at
            )
        );

        if (!empty($result02)) {
            // Record activity history
            $action = $user_full_name." added a video with ID: ".$vid_hashed;
            $act_status = "added";
            log_history($neo_user_code, $action, $act_status);

            $msg = "You have successfully added video post";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
    } else {
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
    // End Execute Query
}
    // check request and update video info
if (isset($_POST['action']) && ($_POST['action'] == "update_video")) {
    $errorMSG = "";
    $vid_hashed = $_POST['hidden_hashed'];
    $vid_category = $_POST['ed_vid_category'];
    $vid_title = $_POST['ed_vid_title'];
    $vid_author = $_POST['ed_vid_author'];
    $vid_youtube_url = $_POST['ed_vid_youtube_url'];
    $vid_description = $_POST['ed_vid_description'];
    $vid_date = $_POST['ed_vid_date'];
    $vid_img_caption = $_POST['ed_vid_img_caption'];
    $hidden_vid_thumbnail = $_POST['hidden_vid_thumbnail'];
    $vid_active_status = 1;
    $vid_updated_at = date('Y-m-d H:i:s');

    if ($vid_category == "") {
        $errorMSG = " Video category field is required.";
    }
    if ($vid_title == "") {
        $errorMSG = " Video title field is required.";
    }
    if ($vid_author == "") {
        $errorMSG = " Video author field is required.";
    }
    if ($vid_date == "") {
        $errorMSG = " Video date field is required.";
    }
    if ($vid_youtube_url == "") {
        $errorMSG = " Youtube video URL field is required.";
    }

    // image insert
    $image = '';
    $image_url = UPLOADING_PATH."videos_thumbnails/";

    if ($_FILES["ed_vid_thumbnail"]["name"] != '') {
        removeImage("vid_thumbnail", $image_url, $vid_hashed);
        $image = upload_image("ed_vid_thumbnail", $image_url, $vid_hashed);
    } else {
        $image = $_POST['hidden_vid_thumbnail'];
    }

    // Execute Query
    if (empty($errorMSG)) {
        $stmt02 = $db_connect->prepare("UPDATE videos SET 
            vid_category=:avid_category, vid_title=:avid_title, vid_author=:avid_author, vid_youtube_url=:avid_youtube_url, vid_description=:avid_description, vid_date=:avid_date, vid_thumbnail=:avid_thumbnail, vid_img_caption=:avid_img_caption, vid_active_status=:avid_active_status, vid_updated_at=:avid_updated_at WHERE vid_hashed=:avid_hashed ");
        $result02 = $stmt02->execute(
            array(
                ':avid_hashed' => $vid_hashed,
                ':avid_category' => $vid_category,
                ':avid_title' => $vid_title,
                ':avid_author' => $vid_author,
                ':avid_youtube_url' => $vid_youtube_url,
                ':avid_description' => $vid_description,
                ':avid_date' => $vid_date,
                ':avid_thumbnail' => $image,
                ':avid_img_caption' => $vid_img_caption,
                ':avid_active_status' => $vid_active_status,
                ':avid_updated_at' => $vid_updated_at
            )
        );

        if (!empty($result02)) {
            // Record activity history
            $action = $user_full_name." edited a video with ID: ".$vid_hashed;
            $act_status = "edited";
            log_history($neo_user_code, $action, $act_status);

            $msg = "You have successfully updated the video";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
    } else {
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
    // End Execute Query
}
    // check request and delete video info
if (isset($_POST['action']) && isset($_POST['action']) == "delete_video" && isset($_POST['del_vid_id']) !="") {
    $del_vid_hashed = $_POST['del_vid_id'];
    $vid_active_status = 3;
    // fetch file name
    $stmt_select = $db_connect->prepare('SELECT vid_thumbnail FROM videos WHERE vid_hashed =:xvid_hashed');
    $stmt_select->bindParam(':xvid_hashed', $del_vid_hashed);
    $stmt_select->execute();
    while ($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC)) {
        extract($del_row);
        $imgRow  = $del_row['vid_thumbnail'];
    }

    // remove file from directory
    if ($imgRow == "") {
        $stmt_delete = $db_connect->prepare('UPDATE videos SET vid_active_status=:xvid_active_status, vid_deleted_at=:xvid_deleted_at WHERE vid_hashed =:xvid_hashed');
        $success_delete = $stmt_delete->execute(
            array(
                ':xvid_hashed' => $del_vid_hashed,
                ':xvid_active_status' => $vid_active_status,
                ':xvid_deleted_at' => date('Y-m-d H:i:s')
            )
        );
    } else {
        if ($imgRow  != "") {
            unlink(UPLOADING_PATH."videos_thumbnails/".$imgRow);
        }

        $stmt_delete = $db_connect->prepare('UPDATE videos SET vid_thumbnail="", vid_active_status=:xvid_active_status, vid_deleted_at=:xvid_deleted_at WHERE vid_hashed =:xvid_hashed');
        $success_delete = $stmt_delete->execute(
            array(
                ':xvid_hashed' => $del_vid_hashed,
                ':xvid_active_status' => $vid_active_status,
                ':xvid_deleted_at' => date('Y-m-d H:i:s')
            )
        );
    }
    // delete file name from database
        
    if ($success_delete) {
        // Record activity history
        $action = $user_full_name." deleted a video with ID: ".$del_vid_hashed;
        $act_status = "deleted";
        log_history($neo_user_code, $action, $act_status);

        $msg = "Video was successfully deleted";
        echo json_encode(['code'=>200, 'msg'=>$msg]);
        exit;
    } else {
        $errorMSG = "Video could not be deleted";
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
}
    // Activate and deactivate video
if (isset($_POST['action']) && ($_POST['action'] == "activate_video")) {
    $up_vid_id = $_POST['up_vid_id'];
    $up_vid_active_status     = $_POST['up_vid_active_status'];

    if ($up_vid_active_status == 1) {
        $new_vid_active_status = 0;
    } else {
        $new_vid_active_status = 1;
    }

    $stmt01 =  $db_connect->prepare("  
        UPDATE videos SET vid_active_status =:upvid_active_status, updated_at=:upupdated_at WHERE vid_hashed=:upvid_hashed ");
    $result01 = $stmt01->execute(
        array(
            ':upvid_hashed'     => $up_vid_id,
            ':upvid_active_status' => $new_vid_active_status,
            ':upupdated_at'         => date('Y-m-d H:i:s')
        )
    );

    if (!empty($result01)) {
        // Record activity history
        $action = $user_full_name." changed the status of a video with ID: ".$up_vid_id;
        $act_status = "changed status";
        log_history($neo_user_code, $action, $act_status);

        if ($new_vid_active_status == 0) {
            $msg = "The video was disabled successfully.";
        } else {
            $msg = "The video was enabled successfully.";
        }
        echo json_encode(['code'=>200, 'msg'=>$msg]);
        exit;
    } else {
        $errorMSG = "The status of the video could not be changed";
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
}
