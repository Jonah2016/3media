<?php


class Ads extends DB_CONN
{

    protected function read($adverts_id)
    {
        try {
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT adverts_title, adverts_category, adverts_dimension, adverts_cover_image, adverts_type, adverts_url, adverts_start_date, adverts_end_date FROM adverts_posts WHERE adverts_active_status=1 AND adverts_id=:xadverts_id LIMIT 1 ");
            $s_stmt->execute(array(':xadverts_id'=>$adverts_id));
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }
           
            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxADSR: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return ['code'=>404, 'msg'=>$error];
        exit();
    }

    protected function readAdByParam($date_now, $adverts_category, $adverts_dimension, $adverts_type)
    {
        try {
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT adverts_title, adverts_category, adverts_dimension, adverts_cover_image, adverts_type, adverts_url, adverts_start_date, adverts_end_date FROM adverts_posts WHERE adverts_active_status=1 AND ('{$date_now}' BETWEEN DATE(adverts_start_date) AND DATE(adverts_end_date)) AND adverts_category=:xadverts_category AND adverts_dimension=:xadverts_dimension AND adverts_type=:xadverts_type ORDER BY adverts_id DESC LIMIT 20 ");
            $s_stmt->execute([
                ':xadverts_category'=>$adverts_category,
                ':xadverts_dimension'=>$adverts_dimension,
                ':xadverts_type'=>$adverts_type
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
            $error = 'E0x0000000CxADSRP: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return ['code'=>404, 'msg'=>$error];
        exit();
    }

    protected function readAll()
    {
        try {
            $s_stmt = $this->connect()->prepare("SELECT adverts_title, adverts_category, adverts_dimension, adverts_cover_image, adverts_type, adverts_url, adverts_start_date, adverts_end_date FROM adverts_posts WHERE adverts_active_status=1 ORDER BY adverts_id DESC LIMIT 350");
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
            $error = 'E0x0000000CxADSRA: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }
}
