<?php


class Video extends DB_CONN
{

    protected function read($vid_hashed)
    {
        try {
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT vid_id, vid_hashed, vid_category, vid_title, vid_description, vid_author, vid_img_caption, DATE_FORMAT(`vid_date`, '%M %D, %Y') AS formated_vid_date, vid_thumbnail, vid_youtube_url, vid_views_count FROM videos WHERE vid_active_status = 1 AND vid_hashed=:xvid_hashed LIMIT 1 ");
            $s_stmt->execute(array(':xvid_hashed'=>$vid_hashed));
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }
           
            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxVIDR: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readAllByCategory($already_displayed_ids, $vid_category)
    {
        try {
            if (($vid_category == null || $vid_category == "") && $already_displayed_ids != null) {
                $s_stmt = $this->connect()->prepare("SELECT vid_id, vid_hashed, vid_category, vid_title, vid_description, vid_author, vid_img_caption, DATE_FORMAT(`vid_date`, '%M %D, %Y') AS formated_vid_date, vid_thumbnail, vid_youtube_url, vid_views_count FROM videos WHERE vid_id NOT IN({$already_displayed_ids}) AND vid_active_status=1 ORDER BY vid_date DESC,vid_id  DESC LIMIT 350 ");
            } elseif (($vid_category != null && $vid_category != "") && $already_displayed_ids == null) {
                $s_stmt = $this->connect()->prepare("SELECT vid_id, vid_hashed, vid_category, vid_title, vid_description, vid_author, vid_img_caption, DATE_FORMAT(`vid_date`, '%M %D, %Y') AS formated_vid_date, vid_thumbnail, vid_youtube_url, vid_views_count FROM videos WHERE FIND_IN_SET('{$vid_category}', vid_category) AND vid_active_status=1 ORDER BY vid_date DESC,vid_id  DESC LIMIT 350 ");
            } else {
                $s_stmt = $this->connect()->prepare("SELECT vid_id, vid_hashed, vid_category, vid_title, vid_description, vid_author, vid_img_caption, DATE_FORMAT(`vid_date`, '%M %D, %Y') AS formated_vid_date, vid_thumbnail, vid_youtube_url, vid_views_count FROM videos WHERE vid_id NOT IN({$already_displayed_ids}) AND FIND_IN_SET('{$vid_category}', vid_category) AND vid_active_status=1 ORDER BY vid_date DESC,vid_id  DESC LIMIT 350 ");
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
            $error = 'E0x0000000CxVIDRAC: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readAll()
    {
        try {
            $s_stmt = $this->connect()->prepare("SELECT vid_id, vid_hashed, vid_category, vid_title, vid_description, vid_author, vid_img_caption, DATE_FORMAT(`vid_date`, '%M %D, %Y') AS formated_vid_date, vid_thumbnail, vid_youtube_url, vid_views_count FROM videos WHERE vid_active_status = 1 ORDER BY vid_date DESC,vid_id  DESC LIMIT 350 ");
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
            $error = 'E0x0000000CxVIDRA: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }
}
