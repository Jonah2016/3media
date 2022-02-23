<?php

    class Comment extends DB_CONN
    {
        protected function write($ncom_page_hashed, $ncom_type, $ncom_country, $ncom_post_hashed, $ncom_parent_hashed, $ncom_name, $ncom_content)
        {
            try {
                $ncom_active_status = 1;
                $ncom_created_at    = date('Y-m-d H:i:s');

                $a_stmt = $this->connect()->prepare("  
                    INSERT INTO news_comments (ncom_page_hashed, ncom_post_hashed, ncom_parent_hashed, ncom_name, ncom_content, ncom_type, ncom_country, ncom_active_status, ncom_created_at) 
                    VALUES (:xncom_page_hashed, :xncom_post_hashed, :xncom_parent_hashed, :xncom_name, :xncom_content, :xncom_type, :xncom_country, :xncom_active_status, :xncom_created_at) ");
                $result1 = $a_stmt->execute(
                    array(
                        ':xncom_page_hashed' => $ncom_page_hashed,
                        ':xncom_post_hashed' => $ncom_post_hashed,
                        ':xncom_parent_hashed' => $ncom_parent_hashed,
                        ':xncom_name' => $ncom_name,
                        ':xncom_content' => $ncom_content,
                        ':xncom_type' => $ncom_type,
                        ':xncom_country' => $ncom_country,
                        ':xncom_active_status' => $ncom_active_status,
                        ':xncom_created_at' => $ncom_created_at
                    )
                );

                if (!empty($result1)) {
                    // return success
                    $a_stmt  = null;
                    $success = "Hey, ".$ncom_name.", your comment has been added successfully.";
                    return ['code'=>200, 'msg'=>$success];
                    exit();
                }
            } catch (PDOException $e) {
                $error = 'E0x0000000CxCOMW: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $a_stmt = null;
            return ['code'=>404, 'msg'=>$error];
            exit();
        }

        protected function read($ncom_page_hashed)
        {
            try {
                $s_rows = null;
                $s_stmt = $this->connect()->prepare("SELECT ncom_page_hashed, ncom_post_hashed, ncom_parent_hashed, ncom_name, ncom_content, ncom_type, ncom_country, ncom_created_at FROM news_comments WHERE ncom_active_status=1 AND ncom_page_hashed=:xncom_page_hashed ");
                $s_stmt->execute(array(':xncom_page_hashed'=>$ncom_page_hashed));
                if ($s_stmt->rowCount() > 0) {
                    $s_rows=$s_stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $s_rows = [];
                }
               
                $s_stmt = null;
                return ['code'=>200, 'payload'=>$s_rows];
                return $s_rows;
                exit();
            } catch (PDOException $e) {
                $error = 'E0x0000000CxCOMR: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return ['code'=>404, 'msg'=>$error];
            exit();
        }

    }
