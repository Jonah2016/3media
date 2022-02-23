<?php
    
    require_once("../../resources/auth.inc.php");

    // Upload image in add function
    function upload_image($field, $url)
    {
        if(isset($_FILES[$field])) {
            $extension = explode('.', $_FILES[$field]['name']);
            $new_name = rand().date('Y') . '.' . $extension[1];
            $destination = $url . $new_name;
            move_uploaded_file($_FILES[$field]['tmp_name'], $destination);
            return $new_name;
        }
    }

    function removeImage($field, $url, $ref_code)
    {
        // fetch file name
        include("../../resources/connect.inc.php");
        $stmt_sel = $db_connect->prepare("SELECT ".$field." FROM users WHERE user_code=:xuser_code");
        $stmt_sel->bindParam(':xuser_code',$ref_code);
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


    // Add user query
    if(isset($_POST['user_fname']) && !empty($_POST['user_fname']))
    {
        $errorMSG = "";
        $add_user_code             = "U".rand(10,100).date('Ymd');   
        $add_user_fname            = $_POST['user_fname'];           
        $add_user_lname            = $_POST['user_lname'];           
        $add_user_email            = $_POST['user_email'];          
        $add_user_password         = strip_tags($_POST['user_password']);        
        $add_confirm_user_password = strip_tags($_POST['confirm_user_password']);   
        $add_user_account          = $_POST['user_account'];                       
        $add_user_active_status    = $_POST['user_active_status'];   
        $add_user_online_status    = 0;                              
        $add_created_at            = date('Y-m-d H:i:s');            

        if ($add_user_fname == "") {
            $errorMSG = " First name is required. Please fill it ";
        }
        else if ($add_user_lname == "") {
            $errorMSG = " Last name is required. Please fill it ";
        }
        else if ($add_user_account == '') {
            $errorMSG = " Account is required. Please fill it ";
        }

        else if ($add_user_account == 'user' && $_POST['user_account_type'] == "") {
           $errorMSG = "User accounts should have an assigned account type.";
        }
        else if ($add_user_account == 'super') {
           $add_user_account_type = "super";
        }
        else if ($add_user_account == 'user' && $_POST['user_account_type'] != ""){
           $add_user_account_type = $_POST['user_account_type'];
        }

        else if ($add_user_password == '') {
            $errorMSG = " Password is required. Please fill it ";
        }
        else if ($add_confirm_user_password == '') {
            $errorMSG = " Confirmation password is required. Please fill it ";
        }
        else if ($add_user_password != $add_confirm_user_password) {
            $errorMSG = " Password does not match confirmation password. Please try again ";
        }
        else if(!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) {
            $errorMSG = "Invalid email format";
        }
        else {
            $add_user_email = htmlspecialchars(strip_tags($_POST["user_email"]));
        }

        // image insert
        $add_image = "";
        $image_url = UPLOADING_PATH."users/";
        if($_FILES["user_image"]["name"] != '')
        {
            $add_image = upload_image("user_image", $image_url);
        } 
        else{
            $add_image = "";
        }

        // Pages Permitted
        $pages_permitted = [];

        // User
        if (isset($_POST["user_permission"])) { $user_permission = $_POST["user_permission"]; } else{ $user_permission = 0; } 
        if (isset($_POST["user_add"])) { $user_add = $_POST["user_add"]; } else{ $user_add = 0; }
        if (isset($_POST["user_edit"])) { $user_edit = $_POST["user_edit"]; } else{ $user_edit = 0; }
        if (isset($_POST["user_read"])) { $user_read = $_POST["user_read"]; } else{ $user_read = 0; }
        if (isset($_POST["user_delete"])) { $user_delete = $_POST["user_delete"]; } else{ $user_delete = 0; }
        $page = "users_page";
        $new_arr1 = array("user_auths" => ["permission"=>$user_permission, "add"=>$user_add, "edit"=>$user_edit, "read"=>$user_read, "delete"=>$user_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr1);

        // Settings
        if (isset($_POST["set_permission"])) { $set_permission = $_POST["set_permission"]; } else{ $set_permission = 0; } 
        if (isset($_POST["set_add"])) { $set_add = $_POST["set_add"]; } else{ $set_add = 0; }
        if (isset($_POST["set_edit"])) { $set_edit = $_POST["set_edit"]; } else{ $set_edit = 0; }
        if (isset($_POST["set_read"])) { $set_read = $_POST["set_read"]; } else{ $set_read = 0; }
        if (isset($_POST["set_delete"])) { $set_delete = $_POST["set_delete"]; } else{ $set_delete = 0; }
        $page = "settings_page";
        $new_arr2 = array("set_auths" => ["permission"=>$set_permission, "add"=>$set_add, "edit"=>$set_edit, "read"=>$set_read, "delete"=>$set_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr2);

        // news
        if (isset($_POST["news_permission"])) { $news_permission = $_POST["news_permission"]; } else{ $news_permission = 0; } 
        if (isset($_POST["news_add"])) { $news_add = $_POST["news_add"]; } else{ $news_add = 0; }
        if (isset($_POST["news_edit"])) { $news_edit = $_POST["news_edit"]; } else{ $news_edit = 0; }
        if (isset($_POST["news_read"])) { $news_read = $_POST["news_read"]; } else{ $news_read = 0; }
        if (isset($_POST["news_delete"])) { $news_delete = $_POST["news_delete"]; } else{ $news_delete = 0; }
        $page = "news_page";
        $new_arr3 = array("news_auths" => ["permission"=>$news_permission, "add"=>$news_add, "edit"=>$news_edit, "read"=>$news_read, "delete"=>$news_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr3);

        // blog
        if (isset($_POST["blog_permission"])) { $blog_permission = $_POST["blog_permission"]; } else{ $blog_permission = 0; } 
        if (isset($_POST["blog_add"])) { $blog_add = $_POST["blog_add"]; } else{ $blog_add = 0; }
        if (isset($_POST["blog_edit"])) { $blog_edit = $_POST["blog_edit"]; } else{ $blog_edit = 0; }
        if (isset($_POST["blog_read"])) { $blog_read = $_POST["blog_read"]; } else{ $blog_read = 0; }
        if (isset($_POST["blog_delete"])) { $blog_delete = $_POST["blog_delete"]; } else{ $blog_delete = 0; }
        $page = "blog_page";
        $new_arr4 = array("blog_auths" => ["permission"=>$blog_permission, "add"=>$blog_add, "edit"=>$blog_edit, "read"=>$blog_read, "delete"=>$blog_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr4);

        // gallery
        if (isset($_POST["gal_permission"])) { $gal_permission = $_POST["gal_permission"]; } else{ $gal_permission = 0; } 
        if (isset($_POST["gal_add"])) { $gal_add = $_POST["gal_add"]; } else{ $gal_add = 0; }
        if (isset($_POST["gal_edit"])) { $gal_edit = $_POST["gal_edit"]; } else{ $gal_edit = 0; }
        if (isset($_POST["gal_read"])) { $gal_read = $_POST["gal_read"]; } else{ $gal_read = 0; }
        if (isset($_POST["gal_delete"])) { $gal_delete = $_POST["gal_delete"]; } else{ $gal_delete = 0; }
        $page = "gallery_page";
        $new_arr5 = array("gal_auths" => ["permission"=>$gal_permission, "add"=>$gal_add, "edit"=>$gal_edit, "read"=>$gal_read, "delete"=>$gal_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr5);

        // media
        if (isset($_POST["med_permission"])) { $med_permission = $_POST["med_permission"]; } else{ $med_permission = 0; } 
        if (isset($_POST["med_add"])) { $med_add = $_POST["med_add"]; } else{ $med_add = 0; }
        if (isset($_POST["med_edit"])) { $med_edit = $_POST["med_edit"]; } else{ $med_edit = 0; }
        if (isset($_POST["med_read"])) { $med_read = $_POST["med_read"]; } else{ $med_read = 0; }
        if (isset($_POST["med_delete"])) { $med_delete = $_POST["med_delete"]; } else{ $med_delete = 0; }
        $page = "media_page";
        $new_arr6 = array("med_auths" => ["permission"=>$med_permission, "add"=>$med_add, "edit"=>$med_edit, "read"=>$med_read, "delete"=>$med_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr6);

        // Events
        if (isset($_POST["eve_permission"])) { $eve_permission = $_POST["eve_permission"]; } else{ $eve_permission = 0; } 
        if (isset($_POST["eve_add"])) { $eve_add = $_POST["eve_add"]; } else{ $eve_add = 0; }
        if (isset($_POST["eve_edit"])) { $eve_edit = $_POST["eve_edit"]; } else{ $eve_edit = 0; }
        if (isset($_POST["eve_read"])) { $eve_read = $_POST["eve_read"]; } else{ $eve_read = 0; }
        if (isset($_POST["eve_delete"])) { $eve_delete = $_POST["eve_delete"]; } else{ $eve_delete = 0; }
        $page = "event_page";
        $new_arr7 = array("eve_auths" => ["permission"=>$eve_permission, "add"=>$eve_add, "edit"=>$eve_edit, "read"=>$eve_read, "delete"=>$eve_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr7);

        // advert
        if (isset($_POST["adv_permission"])) { $adv_permission = $_POST["adv_permission"]; } else{ $adv_permission = 0; } 
        if (isset($_POST["adv_add"])) { $adv_add = $_POST["adv_add"]; } else{ $adv_add = 0; }
        if (isset($_POST["adv_edit"])) { $adv_edit = $_POST["adv_edit"]; } else{ $adv_edit = 0; }
        if (isset($_POST["adv_read"])) { $adv_read = $_POST["adv_read"]; } else{ $adv_read = 0; }
        if (isset($_POST["adv_delete"])) { $adv_delete = $_POST["adv_delete"]; } else{ $adv_delete = 0; }
        $page = "advert_page";
        $new_arr8 = array("adv_auths" => ["permission"=>$adv_permission, "add"=>$adv_add, "edit"=>$adv_edit, "read"=>$adv_read, "delete"=>$adv_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr8);

        // sales
        if (isset($_POST["sal_permission"])) { $sal_permission = $_POST["sal_permission"]; } else{ $sal_permission = 0; } 
        if (isset($_POST["sal_add"])) { $sal_add = $_POST["sal_add"]; } else{ $sal_add = 0; }
        if (isset($_POST["sal_edit"])) { $sal_edit = $_POST["sal_edit"]; } else{ $sal_edit = 0; }
        if (isset($_POST["sal_read"])) { $sal_read = $_POST["sal_read"]; } else{ $sal_read = 0; }
        if (isset($_POST["sal_delete"])) { $sal_delete = $_POST["sal_delete"]; } else{ $sal_delete = 0; }
        $page = "sales_page";
        $new_arr9 = array("sal_auths" => ["permission"=>$sal_permission, "add"=>$sal_add, "edit"=>$sal_edit, "read"=>$sal_read, "delete"=>$sal_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr9);

        // contact
        if (isset($_POST["con_permission"])) { $con_permission = $_POST["con_permission"]; } else{ $con_permission = 0; } 
        if (isset($_POST["con_add"])) { $con_add = $_POST["con_add"]; } else{ $con_add = 0; }
        if (isset($_POST["con_edit"])) { $con_edit = $_POST["con_edit"]; } else{ $con_edit = 0; }
        if (isset($_POST["con_read"])) { $con_read = $_POST["con_read"]; } else{ $con_read = 0; }
        if (isset($_POST["con_delete"])) { $con_delete = $_POST["con_delete"]; } else{ $con_delete = 0; }
        $page = "contacts_page";
        $new_arr10 = array("con_auths" => ["permission"=>$con_permission, "add"=>$con_add, "edit"=>$con_edit, "read"=>$con_read, "delete"=>$con_delete, "page"=>$page]);
        array_push($pages_permitted, $new_arr10);

        if(empty($errorMSG))
        {
            // Insert user data into user table
            $hashed_user_password = password_hash($add_user_password, PASSWORD_DEFAULT);
            $stmt03 =  $db_connect->prepare("  
            INSERT INTO users (user_code, user_fname, user_lname, user_email, user_password, user_account_type, user_account, user_active_status, user_online_status, user_profile_pic, created_at) 
            VALUES (:ususer_code, :ususer_fname, :ususer_lname, :ususer_email, :ususer_password, :ususer_account_type, :ususer_account, :ususer_active_status, :ususer_online_status, :ususer_profile_pic, :uscreated_at) ");
            $result03 = $stmt03->execute(
                array(
                    ':ususer_code'           => $add_user_code,
                    ':ususer_fname'          => $add_user_fname,
                    ':ususer_lname'          => $add_user_lname,
                    ':ususer_email'          => $add_user_email,
                    ':ususer_password'       => $hashed_user_password,
                    ':ususer_account_type'   => $add_user_account_type,
                    ':ususer_account'        => $add_user_account,
                    ':ususer_active_status'  => $add_user_active_status,
                    ':ususer_online_status'  => $add_user_online_status,
                    ':ususer_profile_pic'    => $add_image,
                    ':uscreated_at'          => $add_created_at
                )
            );

            // Insert foreach permitted values into permission table
            foreach($pages_permitted as $pg_perm){
                foreach($pg_perm as $permitted){
                    $perm_action_permitted = $permitted['permission'];
                    $perm_page_permitted = $permitted['page'];
                    $perm_add = $permitted['add'];
                    $perm_edit = $permitted['edit'];
                    $perm_read = $permitted['read'];
                    $perm_delete = $permitted['delete'];
                }

                $stmt04 =  $db_connect->prepare("  
                INSERT INTO permissions (perm_user_code, perm_page_permitted, perm_action_permitted, perm_add, perm_edit, perm_read, perm_delete, perm_created_at) 
                VALUES (:pperm_user_code, :pperm_page_permitted, :pperm_action_permitted, :pperm_add, :pperm_edit, :pperm_read, :pperm_delete, :pperm_created_at ) ");
                $result04 = $stmt04->execute(
                    array(
                        ':pperm_user_code' => $add_user_code,
                        ':pperm_page_permitted' => $perm_page_permitted,
                        ':pperm_action_permitted' => $perm_action_permitted,
                        ':pperm_add' => $perm_add,
                        ':pperm_edit' => $perm_edit,
                        ':pperm_read' => $perm_read,
                        ':pperm_delete' => $perm_delete,
                        ':pperm_created_at' => $add_created_at
                    )
                );
            }

            if(!empty($result03) && !empty($result04))
            {
                // Record activity history
                $action = $user_full_name." added a user by name ".$add_user_fname." ".$add_user_lname;
                $act_status = "added";
                log_history($neo_user_code, $action, $act_status);

                $msg = "New user has been added successfully";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }

            $errorMSG = "There was an error creating a new system user";
                
        }
        else {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }
    
    // Edit user query
    if(isset($_POST['ed_user_code']) && !empty($_POST['ed_user_code']))
    {
        $errorMSG                   = "";
        $edit_user_code             = $_POST['ed_user_code'];
        $edit_user_fname            = $_POST['ed_user_fname'];
        $edit_user_lname            = $_POST['ed_user_lname'];
        $edit_user_email            = $_POST['ed_user_email'];
        $edit_user_password         = $_POST['ed_user_password'];
        $edit_confirm_user_password = $_POST['ed_confirm_user_password'];
        $edit_user_account          = $_POST['ed_user_account'];
        $edit_user_active_status    = $_POST['ed_user_active_status'];
        $edit_hidden_user_pic       = $_POST['ed_hidden_user_pic'];

        if ($edit_user_fname == "") {
            $errorMSG = " First name is required. Please fill it ";
        }
        if ($edit_user_lname == "") {
            $errorMSG = " Last name is required. Please fill it ";
        }
        else if ($edit_user_account == '') {
            $errorMSG = " Account is required. Please fill it ";
        }

        else if ($edit_user_account == 'user' && $_POST['ed_user_account_type'] == "") {
            $errorMSG = "User accounts should have an assigned account type.";
        }
        else if ($edit_user_account == 'super') {
            $edit_user_account_type = "super";
        }
        else if ($edit_user_account == 'user' && $_POST['ed_user_account_type'] != ""){
            $edit_user_account_type = $_POST['ed_user_account_type'];
        }

        
        // Select original password from database
        $sel_pwd = $db_connect->prepare('SELECT user_password FROM users WHERE user_code =:usid');
        $sel_pwd->bindParam(':usid',$edit_user_code);
        $sel_pwd->execute();
        while($pwd_row=$sel_pwd->fetch(PDO::FETCH_ASSOC))
        {
            extract($pwd_row);
            $original_user_password = $pwd_row['user_password'];
        }

        // Password verification and look up
        if (empty($edit_user_password) && empty($edit_confirm_user_password)) {
            $hashed_user_password = $original_user_password;
        }
        else if (!empty($edit_user_password) && ($edit_user_password != $edit_confirm_user_password)) {
            $errorMSG = " Password does not match confirmation password. Please try again ";
        }
        else if (!empty($edit_user_password) && ($edit_user_password == $edit_confirm_user_password)) {
            $hashed_user_password = password_hash($edit_user_password, PASSWORD_DEFAULT);
        }

        // Email verification and look up
        else if ($edit_user_email == '') {
            $errorMSG = "Email is required. Please fill it ";
        }
        else if(!filter_var($edit_user_email, FILTER_VALIDATE_EMAIL)) {
            $errorMSG = "Invalid email format";
        }
        
        $stmt_email=$db_connect->prepare("SELECT user_code, user_email FROM users WHERE user_email=:usemail AND user_code !=:uspuser_code ");
        $stmt_email->execute(array(':usemail'=>$edit_user_email, ':uspuser_code'=>$edit_user_code));
        $row_email=$stmt_email->fetch(PDO::FETCH_ASSOC);
        if($stmt_email->rowCount() > 0)
        {
            $errorMSG = "This email is identified with another account.";
        }
        else {
            $new_edit_user_email = $_POST["ed_user_email"];
        }
        // End Email verification and look up

        // Image insert
        $image = "";
        $ref_code = $edit_user_code;
        $image_url = UPLOADING_PATH."users/";

        if($_FILES["ed_user_image"]["name"] != '')
        {
            removeImage("user_profile_pic", $image_url, $ref_code);
            $image = upload_image("ed_user_image", $image_url);
        } 
        else{
            $image = $_POST['ed_hidden_user_pic'];
        }
        // End Image insert

        // Pages Permitted
        $pages_permitted02 = [];
        // User
        if (isset($_POST["ed_user_permission"])) { $user_permission = $_POST["ed_user_permission"]; } else{ $user_permission = 0; } 
        if (isset($_POST["ed_user_add"])) { $user_add = $_POST["ed_user_add"]; } else{ $user_add = 0; }
        if (isset($_POST["ed_user_edit"])) { $user_edit = $_POST["ed_user_edit"]; } else{ $user_edit = 0; }
        if (isset($_POST["ed_user_read"])) { $user_read = $_POST["ed_user_read"]; } else{ $user_read = 0; }
        if (isset($_POST["ed_user_delete"])) { $user_delete = $_POST["ed_user_delete"]; } else{ $user_delete = 0; }
        $page = "users_page";
        $new_arr1 = array("user_auths" => ["permission"=>$user_permission, "add"=>$user_add, "edit"=>$user_edit, "read"=>$user_read, "delete"=>$user_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr1);
        // Settings
        if (isset($_POST["ed_set_permission"])) { $set_permission = $_POST["ed_set_permission"]; } else{ $set_permission = 0; } 
        if (isset($_POST["ed_set_add"])) { $set_add = $_POST["ed_set_add"]; } else{ $set_add = 0; }
        if (isset($_POST["ed_set_edit"])) { $set_edit = $_POST["ed_set_edit"]; } else{ $set_edit = 0; }
        if (isset($_POST["ed_set_read"])) { $set_read = $_POST["ed_set_read"]; } else{ $set_read = 0; }
        if (isset($_POST["ed_set_delete"])) { $set_delete = $_POST["ed_set_delete"]; } else{ $set_delete = 0; }
        $page = "settings_page";
        $new_arr2 = array("set_auths" => ["permission"=>$set_permission, "add"=>$set_add, "edit"=>$set_edit, "read"=>$set_read, "delete"=>$set_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr2);

        // news
        if (isset($_POST["ed_news_permission"])) { $news_permission = $_POST["ed_news_permission"]; } else{ $news_permission = 0; } 
        if (isset($_POST["ed_news_add"])) { $news_add = $_POST["ed_news_add"]; } else{ $news_add = 0; }
        if (isset($_POST["ed_news_edit"])) { $news_edit = $_POST["ed_news_edit"]; } else{ $news_edit = 0; }
        if (isset($_POST["ed_news_read"])) { $news_read = $_POST["ed_news_read"]; } else{ $news_read = 0; }
        if (isset($_POST["ed_news_delete"])) { $news_delete = $_POST["ed_news_delete"]; } else{ $news_delete = 0; }
        $page = "news_page";
        $new_arr3 = array("news_auths" => ["permission"=>$news_permission, "add"=>$news_add, "edit"=>$news_edit, "read"=>$news_read, "delete"=>$news_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr3);

        // blog
        if (isset($_POST["ed_blog_permission"])) { $blog_permission = $_POST["ed_blog_permission"]; } else{ $blog_permission = 0; } 
        if (isset($_POST["ed_blog_add"])) { $blog_add = $_POST["ed_blog_add"]; } else{ $blog_add = 0; }
        if (isset($_POST["ed_blog_edit"])) { $blog_edit = $_POST["ed_blog_edit"]; } else{ $blog_edit = 0; }
        if (isset($_POST["ed_blog_read"])) { $blog_read = $_POST["ed_blog_read"]; } else{ $blog_read = 0; }
        if (isset($_POST["ed_blog_delete"])) { $blog_delete = $_POST["ed_blog_delete"]; } else{ $blog_delete = 0; }
        $page = "blog_page";
        $new_arr4 = array("blog_auths" => ["permission"=>$blog_permission, "add"=>$blog_add, "edit"=>$blog_edit, "read"=>$blog_read, "delete"=>$blog_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr4);

        // gallery
        if (isset($_POST["ed_gal_permission"])) { $gal_permission = $_POST["ed_gal_permission"]; } else{ $gal_permission = 0; } 
        if (isset($_POST["ed_gal_add"])) { $gal_add = $_POST["ed_gal_add"]; } else{ $gal_add = 0; }
        if (isset($_POST["ed_gal_edit"])) { $gal_edit = $_POST["ed_gal_edit"]; } else{ $gal_edit = 0; }
        if (isset($_POST["ed_gal_read"])) { $gal_read = $_POST["ed_gal_read"]; } else{ $gal_read = 0; }
        if (isset($_POST["ed_gal_delete"])) { $gal_delete = $_POST["ed_gal_delete"]; } else{ $gal_delete = 0; }
        $page = "gallery_page";
        $new_arr5 = array("gal_auths" => ["permission"=>$gal_permission, "add"=>$gal_add, "edit"=>$gal_edit, "read"=>$gal_read, "delete"=>$gal_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr5);

        // media
        if (isset($_POST["ed_med_permission"])) { $med_permission = $_POST["ed_med_permission"]; } else{ $med_permission = 0; } 
        if (isset($_POST["ed_med_add"])) { $med_add = $_POST["ed_med_add"]; } else{ $med_add = 0; }
        if (isset($_POST["ed_med_edit"])) { $med_edit = $_POST["ed_med_edit"]; } else{ $med_edit = 0; }
        if (isset($_POST["ed_med_read"])) { $med_read = $_POST["ed_med_read"]; } else{ $med_read = 0; }
        if (isset($_POST["ed_med_delete"])) { $med_delete = $_POST["ed_med_delete"]; } else{ $med_delete = 0; }
        $page = "media_page";
        $new_arr6 = array("med_auths" => ["permission"=>$med_permission, "add"=>$med_add, "edit"=>$med_edit, "read"=>$med_read, "delete"=>$med_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr6);

        // Events
        if (isset($_POST["ed_eve_permission"])) { $eve_permission = $_POST["ed_eve_permission"]; } else{ $eve_permission = 0; } 
        if (isset($_POST["ed_eve_add"])) { $eve_add = $_POST["ed_eve_add"]; } else{ $eve_add = 0; }
        if (isset($_POST["ed_eve_edit"])) { $eve_edit = $_POST["ed_eve_edit"]; } else{ $eve_edit = 0; }
        if (isset($_POST["ed_eve_read"])) { $eve_read = $_POST["ed_eve_read"]; } else{ $eve_read = 0; }
        if (isset($_POST["ed_eve_delete"])) { $eve_delete = $_POST["ed_eve_delete"]; } else{ $eve_delete = 0; }
        $page = "event_page";
        $new_arr7 = array("eve_auths" => ["permission"=>$eve_permission, "add"=>$eve_add, "edit"=>$eve_edit, "read"=>$eve_read, "delete"=>$eve_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr7);

        // advert
        if (isset($_POST["ed_adv_permission"])) { $adv_permission = $_POST["ed_adv_permission"]; } else{ $adv_permission = 0; } 
        if (isset($_POST["ed_adv_add"])) { $adv_add = $_POST["ed_adv_add"]; } else{ $adv_add = 0; }
        if (isset($_POST["ed_adv_edit"])) { $adv_edit = $_POST["ed_adv_edit"]; } else{ $adv_edit = 0; }
        if (isset($_POST["ed_adv_read"])) { $adv_read = $_POST["ed_adv_read"]; } else{ $adv_read = 0; }
        if (isset($_POST["ed_adv_delete"])) { $adv_delete = $_POST["ed_adv_delete"]; } else{ $adv_delete = 0; }
        $page = "advert_page";
        $new_arr8 = array("adv_auths" => ["permission"=>$adv_permission, "add"=>$adv_add, "edit"=>$adv_edit, "read"=>$adv_read, "delete"=>$adv_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr8);

        // sales
        if (isset($_POST["ed_sal_permission"])) { $sal_permission = $_POST["ed_sal_permission"]; } else{ $sal_permission = 0; } 
        if (isset($_POST["ed_sal_add"])) { $sal_add = $_POST["ed_sal_add"]; } else{ $sal_add = 0; }
        if (isset($_POST["ed_sal_edit"])) { $sal_edit = $_POST["ed_sal_edit"]; } else{ $sal_edit = 0; }
        if (isset($_POST["ed_sal_read"])) { $sal_read = $_POST["ed_sal_read"]; } else{ $sal_read = 0; }
        if (isset($_POST["ed_sal_delete"])) { $sal_delete = $_POST["ed_sal_delete"]; } else{ $sal_delete = 0; }
        $page = "sales_page";
        $new_arr9 = array("sal_auths" => ["permission"=>$sal_permission, "add"=>$sal_add, "edit"=>$sal_edit, "read"=>$sal_read, "delete"=>$sal_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr9);

        // contact
        if (isset($_POST["ed_con_permission"])) { $con_permission = $_POST["ed_con_permission"]; } else{ $con_permission = 0; } 
        if (isset($_POST["ed_con_add"])) { $con_add = $_POST["ed_con_add"]; } else{ $con_add = 0; }
        if (isset($_POST["ed_con_edit"])) { $con_edit = $_POST["ed_con_edit"]; } else{ $con_edit = 0; }
        if (isset($_POST["ed_con_read"])) { $con_read = $_POST["ed_con_read"]; } else{ $con_read = 0; }
        if (isset($_POST["ed_con_delete"])) { $con_delete = $_POST["ed_con_delete"]; } else{ $con_delete = 0; }
        $page = "contacts_page";
        $new_arr10 = array("con_auths" => ["permission"=>$con_permission, "add"=>$con_add, "edit"=>$con_edit, "read"=>$con_read, "delete"=>$con_delete, "page"=>$page]);
        array_push($pages_permitted02, $new_arr10);

        // Execute Query
        if(empty($errorMSG))
        {
            $stmt02 =  $db_connect->prepare("  
            UPDATE users SET user_fname =:ususer_fname, user_lname =:ususer_lname, user_email =:ususer_email, user_password =:ususer_password, user_account_type =:ususer_account_type, user_account=:ususer_account, user_active_status =:ususer_active_status, user_profile_pic =:ususer_profile_pic, updated_at =:usupdated_at WHERE user_code=:ususer_code ");
            $result02 = $stmt02->execute(
                array(
                    ':ususer_code'          => $edit_user_code,
                    ':ususer_fname'         => $edit_user_fname,
                    ':ususer_lname'         => $edit_user_lname,
                    ':ususer_email'         => $new_edit_user_email,
                    ':ususer_password'      => $hashed_user_password,
                    ':ususer_account_type'  => $edit_user_account_type,
                    ':ususer_account'       => $edit_user_account,
                    ':ususer_active_status' => $edit_user_active_status,
                    ':ususer_profile_pic'   => $image,
                    ':usupdated_at'         => date('Y-m-d H:i:s')
                )
            );

            // Update foreach permitted values in permission table
            foreach($pages_permitted02 as $pg_perm){
                foreach($pg_perm as $permitted){
                    $perm_action_permitted = $permitted['permission'];
                    $perm_page_permitted = $permitted['page'];
                    $perm_add = $permitted['add'];
                    $perm_edit = $permitted['edit'];
                    $perm_read = $permitted['read'];
                    $perm_delete = $permitted['delete'];

                    //search permission by perm_page_permitted and  perm_user_code if exists then update else insert
                    $sql01 = $db_connect->prepare("SELECT perm_user_code, perm_page_permitted FROM permissions WHERE perm_page_permitted='$perm_page_permitted' AND perm_user_code='$edit_user_code' LIMIT 1 ");
                    $sql01->execute();
                    if($sql01->rowCount() > 0) { 
                        $stmt05 =  $db_connect->prepare("  
                        UPDATE permissions SET perm_action_permitted=:pperm_action_permitted, perm_add=:pperm_add, perm_edit=:pperm_edit, perm_read=:pperm_read, perm_delete=:pperm_delete, perm_updated_at=:pperm_updated_at WHERE perm_page_permitted=:pperm_page_permitted AND perm_user_code=:pperm_user_code ");
                        $result05 = $stmt05->execute(
                            array(
                                ':pperm_user_code' => $edit_user_code,
                                ':pperm_page_permitted' => $perm_page_permitted,
                                ':pperm_action_permitted' => $perm_action_permitted,
                                ':pperm_add' => $perm_add,
                                ':pperm_edit' => $perm_edit,
                                ':pperm_read' => $perm_read,
                                ':pperm_delete' => $perm_delete,
                                ':pperm_updated_at' => date('Y-m-d H:i:s')
                            )
                        );
                    } 
                    else {
                        $stmt05 =  $db_connect->prepare("  
                        INSERT INTO permissions (perm_user_code, perm_page_permitted, perm_action_permitted, perm_add, perm_edit, perm_read, perm_delete, perm_created_at) 
                        VALUES (:pperm_user_code, :pperm_page_permitted, :pperm_action_permitted, :pperm_add, :pperm_edit, :pperm_read, :pperm_delete, :pperm_created_at ) ");
                        $result05 = $stmt05->execute(
                            array(
                                ':pperm_user_code' => $edit_user_code,
                                ':pperm_page_permitted' => $perm_page_permitted,
                                ':pperm_action_permitted' => $perm_action_permitted,
                                ':pperm_add' => $perm_add,
                                ':pperm_edit' => $perm_edit,
                                ':pperm_read' => $perm_read,
                                ':pperm_delete' => $perm_delete,
                                ':pperm_created_at' => date('Y-m-d H:i:s')
                            )
                        );
                    }
                }
            }

            if(!empty($result02) && !empty($result05))
            {
                // Record activity history
                $action = $user_full_name." edited a user by name ".$edit_user_fname." ".$edit_user_lname;
                $act_status = "edited";
                log_history($neo_user_code, $action, $act_status);

                $msg = "You have successfully updated this user";
                echo json_encode(['code'=>200, 'msg'=>$msg]);
                exit;
            }     
        }
        else 
        {
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }
        // End Execute Query

    }

    // Activate and deactivate user
    else if(isset($_POST['up_user_code']))
    {
        $up_user_code = $_POST['up_user_code'];
        $up_user_active_status     = $_POST['up_user_active_status'];

        if ($up_user_active_status == 1){ $new_user_active_status = 0; } else { $new_user_active_status = 1; }

        $stmt01 =  $db_connect->prepare("  
        UPDATE users SET user_active_status =:upuser_active_status, updated_at=:upupdated_at WHERE user_code=:upuser_code ");
        $result01 = $stmt01->execute(
            array(
                ':upuser_code'     => $up_user_code,
                ':upuser_active_status' => $new_user_active_status,
                ':upupdated_at'         => date('Y-m-d H:i:s')
            )
        );

        if(!empty($result01))
        {
            // Record activity history
            $action = $user_full_name." changed the status of a user with ID: ".$up_user_code;
            $act_status = "changed status";
            log_history($neo_user_code, $action, $act_status);

            if ($new_user_active_status == 0) {
                $msg = "The user was disabled successfully.";
            } else {
                $msg = "The user was enabled successfully.";
            }
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "The status of the user could not be changed";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }


    // Delete user
    else if(isset($_POST['del_user_code']))
    {

        $del_user_code = $_POST['del_user_code'];
        // fetch image name
        $stmt_select = $db_connect->prepare('SELECT user_profile_pic FROM users WHERE user_code =:delid');
        $stmt_select->bindParam(':delid',$del_user_code);
        $stmt_select->execute();
        while($del_row=$stmt_select->fetch(PDO::FETCH_ASSOC))
        {
            extract($del_row);
            $imgRow = $del_row['user_profile_pic'];
        }
        
        // remove image from directory
        if ($imgRow != "") 
        {
            unlink(UPLOADING_PATH."users/".$imgRow);
            $stmt_delete = $db_connect->prepare('DELETE FROM users WHERE user_code =:delid');
            $stmt_delete->bindParam(':delid',$del_user_code);
            $success_delete  = $stmt_delete->execute(); 

            $stmt_delete1 = $db_connect->prepare('DELETE FROM permissions WHERE perm_user_code =:delid');
            $stmt_delete1->bindParam(':delid',$del_user_code);
            $success_delete1  = $stmt_delete1->execute(); 
        }
        else 
        {       
            $stmt_delete = $db_connect->prepare('DELETE FROM users WHERE user_code =:delid');
            $stmt_delete->bindParam(':delid',$del_user_code);
            $success_delete  = $stmt_delete->execute(); 

            $stmt_delete1 = $db_connect->prepare('DELETE FROM permissions WHERE perm_user_code =:delid');
            $stmt_delete1->bindParam(':delid',$del_user_code);
            $success_delete1  = $stmt_delete1->execute(); 
        }
        // delete imafe name from database

        if($success_delete)
        {
            // Record activity history
            $action = $user_full_name." deleted a user with ID: ".$del_user_code;
            $act_status = "deleted";
            log_history($neo_user_code, $action, $act_status);

            $msg = "User was successfully deleted";
            echo json_encode(['code'=>200, 'msg'=>$msg]);
            exit;
        }
        else {
            $errorMSG = "User could not be deleted";
            echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
            exit;
        }

    }

    elseif (isset($_POST['user_fname']) && empty($_POST['user_fname'])) {
        exit;
    }
    else {
        $errorMSG = "Error while performing this action. Make sure user first and last names are not empty";
        echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
        exit;
    }

 

?>