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
    $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM news_posts WHERE news_hashed =:xnews_hashed");
    $stmt_sel->bindParam(':xnews_hashed', $hash_code);
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

    // check request and get News info
if (isset($_POST['action']) && ($_POST['action'] == "get_news")) {
    // Get all about news
    $hashed_id = $_POST['hashed_id'];
    $stmt=$db_connect->prepare("SELECT * FROM news_posts WHERE news_hashed='$hashed_id' ");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                $data = $row;
        }
    } else {
        $errorMSG = "Data for news not found!";
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
    // display JSON data
    echo json_encode($data);
    exit;
}
    // check request and add news info
if (isset($_POST['action']) && ($_POST['action'] == "save_news")) {
    $errorMSG = "";
    $news_hashed = generateRandomString(27);
    $news_category = implode(",", $_POST['news_category']);
    $news_title = $_POST['news_title'];
    $news_author = $_POST['news_by'];
    $news_briefing = htmlspecialchars($_POST['news_briefing'], ENT_QUOTES);
    $news_body = $_POST['news_body'];
    $news_featured = $_POST['news_featured'];
    $news_date = $_POST['news_date'];
    $news_img_caption = $_POST['news_img_caption'];
    $news_active_status = 1;
    $news_created_by = $neo_user_code;
    $news_created_at = date('Y-m-d H:i:s');

    if ($news_category == "") {
        $errorMSG = " News category field is required.";
    }
    if ($news_title == "") {
        $errorMSG = " News title field is required.";
    }
    if ($news_date == "") {
        $errorMSG = " News date field is required.";
    }
    if ($news_featured == "") {
        $errorMSG = " Is the news featured? This field is required.";
    }
    if ($news_author == "") {
        $errorMSG = " News author field is required.";
    }
    if ($news_body == "") {
        $errorMSG = " News body field is required.";
    }
    if ($news_briefing == "") {
        $errorMSG = " News briefing field is required.";
    }
    if ($news_img_caption == "") {
        $errorMSG = " You forgot the image caption. This field is required.";
    }

    // image insert
    $image = '';

    $image_url = UPLOADING_PATH."news/";
    if ($_FILES["news_image"]["name"] != '') {
        $image = upload_image("news_image", $image_url, $news_hashed);
    } else {
        $image = "";
    }

    // Execute Query
    if (empty($errorMSG)) {
        $stmt02 = $db_connect->prepare("INSERT INTO news_posts (news_hashed, news_category, news_title, news_author, news_briefing, news_body, news_date, news_featured, news_cover_image, news_img_caption, news_active_status, news_created_by, news_created_at) VALUES (:anews_hashed, :anews_category, :anews_title, :anews_author, :anews_briefing, :anews_body, :anews_date, :anews_featured, :anews_cover_image,:anews_img_caption, :anews_active_status, :anews_created_by, :anews_created_at)");
        $result02 = $stmt02->execute(
            array(
                ':anews_hashed' => $news_hashed,
                ':anews_category' => $news_category,
                ':anews_title' => $news_title,
                ':anews_author' => $news_author,
                ':anews_briefing' => $news_briefing,
                ':anews_body' => $news_body,
                ':anews_date' => $news_date,
                ':anews_featured' => $news_featured,
                ':anews_cover_image' => $image,
                ':anews_img_caption' => $news_img_caption,
                ':anews_active_status' => $news_active_status,
                ':anews_created_by' => $news_created_by,
                ':anews_created_at' => $news_created_at
            )
        );

        if (!empty($result02)) {
            // Record activity history
            $action = $user_full_name." added a news post with ID: ".$news_hashed;
            $act_status = "added";
            log_history($neo_user_code, $action, $act_status);

            $msg = "You have successfully added news post";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
    } else {
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
    // End Execute Query
}
    // check request and update news info
if (isset($_POST['action']) && ($_POST['action'] == "update_news")) {
    $errorMSG = "";
    $news_hashed = $_POST['hidden_hashed'];
    $news_title = $_POST['ed_news_title'];
    $news_author = $_POST['ed_news_by'];
    $news_briefing = htmlspecialchars($_POST['ed_news_briefing'], ENT_QUOTES);
    $news_body =$_POST['ed_news_body'];
    $news_featured = $_POST['ed_news_featured'];
    $news_date = $_POST['ed_news_date'];
    $news_img_caption = $_POST['ed_news_img_caption'];
    $hidden_news_image = $_POST['hidden_news_image'];
    $news_updated_at = date('Y-m-d H:i:s');

    if (!isset($_POST['ed_news_category']) && $_POST['ed_dis_news_category'] != "") {
        $news_category = $_POST['ed_dis_news_category'];
    } elseif (isset($_POST['ed_news_category'])) {
        $news_category = implode(",", $_POST['ed_news_category']);
    } elseif ((!isset($_POST['ed_news_category'])) && $_POST['ed_dis_news_category'] == "") {
        $errorMSG = "News category is required";
    }

    if ($news_title == "") {
        $errorMSG = " News title field is required.";
    }
    if ($news_author == "") {
        $errorMSG = " News author field is required.";
    }
    if ($news_featured == "") {
        $errorMSG = " Is the news featured? This field is required.";
    }
    if ($news_date == "") {
        $errorMSG = " News date field is required.";
    }
    if ($news_body == "") {
        $errorMSG = " News body field is required.";
    }
    if ($news_briefing == "") {
        $errorMSG = " News briefing field is required.";
    }
    if ($news_img_caption == "") {
        $errorMSG = " You forgot the image caption. This field is required.";
    }

    // image insert
    $image = '';
    $image_url = UPLOADING_PATH."news/";

    if ($_FILES["ed_news_image"]["name"] != '') {
        removeImage("news_cover_image", $image_url, $news_hashed);
        $image = upload_image("ed_news_image", $image_url, $news_hashed);
    } else {
        $image = $_POST['hidden_news_image'];
    }

    // Execute Query
    if (empty($errorMSG)) {
        $stmt02 = $db_connect->prepare("UPDATE news_posts SET 
            news_category=:anews_category, news_title=:anews_title, news_author=:anews_author, news_briefing=:anews_briefing, news_body=:anews_body, news_date=:anews_date, news_featured=:anews_featured, news_cover_image=:anews_cover_image, news_img_caption=:anews_img_caption, news_updated_at=:anews_updated_at WHERE news_hashed=:anews_hashed ");
        $result02 = $stmt02->execute(
            array(
                ':anews_hashed' => $news_hashed,
                ':anews_category' => $news_category,
                ':anews_title' => $news_title,
                ':anews_author' => $news_author,
                ':anews_briefing' => $news_briefing,
                ':anews_body' => $news_body,
                ':anews_date' => $news_date,
                ':anews_featured' => $news_featured,
                ':anews_cover_image' => $image,
                ':anews_img_caption' => $news_img_caption,
                ':anews_updated_at' => $news_updated_at
            )
        );

        if (!empty($result02)) {
            // Record activity history
            $action = $user_full_name." edited a news post with ID: ".$news_hashed;
            $act_status = "edited";
            log_history($neo_user_code, $action, $act_status);

            $msg = "You have successfully updated the news post";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
    } else {
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
    // End Execute Query
}
    // check request and delete news info
if (isset($_POST['action']) && isset($_POST['action']) == "delete_news" && isset($_POST['del_news_id']) !="") {
    $del_news_hashed = $_POST['del_news_id'];
    $news_active_status = 3;
    // fetch file name
    $stmt_select = $db_connect->prepare('SELECT news_cover_image FROM news_posts WHERE news_hashed =:xnews_hashed');
    $stmt_select->bindParam(':xnews_hashed', $del_news_hashed);
    $stmt_select->execute();
    while ($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC)) {
        extract($del_row);
        $imgRow  = $del_row['news_cover_image'];
    }

    // remove file from directory
    if ($imgRow == "") {
        $stmt_delete = $db_connect->prepare('UPDATE news_posts SET news_active_status=:xnews_active_status, news_deleted_at=:xnews_deleted_at WHERE news_hashed =:xnews_hashed');
        $success_delete = $stmt_delete->execute(
            array(
                ':xnews_hashed' => $del_news_hashed,
                ':xnews_active_status' => $news_active_status,
                ':xnews_deleted_at' => date('Y-m-d H:i:s')
            )
        );
    } else {
        if ($imgRow  != "") {
            unlink(UPLOADING_PATH."news/".$imgRow);
        }

        $stmt_delete = $db_connect->prepare('UPDATE news_posts SET news_cover_image="", news_active_status=:xnews_active_status, news_deleted_at=:xnews_deleted_at WHERE news_hashed =:xnews_hashed');
        $success_delete = $stmt_delete->execute(
            array(
                ':xnews_hashed' => $del_news_hashed,
                ':xnews_active_status' => $news_active_status,
                ':xnews_deleted_at' => date('Y-m-d H:i:s')
            )
        );
    }
    // delete file name from database
        

    if ($success_delete) {
        // Record activity history
        $action = $user_full_name." deleted a news post with ID: ".$del_news_hashed;
        $act_status = "deleted";
        log_history($neo_user_code, $action, $act_status);

        $msg = "News post was successfully deleted";
        echo json_encode(['code'=>200, 'msg'=>$msg]);
        exit;
    } else {
        $errorMSG = "News post could not be deleted";
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
}
    // Activate and deactivate news
if (isset($_POST['action']) && ($_POST['action'] == "activate_news")) {
    $up_news_id = $_POST['up_news_id'];
    $up_news_active_status     = $_POST['up_news_active_status'];

    if ($up_news_active_status == 1) {
        $new_news_active_status = 0;
    } else {
        $new_news_active_status = 1;
    }

    $stmt01 =  $db_connect->prepare("  
        UPDATE news_posts SET news_active_status =:upnews_active_status, news_updated_at=:upnews_updated_at WHERE news_hashed=:upnews_hashed ");
    $result01 = $stmt01->execute(
        array(
            ':upnews_hashed'     => $up_news_id,
            ':upnews_active_status' => $new_news_active_status,
            ':upnews_updated_at'         => date('Y-m-d H:i:s')
        )
    );

    if (!empty($result01)) {
        // Record activity history
        $action = $user_full_name." changed the status of a news post with ID: ".$up_news_id;
        $act_status = "changed status";
        log_history($neo_user_code, $action, $act_status);

        if ($new_news_active_status == 0) {
            $msg = "The news post was disabled successfully.";
        } else {
            $msg = "The news post was enabled successfully.";
        }
        echo json_encode(['code'=>200, 'msg'=>$msg]);
        exit;
    } else {
        $errorMSG = "The status of the news post could not be changed";
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }
}
