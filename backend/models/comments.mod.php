<?php

    require('../core/Auth.php');
    require_once(BACKEND_ROOT_PATH . 'classes/Comments.cl.php');
    require_once(BACKEND_ROOT_PATH . 'controllers/Comments.ctrl.php');

    // ================================= COMMENTS =======================================
    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "post_comment") {
        $ncom_page_hashed   = htmlspecialchars(strip_tags($_POST['vc_page_hashed']), ENT_QUOTES);
        $ncom_type          = htmlspecialchars(strip_tags($_POST['vc_type']), ENT_QUOTES);
        $ncom_country       = $global_class->getIPAddress();
        $ncom_post_hashed   = $global_class->generateRandomString(15);
        $ncom_parent_hashed = ($_POST['vc_parent_hashed'] != "") ? htmlspecialchars(strip_tags($_POST['vc_parent_hashed']), ENT_QUOTES) : "";
        $ncom_name          = htmlspecialchars(strip_tags($_POST['vc_name']), ENT_QUOTES);
        $ncom_content       = htmlspecialchars($_POST['vc_content'], ENT_QUOTES);

        $comments = new CommentController([
            'ncom_page_hashed'   => $ncom_page_hashed,
            'ncom_type'          => $ncom_type,
            'ncom_country'       => $ncom_country,
            'ncom_post_hashed'   => $ncom_post_hashed,
            'ncom_parent_hashed' => $ncom_parent_hashed,
            'ncom_name'          => $ncom_name,
            'ncom_content'       => $ncom_content
        ]);

        $result = $comments->addComment();
        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_comment") {
        $ncom_page_hashed = htmlspecialchars(strip_tags(trim($_POST['vc_page_hashed'])), ENT_QUOTES);
        $comments         = new CommentController(['ncom_page_hashed' => $ncom_page_hashed]);
        $result           = $comments->getComment();

        echo json_encode($result);
        exit();
    }
