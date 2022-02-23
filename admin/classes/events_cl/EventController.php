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
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM event_posts WHERE eve_hashed =:xeve_hashed");
        $stmt_sel->bindParam(':xeve_hashed',$hash_code);
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

    // check request and get event info
    if(isset($_POST['action']) && ($_POST['action'] == "get_event")) {
        // Get all about event
        $hashed_id = $_POST['hashed_id'];
        $stmt=$db_connect->prepare("SELECT * FROM event_posts WHERE eve_hashed='$hashed_id' ");
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data = $row;  
            }
        } 
        else {
            $errorMSG = "Data for event not found!";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // display JSON data
        echo json_encode($data);
        exit;
    }
    // check request and add event info
    if(isset($_POST['action']) && ($_POST['action'] == "save_event")) {
        $errorMSG = "";
        $eve_hashed = generateRandomString(27);
        $eve_name = $_POST['eve_name'];
        $eve_category = $_POST['eve_category'];
        $eve_description = $_POST['eve_description'];
        $eve_location = $_POST['eve_location'];
        $eve_map_location = $_POST['eve_map_location'];
        $eve_venue = $_POST['eve_venue'];
        $eve_rating = 0;
        $eve_organiser = $_POST['eve_organiser'];
        $eve_fb_link = $_POST['eve_fb_link'];
        $eve_twitter_link = $_POST['eve_twitter_link'];
        $eve_ig_link = $_POST['eve_ig_link'];
        $eve_tags = $_POST['eve_tags'];
        $eve_yt_video_link = $_POST['eve_yt_video_link'];
        $eve_start_date = $_POST['eve_start_date'];
        $eve_end_date = $_POST['eve_end_date'];
        $eve_start_time = $_POST['eve_start_time'];
        $eve_end_time = $_POST['eve_end_time'];
        $eve_enable_ticket_sales = $_POST['eve_enable_ticket_sales'];
        $eve_ticket_hashed = generateRandomString(33);
        
        $eve_ticket_name1 = $_POST['eve_ticket_name1'];
        $eve_ticket_desc1 = $_POST['eve_ticket_desc1'];
        $eve_ticket_price1 = $_POST['eve_ticket_price1'];
        $eve_ticket_quantity1 = $_POST['eve_ticket_quantity1'];
        $eve_ticket_name2 = $_POST['eve_ticket_name2'];
        $eve_ticket_desc2 = $_POST['eve_ticket_desc2'];
        $eve_ticket_price2 = $_POST['eve_ticket_price2'];
        $eve_ticket_quantity2 = $_POST['eve_ticket_quantity2'];
        $eve_ticket_name3 = $_POST['eve_ticket_name3'];
        $eve_ticket_desc3 = $_POST['eve_ticket_desc3'];
        $eve_ticket_price3 = $_POST['eve_ticket_price3'];
        $eve_ticket_quantity3 = $_POST['eve_ticket_quantity3'];
        $eve_ticket_name4 = $_POST['eve_ticket_name4'];
        $eve_ticket_desc4 = $_POST['eve_ticket_desc4'];
        $eve_ticket_price4 = $_POST['eve_ticket_price4'];
        $eve_ticket_quantity4 = $_POST['eve_ticket_quantity4'];

        $eve_start_sales_on = $_POST['eve_start_sales_on'];
        $eve_ends_sales_on = $_POST['eve_ends_sales_on'];
        $eve_show_attendees = $_POST['eve_show_attendees'];
        $eve_enable_reviews = $_POST['eve_enable_reviews'];
        $eve_audience = implode(",", $_POST['eve_audience']);
        $eve_active_status = 1;
        $eve_created_by = $neo_user_code;
        $eve_created_at = date('Y-m-d H:i:s');

        if ($eve_category == '') {
            $errorMSG = "Event category field is required";
        }
        if ($eve_location == '') {
            $errorMSG = "Location of event is required";
        }
        if ($eve_venue == '') {
            $errorMSG = "Venue of event is required";
        }
        if ($eve_organiser == '') {
            $errorMSG = "Event organiser name is required";
        }
        if ($eve_start_date == '') {
            $errorMSG = "Event start date is required";
        }
        if ($eve_end_date == '') {
            $errorMSG = "Event end date is required";
        }
        if ($eve_start_time == '') {
            $errorMSG = "Event start time is required";
        }
        if ($eve_end_time == '') {
            $errorMSG = "Event end time is required";
        }
        if ($eve_show_attendees == '') {
            $errorMSG = "Indicate if you want to show attendees? This field is required";
        }
        if ($eve_enable_reviews == '') {
            $errorMSG = "Indicate if you want to enable event reviews. This field is required";
        }
        if ($eve_audience == '') {
            $errorMSG = "Event audience field is required. Who are your target group?";
        }

        if ($eve_enable_ticket_sales == 1) {
            if ($eve_ticket_name1 == '') {
                $errorMSG = "Ticket name is required, since you enable ticket sales";
            }
            if ($eve_ticket_price1 == '') {
                $errorMSG = "Ticket pricing is required";
            }
            if ($eve_ticket_quantity1 == '') {
                $errorMSG = "Ticket quantity available for sale is required";
            }
            if ($eve_start_sales_on == '') {
                $errorMSG = "Ticket sales starts date field is required";
            }
            if ($eve_ends_sales_on == '') {
                $errorMSG = "Ticket sales ends date field is required";
            }
        }

        // image insert
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';
        $image5 = '';
        $image_url1 = UPLOADING_PATH."events/";
        $image_url2 = UPLOADING_PATH."tickets/";

        if($_FILES["eve_banner"]["name"] != ''){ $image1 = upload_image("eve_banner", $image_url1, $eve_hashed); } else{ $image1 = ""; }
        if($_FILES["eve_image1"]["name"] != ''){ $image2 = upload_image("eve_image1", $image_url1, $eve_hashed); } else{ $image2 = ""; }
        if($_FILES["eve_image2"]["name"] != ''){ $image3 = upload_image("eve_image2", $image_url1, $eve_hashed); } else{ $image3 = ""; }
        if($_FILES["eve_organiser_logo"]["name"] != ''){ $image4 = upload_image("eve_organiser_logo", $image_url1, $eve_hashed); } else{ $image4 = ""; }
        if($_FILES["eve_ticket_image"]["name"] != ''){ $image5 = upload_image("eve_ticket_image", $image_url2, $eve_ticket_hashed); } else{ $image5 = ""; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("INSERT INTO event_posts (eve_hashed, eve_name, eve_category, eve_description, eve_location, eve_map_location, eve_venue, eve_rating, eve_organiser, eve_organiser_logo, eve_fb_link, eve_twitter_link, eve_ig_link, eve_tags, eve_banner, eve_image1, eve_image2, eve_yt_video_link, eve_start_date, eve_end_date, eve_start_time, eve_end_time, eve_enable_ticket_sales, eve_ticket_hashed, eve_ticket_image, eve_ticket_name1, eve_ticket_desc1, eve_ticket_price1, eve_ticket_quantity1, eve_ticket_name2, eve_ticket_desc2,eve_ticket_price2, eve_ticket_quantity2, eve_ticket_name3, eve_ticket_desc3, eve_ticket_price3, eve_ticket_quantity3, eve_ticket_name4, eve_ticket_desc4, eve_ticket_price4, eve_ticket_quantity4, eve_start_sales_on, eve_ends_sales_on, eve_show_attendees, eve_enable_reviews, eve_audience, eve_active_status, eve_created_by, eve_created_at) VALUES (:xeve_hashed, :xeve_name, :xeve_category, :xeve_description, :xeve_location, :xeve_map_location, :xeve_venue, :xeve_rating, :xeve_organiser, :xeve_organiser_logo, :xeve_fb_link, :xeve_twitter_link, :xeve_ig_link, :xeve_tags, :xeve_banner, :xeve_image1, :xeve_image2, :xeve_yt_video_link, :xeve_start_date, :xeve_end_date, :xeve_start_time, :xeve_end_time, :xeve_enable_ticket_sales, :xeve_ticket_hashed, :xeve_ticket_image, :xeve_ticket_name1, :xeve_ticket_desc1, :xeve_ticket_price1, :xeve_ticket_quantity1, :xeve_ticket_name2, :xeve_ticket_desc2, :xeve_ticket_price2, :xeve_ticket_quantity2, :xeve_ticket_name3, :xeve_ticket_desc3, :xeve_ticket_price3, :xeve_ticket_quantity3, :xeve_ticket_name4, :xeve_ticket_desc4, :xeve_ticket_price4, :xeve_ticket_quantity4, :xeve_start_sales_on, :xeve_ends_sales_on, :xeve_show_attendees, :xeve_enable_reviews, :xeve_audience, :xeve_active_status, :xeve_created_by, :xeve_created_at)");
            $result02 = $stmt02->execute(
                array(
                    ':xeve_hashed' => $eve_hashed,
                    ':xeve_name' => $eve_name,
                    ':xeve_category' => $eve_category,
                    ':xeve_description' => $eve_description,
                    ':xeve_location' => $eve_location,
                    ':xeve_map_location' => $eve_map_location,
                    ':xeve_venue' => $eve_venue,
                    ':xeve_rating' => $eve_rating,
                    ':xeve_organiser' => $eve_organiser,
                    ':xeve_organiser_logo' => $image4,
                    ':xeve_fb_link' => $eve_fb_link,
                    ':xeve_twitter_link' => $eve_twitter_link,
                    ':xeve_ig_link' => $eve_ig_link,
                    ':xeve_tags' => $eve_tags,
                    ':xeve_banner' => $image1,
                    ':xeve_image1' => $image2,
                    ':xeve_image2' => $image3,
                    ':xeve_yt_video_link' => $eve_yt_video_link,
                    ':xeve_start_date' => $eve_start_date,
                    ':xeve_end_date' => $eve_end_date,
                    ':xeve_start_time' => $eve_start_time,
                    ':xeve_end_time' => $eve_end_time,
                    ':xeve_enable_ticket_sales' => $eve_enable_ticket_sales,
                    ':xeve_ticket_hashed' => $eve_ticket_hashed,
                    ':xeve_ticket_image' => $image5,
                    ':xeve_ticket_name1' => $eve_ticket_name1,
                    ':xeve_ticket_desc1' => $eve_ticket_desc1,
                    ':xeve_ticket_price1' => $eve_ticket_price1,
                    ':xeve_ticket_quantity1' => $eve_ticket_quantity1,
                    ':xeve_ticket_name2' => $eve_ticket_name2,
                    ':xeve_ticket_desc2' => $eve_ticket_desc2,
                    ':xeve_ticket_price2' => $eve_ticket_price2,
                    ':xeve_ticket_quantity2' => $eve_ticket_quantity2,
                    ':xeve_ticket_name3' => $eve_ticket_name3,
                    ':xeve_ticket_desc3' => $eve_ticket_desc3,
                    ':xeve_ticket_price3' => $eve_ticket_price3,
                    ':xeve_ticket_quantity3' => $eve_ticket_quantity3,
                    ':xeve_ticket_name4' => $eve_ticket_name4,
                    ':xeve_ticket_desc4' => $eve_ticket_desc4,
                    ':xeve_ticket_price4' => $eve_ticket_price4,
                    ':xeve_ticket_quantity4' => $eve_ticket_quantity4,
                    ':xeve_start_sales_on' => $eve_start_sales_on,
                    ':xeve_ends_sales_on' => $eve_ends_sales_on,
                    ':xeve_show_attendees' => $eve_show_attendees,
                    ':xeve_enable_reviews' => $eve_enable_reviews,
                    ':xeve_audience' => $eve_audience,
                    ':xeve_active_status' => $eve_active_status,
                    ':xeve_created_by' => $eve_created_by,
                    ':xeve_created_at' => $eve_created_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." added a event post with ID: ".$eve_hashed;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully added an event post";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and update eve info
    if(isset($_POST['action']) && ($_POST['action'] == "update_event")) {
        $errorMSG = "";
        $eve_hashed = $_POST['hidden_hashed'];
        $eve_name = $_POST['ed_eve_name'];
        $eve_category = $_POST['ed_eve_category'];
        $eve_description = $_POST['ed_eve_description'];
        $eve_location = $_POST['ed_eve_location'];
        $eve_map_location = $_POST['ed_eve_map_location'];
        $eve_venue = $_POST['ed_eve_venue'];
        $eve_organiser = $_POST['ed_eve_organiser'];
        $eve_fb_link = $_POST['ed_eve_fb_link'];
        $eve_twitter_link = $_POST['ed_eve_twitter_link'];
        $eve_ig_link = $_POST['ed_eve_ig_link'];
        $eve_tags = $_POST['ed_eve_tags'];
        $eve_yt_video_link = $_POST['ed_eve_yt_video_link'];
        $eve_start_date = $_POST['ed_eve_start_date'];
        $eve_end_date = $_POST['ed_eve_end_date'];
        $eve_start_time = $_POST['ed_eve_start_time'];
        $eve_end_time = $_POST['ed_eve_end_time'];
        $eve_enable_ticket_sales = $_POST['ed_eve_enable_ticket_sales'];
        $eve_ticket_hashed = $_POST['hidden_ticket_hashed'];

        $eve_ticket_name1 = $_POST['ed_eve_ticket_name1'];
        $eve_ticket_desc1 = $_POST['ed_eve_ticket_desc1'];
        $eve_ticket_price1 = $_POST['ed_eve_ticket_price1'];
        $eve_ticket_quantity1 = $_POST['ed_eve_ticket_quantity1'];
        $eve_ticket_name2 = $_POST['ed_eve_ticket_name2'];
        $eve_ticket_desc2 = $_POST['ed_eve_ticket_desc2'];
        $eve_ticket_price2 = $_POST['ed_eve_ticket_price2'];
        $eve_ticket_quantity2 = $_POST['ed_eve_ticket_quantity2'];
        $eve_ticket_name3 = $_POST['ed_eve_ticket_name3'];
        $eve_ticket_desc3 = $_POST['ed_eve_ticket_desc3'];
        $eve_ticket_price3 = $_POST['ed_eve_ticket_price3'];
        $eve_ticket_quantity3 = $_POST['ed_eve_ticket_quantity3'];
        $eve_ticket_name4 = $_POST['ed_eve_ticket_name4'];
        $eve_ticket_desc4 = $_POST['ed_eve_ticket_desc4'];
        $eve_ticket_price4 = $_POST['ed_eve_ticket_price4'];
        $eve_ticket_quantity4 = $_POST['ed_eve_ticket_quantity4'];

        $eve_start_sales_on = $_POST['ed_eve_start_sales_on'];
        $eve_ends_sales_on = $_POST['ed_eve_ends_sales_on'];
        $eve_show_attendees = $_POST['ed_eve_show_attendees'];
        $eve_enable_reviews = $_POST['ed_eve_enable_reviews'];
        $ed_dis_eve_audience = $_POST['ed_dis_eve_audience'];
        $hidden_eve_organiser_logo = $_POST['hidden_eve_organiser_logo'];
        $hidden_eve_banner = $_POST['hidden_eve_banner'];
        $hidden_eve_image1 = $_POST['hidden_eve_image1'];
        $hidden_eve_image2 = $_POST['hidden_eve_image2'];
        $hidden_eve_ticket_image = $_POST['hidden_eve_ticket_image'];
        $eve_updated_at = date('Y-m-d H:i:s');

        if ($eve_category == '') {
            $errorMSG = "Event category field is required";
        }
        if ($eve_location == '') {
            $errorMSG = "Location of event is required";
        }
        if ($eve_venue == '') {
            $errorMSG = "Venue of event is required";
        }
        if ($eve_organiser == '') {
            $errorMSG = "Event organiser name is required";
        }
        if ($eve_start_date == '') {
            $errorMSG = "Event start date is required";
        }
        if ($eve_end_date == '') {
            $errorMSG = "Event end date is required";
        }
        if ($eve_start_time == '') {
            $errorMSG = "Event start time is required";
        }
        if ($eve_end_time == '') {
            $errorMSG = "Event end time is required";
        }
        if ($eve_show_attendees == '') {
            $errorMSG = "Indicate if you want to show attendees? This field is required";
        }
        if ($eve_enable_reviews == '') {
            $errorMSG = "Indicate if you want to enable event reviews. This field is required";
        }

        if (isset($_POST['ed_eve_audience']) == "" && $ed_dis_eve_audience != "") {
            $eve_audience = $_POST['ed_dis_eve_audience'];
        }
        elseif (isset($_POST['ed_eve_audience']) != "" ) {
            $eve_audience = implode(",", $_POST['ed_eve_audience']);
        }
        elseif (isset($_POST['ed_eve_audience']) == "" && $ed_dis_eve_audience == "") {
            $errorMSG = "Event audience field is required. Who are your target group?";
        }

        if ($eve_enable_ticket_sales == 1) {
            if ($eve_ticket_name1 == '') {
                $errorMSG = "Ticket name is required, since you enable ticket sales";
            }
            if ($eve_ticket_price1 == '') {
                $errorMSG = "Ticket pricing is required";
            }
            if ($eve_ticket_quantity1 == '') {
                $errorMSG = "Ticket quantity available for sale is required";
            }
            if ($eve_start_sales_on == '') {
                $errorMSG = "Ticket sales starts date field is required";
            }
            if ($eve_ends_sales_on == '') {
                $errorMSG = "Ticket sales ends date field is required";
            }
        }

        // image update/insert
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';
        $image5 = '';
        $image_url1 = UPLOADING_PATH."events/";
        $image_url2 = UPLOADING_PATH."tickets/";

        if($_FILES["ed_eve_banner"]["name"] != ''){
            removeImage("eve_banner", $image_url1, $eve_hashed);
            $image1 = upload_image("ed_eve_banner", $image_url1, $eve_hashed);
        } else{ $image1 = $_POST['hidden_eve_banner']; }

        if($_FILES["ed_eve_image1"]["name"] != ''){
            removeImage("eve_image1", $image_url1, $eve_hashed);
            $image2 = upload_image("ed_eve_image1", $image_url1, $eve_hashed);
        } else{ $image2 = $_POST['hidden_eve_image1']; }

        if($_FILES["ed_eve_image2"]["name"] != ''){
            removeImage("eve_image2", $image_url1, $eve_hashed);
            $image3 = upload_image("ed_eve_image2", $image_url1, $eve_hashed);
        } else{ $image3 = $_POST['hidden_eve_image2']; }

        if($_FILES["ed_eve_organiser_logo"]["name"] != ''){
            removeImage("eve_organiser_logo", $image_url1, $eve_hashed);
            $image4 = upload_image("ed_eve_organiser_logo", $image_url1, $eve_hashed);
        } else{ $image4 = $_POST['hidden_eve_organiser_logo']; }

        if($_FILES["ed_eve_ticket_image"]["name"] != ''){
            removeImage("eve_ticket_image", $image_url2, $eve_hashed);
            $image5 = upload_image("ed_eve_ticket_image", $image_url2, $eve_hashed);
        } else{ $image5 = $_POST['hidden_eve_ticket_image']; }

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 = $db_connect->prepare("UPDATE event_posts SET eve_name=:xeve_name, eve_category=:xeve_category, eve_description=:xeve_description, eve_location=:xeve_location, eve_map_location=:xeve_map_location, eve_venue=:xeve_venue, eve_organiser=:xeve_organiser, eve_organiser_logo=:xeve_organiser_logo, eve_fb_link=:xeve_fb_link, eve_twitter_link=:xeve_twitter_link, eve_ig_link=:xeve_ig_link, eve_tags=:xeve_tags, eve_banner=:xeve_banner, eve_image1=:xeve_image1, eve_image2=:xeve_image2, eve_yt_video_link=:xeve_yt_video_link, eve_start_date=:xeve_start_date, eve_end_date=:xeve_end_date, eve_start_time=:xeve_start_time, eve_end_time=:xeve_end_time, eve_enable_ticket_sales=:xeve_enable_ticket_sales, eve_ticket_hashed=:xeve_ticket_hashed, eve_ticket_image=:xeve_ticket_image, eve_ticket_name1=:xeve_ticket_name1, eve_ticket_desc1=:xeve_ticket_desc1, eve_ticket_price1=:xeve_ticket_price1, eve_ticket_quantity1=:xeve_ticket_quantity1, eve_ticket_name2=:xeve_ticket_name2, eve_ticket_desc2=:xeve_ticket_desc2, eve_ticket_price2=:xeve_ticket_price2, eve_ticket_quantity2=:xeve_ticket_quantity2, eve_ticket_name3=:xeve_ticket_name3, eve_ticket_desc3=:xeve_ticket_desc3, eve_ticket_price3=:xeve_ticket_price3, eve_ticket_quantity3=:xeve_ticket_quantity3,
                eve_ticket_name4=:xeve_ticket_name4, eve_ticket_desc4=:xeve_ticket_desc4, eve_ticket_price4=:xeve_ticket_price4, eve_ticket_quantity4=:xeve_ticket_quantity4, eve_start_sales_on=:xeve_start_sales_on, eve_ends_sales_on=:xeve_ends_sales_on, eve_show_attendees=:xeve_show_attendees, eve_enable_reviews=:xeve_enable_reviews, eve_audience=:xeve_audience, eve_updated_at=:xeve_updated_at  WHERE eve_hashed=:xeve_hashed ");
            $result02 = $stmt02->execute(
                array(
                    ':xeve_hashed' => $eve_hashed,
                    ':xeve_name' => $eve_name,
                    ':xeve_category' => $eve_category,
                    ':xeve_description' => $eve_description,
                    ':xeve_location' => $eve_location,
                    ':xeve_map_location' => $eve_map_location,
                    ':xeve_venue' => $eve_venue,
                    ':xeve_organiser' => $eve_organiser,
                    ':xeve_organiser_logo' => $image4,
                    ':xeve_fb_link' => $eve_fb_link,
                    ':xeve_twitter_link' => $eve_twitter_link,
                    ':xeve_ig_link' => $eve_ig_link,
                    ':xeve_tags' => $eve_tags,
                    ':xeve_banner' => $image1,
                    ':xeve_image1' => $image2,
                    ':xeve_image2' => $image3,
                    ':xeve_yt_video_link' => $eve_yt_video_link,
                    ':xeve_start_date' => $eve_start_date,
                    ':xeve_end_date' => $eve_end_date,
                    ':xeve_start_time' => $eve_start_time,
                    ':xeve_end_time' => $eve_end_time,
                    ':xeve_enable_ticket_sales' => $eve_enable_ticket_sales,
                    ':xeve_ticket_hashed' => $eve_ticket_hashed,
                    ':xeve_ticket_image' => $image5,
                    ':xeve_ticket_name1' => $eve_ticket_name1,
                    ':xeve_ticket_desc1' => $eve_ticket_desc1,
                    ':xeve_ticket_price1' => $eve_ticket_price1,
                    ':xeve_ticket_quantity1' => $eve_ticket_quantity1,
                    ':xeve_ticket_name2' => $eve_ticket_name2,
                    ':xeve_ticket_desc2' => $eve_ticket_desc2,
                    ':xeve_ticket_price2' => $eve_ticket_price2,
                    ':xeve_ticket_quantity2' => $eve_ticket_quantity2,
                    ':xeve_ticket_name3' => $eve_ticket_name3,
                    ':xeve_ticket_desc3' => $eve_ticket_desc3,
                    ':xeve_ticket_price3' => $eve_ticket_price3,
                    ':xeve_ticket_quantity3' => $eve_ticket_quantity3,
                    ':xeve_ticket_name4' => $eve_ticket_name4,
                    ':xeve_ticket_desc4' => $eve_ticket_desc4,
                    ':xeve_ticket_price4' => $eve_ticket_price4,
                    ':xeve_ticket_quantity4' => $eve_ticket_quantity4,
                    ':xeve_start_sales_on' => $eve_start_sales_on,
                    ':xeve_ends_sales_on' => $eve_ends_sales_on,
                    ':xeve_show_attendees' => $eve_show_attendees,
                    ':xeve_enable_reviews' => $eve_enable_reviews,
                    ':xeve_audience' => $eve_audience,
                    ':xeve_updated_at' => $eve_updated_at
                )
            );

            if(!empty($result02)) {
                // Record activity history
                $action = $user_full_name." edited an event post with ID: ".$eve_hashed;
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated the event post";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        } else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query
    }
    // check request and delete eve info
    if(isset($_POST['action']) && isset($_POST['action']) == "delete_event" && isset($_POST['del_eve_id']) !="") {
        $del_eve_hashed = $_POST['del_eve_id'];
        $eve_active_status = 3;

        // fetch file names
        $stmt_select = $db_connect->prepare('SELECT eve_organiser_logo, eve_banner, eve_image1, eve_image2, eve_ticket_image FROM event_posts WHERE eve_hashed =:xeve_hashed');
        $stmt_select->bindParam(':xeve_hashed',$del_eve_hashed);
        $stmt_select->execute();
        while($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow1 = $del_row['eve_organiser_logo'];
            $imgRow2 = $del_row['eve_banner'];
            $imgRow3 = $del_row['eve_image1'];
            $imgRow4 = $del_row['eve_image2'];
            $imgRow5 = $del_row['eve_ticket_image'];
        }

        // remove file from directory
        if ($imgRow1 == "" && $imgRow2 == "" && $imgRow3 == "" && $imgRow4 == "" && $imgRow5 == "") 
        {
            $stmt_delete = $db_connect->prepare('UPDATE event_posts SET eve_active_status=:xeve_active_status, eve_deleted_at=:xeve_deleted_at WHERE eve_hashed =:xeve_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xeve_hashed' => $del_eve_hashed,
                    ':xeve_active_status' => $eve_active_status,
                    ':xeve_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        else 
        {       
            if ($imgRow1 != "") { unlink(UPLOADING_PATH."events/".$imgRow1); }
            if ($imgRow2 != "") { unlink(UPLOADING_PATH."events/".$imgRow2); }
            if ($imgRow3 != "") { unlink(UPLOADING_PATH."events/".$imgRow3); }
            if ($imgRow4 != "") { unlink(UPLOADING_PATH."events/".$imgRow4); }
            if ($imgRow5 != "") { unlink(UPLOADING_PATH."tickets/".$imgRow5); }

            $stmt_delete = $db_connect->prepare('UPDATE event_posts SET eve_organiser_logo="", eve_banner="", eve_image1="", eve_image2="", eve_ticket_image="", eve_active_status=:xeve_active_status, eve_deleted_at=:xeve_deleted_at WHERE eve_hashed =:xeve_hashed');
            $success_delete = $stmt_delete->execute(
                array(
                    ':xeve_hashed' => $del_eve_hashed,
                    ':xeve_active_status' => $eve_active_status,
                    ':xeve_deleted_at' => date('Y-m-d H:i:s')
                )
            );
        }
        // delete file name from database
        
        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted an event post with ID: ".$del_eve_hashed;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "Event post was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "Event post could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }
    // Activate and deactivate event
    if(isset($_POST['action']) && ($_POST['action'] == "activate_event"))
    {
        $up_eve_id = $_POST['up_eve_id'];
        $up_eve_active_status     = $_POST['up_eve_active_status'];

        if ($up_eve_active_status == 1){ $new_eve_active_status = 0; } else { $new_eve_active_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE event_posts SET eve_active_status =:xeve_active_status, eve_updated_at=:xeve_updated_at WHERE eve_hashed=:xeve_hashed ");
        $result01 = $stmt01->execute(
            array(
                ':xeve_hashed' => $up_eve_id,
                ':xeve_active_status' => $new_eve_active_status,
                ':xeve_updated_at' => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of an event post with ID: ".$up_eve_id;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_eve_active_status == 0) {
                $msg = "The event post was disabled successfully.";
            } else {
                $msg = "The event post was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of the event post could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
    }

?>