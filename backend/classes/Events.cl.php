<?php


class Event extends DB_CONN
{

    protected function read($eve_hashed)
    {
        try {
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT eve_id, eve_hashed, eve_name, eve_category, eve_description, eve_location, eve_map_location, eve_venue, eve_rating, eve_organiser, eve_organiser_logo, eve_fb_link, eve_twitter_link, eve_ig_link, eve_tags, eve_banner, eve_image1, eve_image2, eve_yt_video_link, eve_start_date, eve_end_date, eve_start_time, eve_end_time, eve_enable_ticket_sales, eve_ticket_hashed, eve_ticket_image, eve_audience, eve_ticket_name1, eve_ticket_price1, eve_ticket_quantity1, eve_ticket_name2, eve_ticket_price2, eve_ticket_quantity2, eve_ticket_name3, eve_ticket_price3, eve_ticket_quantity3, eve_ticket_name4, eve_ticket_price4, eve_ticket_quantity4, eve_start_sales_on, eve_ends_sales_on, eve_enable_ticket_sales, eve_ticket_desc1, eve_ticket_desc2, eve_ticket_desc3, eve_ticket_desc4, eve_enable_ticket_sales, eve_updated_at FROM event_posts WHERE eve_active_status=1 AND eve_hashed=:xeve_hashed LIMIT 1 ");
            $s_stmt->execute(array(':xeve_hashed'=>$eve_hashed));
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }
           
            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxEVER: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return ['code'=>404, 'msg'=>$error];
        exit();
    }

    protected function readAll()
    {
        try {
            $s_stmt = $this->connect()->prepare("SELECT eve_id, eve_hashed, eve_name, eve_category, eve_description, eve_location, eve_map_location, eve_venue, eve_rating, eve_organiser, eve_organiser_logo, eve_fb_link, eve_twitter_link, eve_ig_link, eve_tags, eve_banner, eve_image1, eve_image2, eve_yt_video_link, eve_start_date, eve_end_date, eve_start_time, eve_end_time, eve_enable_ticket_sales, eve_ticket_hashed, eve_ticket_image, eve_audience, eve_ticket_name1, eve_ticket_price1, eve_ticket_quantity1, eve_ticket_name2, eve_ticket_price2, eve_ticket_quantity2, eve_ticket_name3, eve_ticket_price3, eve_ticket_quantity3, eve_ticket_name4, eve_ticket_price4, eve_ticket_quantity4, eve_start_sales_on, eve_ends_sales_on FROM event_posts WHERE eve_active_status=1 ORDER BY eve_start_date DESC, eve_id DESC LIMIT 250");
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
            $error = 'E0x0000000CxEVERA: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return $error;
        exit();
    }

    protected function readEventTickets($eve_hashed)
    {
        try {
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT eve_hashed, eve_name, eve_category, eve_organiser, eve_ticket_hashed, eve_ticket_image, eve_ticket_name1, eve_ticket_desc1, eve_ticket_price1, eve_ticket_quantity1, eve_ticket_name2, eve_ticket_desc2, eve_ticket_price2, eve_ticket_quantity2, eve_ticket_name3, eve_ticket_desc3, eve_ticket_price3, eve_ticket_quantity3, eve_ticket_name4, eve_ticket_desc4, eve_ticket_price4, eve_ticket_quantity4, eve_start_sales_on, eve_ends_sales_on, eve_ticket_desc1, eve_ticket_desc2, eve_ticket_desc3, eve_ticket_desc4, eve_enable_ticket_sales FROM event_posts WHERE eve_active_status=1  AND eve_hashed=:xeve_hashed ORDER BY eve_start_date DESC, eve_id DESC LIMIT 150 ");
            $s_stmt->execute([':xeve_hashed'=>$eve_hashed]);
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }
           
            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxEVERP: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return ['code'=>404, 'msg'=>$error];
        exit();
    }

    protected function readTicketPayments($pay_hash_key)
    {
        try {
            $s_rows = null;
            $s_stmt = $this->connect()->prepare("SELECT pay_hash_key, pay_trans_reference, pay_trans_cus_code, pay_customer_id, transact_date, pay_event_hash, pay_ticket_name, pay_indiv_qty, pay_indiv_amt, pay_active_status, pay_created_at FROM ticket_payments WHERE pay_active_status=1 AND pay_hash_key=:xpay_hash_key LIMIT 1 ");
            $s_stmt->execute([':xpay_hash_key'=>$pay_hash_key]);
            if ($s_stmt->rowCount() > 0) {
                $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $s_rows = [];
            }
           
            $s_stmt = null;
            return $s_rows;
            exit();
        } catch (PDOException $e) {
            $error = 'E0x0000000CxPAYRP: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt = null;
        return ['code'=>404, 'msg'=>$error];
        exit();
    }
}
