<?php


class News extends DB_CONN
{

    protected function read($news_hashed)
    {
        try {

            $s_rows = null;
            $s_stmt = $this->connect()->prepare(" SELECT * FROM ( SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_cover_image, news_img_caption, news_created_by FROM news_posts WHERE news_hashed LIKE '%$news_hashed%' AND news_active_status=1 ) AS NWS JOIN ( SELECT user_profile_pic, user_code, user_fname, user_lname FROM users ) AS USR ON NWS.news_created_by=USR.user_code ");
            $s_stmt->execute();
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }
           
            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxNEWSR: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readAll()
    {
        try {
            $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE news_active_status = 1 ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            $s_stmt->execute();
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }

            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxNEWSRA: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readAllFeaturedNews()
    {
        try {
            $news_featured = "yes";
            $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE news_active_status = 1 AND news_featured = :xnews_featured ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            $s_stmt->execute([':xnews_featured' => $news_featured]);
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }

            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxNEWSRAF: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readFeaturedNewsByCategory($already_displayed_ids, $news_category)
    {
        try {
            $news_featured = "yes";
            if (($news_category == null || $news_category == "") && $already_displayed_ids != null) {
                $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE news_active_status = 1 AND news_featured = :xnews_featured AND news_id NOT IN({$already_displayed_ids})  ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            } elseif (($news_category != null && $news_category != "") && $already_displayed_ids == null) {
                $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE FIND_IN_SET('{$news_category}', news_category) AND news_active_status = 1 AND news_featured = :xnews_featured ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            } else {
                $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE news_id NOT IN({$already_displayed_ids}) AND FIND_IN_SET('{$news_category}', news_category) AND news_active_status = 1 AND news_featured = :xnews_featured ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            }

            $s_stmt->execute([':xnews_featured' => $news_featured]);
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }

            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxNEWSRAF: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readAllByCategory($already_displayed_ids, $news_category)
    {
        try {
            if (($news_category == null || $news_category == "") && $already_displayed_ids != null) {
                $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE news_id NOT IN({$already_displayed_ids}) AND news_active_status=1 ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            } elseif (($news_category != null && $news_category != "") && $already_displayed_ids == null) {
                $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE FIND_IN_SET('{$news_category}', news_category) AND news_active_status=1 ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            } else {
                $s_stmt = $this->connect()->prepare("SELECT news_id, news_hashed, news_category, news_title, news_briefing, news_body, news_author, news_featured, news_date, news_img_caption, news_cover_image, news_views_count, DATE_FORMAT(`news_date`, '%M %D, %Y') AS formated_date, news_created_at FROM news_posts WHERE news_id NOT IN({$already_displayed_ids}) AND FIND_IN_SET('{$news_category}', news_category) AND news_active_status=1 ORDER BY news_date DESC,news_id  DESC LIMIT 350 ");
            }
            $s_stmt->execute();
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }

            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxNEWSRA: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readComments($search_param)
    {
        try {
            $s_rows = null;
            $ncom_type = "main";
            $s_stmt = $this->connect()->prepare("SELECT ncom_page_hashed, ncom_post_hashed, ncom_parent_hashed, ncom_name, ncom_content, ncom_type, ncom_country, ncom_created_at FROM news_comments WHERE ncom_type=:xncom_type AND ncom_active_status=1 AND ncom_page_hashed LIKE '%$search_param%' ORDER BY ncom_id DESC");
            $s_stmt->execute([':xncom_type' => $ncom_type]);
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchALl(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }
           
            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxNEWCOMPSR: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        $p_stmt = null;
        return $error;
        exit();
    }

    protected function readReplies($ncom_parent_hashed)
    {
        try {
            $ncom_type = "reply";
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT ncom_page_hashed, ncom_post_hashed, ncom_parent_hashed, ncom_name, ncom_content, ncom_type, ncom_country, ncom_created_at FROM news_comments WHERE ncom_type=:xncom_type AND ncom_active_status=1 AND ncom_parent_hashed= :xncom_parent_hashed ORDER BY ncom_id ASC");
            $s_stmt->execute([
                ':xncom_parent_hashed'=>$ncom_parent_hashed,
                ':xncom_type' => $ncom_type
            ]);
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }

            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxNEWREPR: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        $p_stmt = null;
        return $error;
        exit();
    }
}
