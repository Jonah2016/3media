<?php

    class AwardCategory extends DB_CONN
    {
        protected function read($awc_id)
        {
            try {
                $s_rows = null;
                $s_stmt = $this->connect()->prepare("SELECT awc_id, awc_title, awc_year, awc_description, awc_cover_image FROM award_categories WHERE awc_active_status=1 AND awc_id=:xawc_id LIMIT 1 ");
                $s_stmt->execute(array(':xawc_id'=>$awc_id));
                if ($s_stmt->rowCount() > 0) {
                    $s_rows=$s_stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $s_rows = [];
                }
               
                $s_stmt = null;
                return $s_rows;
                exit();
            } catch (PDOException $e) {
                $error = 'E0x0000000CxAWCATR: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAll()
        {
            try {
                $s_stmt = $this->connect()->prepare("SELECT awc_id, awc_title, awc_year, awc_description, awc_cover_image FROM award_categories WHERE awc_active_status=1 ORDER BY awc_title ASC, awc_id DESC LIMIT 350");
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
                $error = 'E0x0000000CxAWCATRA: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAllByYear($year)
        {
            try {

                if($year != null)
                {
                    $src_year = htmlspecialchars(strip_tags($year), ENT_QUOTES);
                    $s_stmt = $this->connect()->prepare("SELECT awc_id, awc_title, awc_year, awc_description, awc_cover_image FROM award_categories WHERE awc_active_status=1 AND FIND_IN_SET('$src_year', awc_year) ORDER BY awc_title ASC, awc_id DESC LIMIT 350");
                }
                else {
                    $src_year = date('Y');
                    $s_stmt = $this->connect()->prepare("SELECT awc_id, awc_title, awc_year, awc_description, awc_cover_image FROM award_categories WHERE awc_active_status=1 AND FIND_IN_SET('$src_year', awc_year) ORDER BY awc_title ASC, awc_id DESC LIMIT 350"); 
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
                $error = 'E0x0000000CxAWCATRAC: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }
    }


    class AwardNominee extends DB_CONN
    {
        protected function read($awn_id)
        {
            try {
                $s_rows = null;
                $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status = 1 AND awn_id=:xawn_id LIMIT 1 ");
                $s_stmt->execute(array(':xawn_id'=>$awn_id));
                if ($s_stmt->rowCount() > 0) {
                    $s_rows=$s_stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $s_rows = [];
                }
               
                $s_stmt = null;
                return $s_rows;
                exit();
            } catch (PDOException $e) {
                $error = 'E0x0000000CxAWNR: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAll()
        {
            try {
                $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 ORDER BY awn_id DESC LIMIT 350");
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
                $error = 'E0x0000000CxAWNRA: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAllByCatYear($param, $awn_category, $query_type)
        {
            try {

                if($query_type == "by_nomination_year")
                {
                    $src_year = htmlspecialchars(strip_tags($param), ENT_QUOTES);
                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_category = '{$awn_category}' AND awn_year IN (".$src_year.") ORDER BY awn_fullname, awn_year DESC LIMIT 150");
                }
                elseif($query_type == "by_nomination_category")
                {
                    $src_qry      = explode(",", $param);
                    $src_category = "'" . implode("' , '", $src_qry) . "'";
                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_category = '{$awn_category}' AND awn_category IN (".$src_category.") ORDER BY awn_fullname, awn_year ASC");
                }
                elseif($query_type == "by_nomination_artiste")
                {
                    $src_qry     = explode("%,", $param);
                    $src_trim    = "'" . implode("' , '", $src_qry) . "'";
                    $src_artiste = str_replace('%', '', $src_trim);

                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_category = '{$awn_category}' AND awn_fullname IN (".$src_artiste.") ORDER BY awn_fullname, awn_year ASC");
                } 
                else {
                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_category = '{$awn_category}' AND (awn_year = YEAR(CURRENT_DATE)) ORDER BY awn_fullname, awn_year DESC LIMIT 150"); 
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
                $error = 'E0x0000000CxAWWRAC: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }
    }


    class AwardWinner extends DB_CONN
    {
        protected function read($awn_id)
        {
            try {
                $s_rows = null;
                $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_win_status = 1 AND awn_id=:xawn_id LIMIT 1 ");
                $s_stmt->execute(array(':xawn_id'=>$awn_id));
                if ($s_stmt->rowCount() > 0) {
                    $s_rows=$s_stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $s_rows = [];
                }
               
                $s_stmt = null;
                return $s_rows;
                exit();
            } catch (PDOException $e) {
                $error = 'E0x0000000CxWINR: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAll()
        {
            try {

                $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_win_status=1 ORDER BY awn_id DESC LIMIT 350");
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
                $error = 'E0x0000000CxWINRA: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAllByCatYear($param, $awn_category, $query_type)
        {
            try {

                if($query_type == "by_winner_year")
                {
                    $src_year = htmlspecialchars(strip_tags($param), ENT_QUOTES);
                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_category = '{$awn_category}' AND awn_win_status=1 AND awn_year IN (".$src_year.") ORDER BY awn_fullname, awn_year DESC LIMIT 150");
                }
                elseif($query_type == "by_winner_category")
                {
                    $src_qry      = explode(",", $param);
                    $src_category = "'" . implode("' , '", $src_qry) . "'";
                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_win_status=1 AND awn_category = '{$awn_category}' AND awn_category IN (".$src_category.") ORDER BY awn_fullname, awn_year ASC");
                }
                elseif($query_type == "by_winner_artiste")
                {
                    $src_qry     = explode("%,", $param);
                    $src_trim    = "'" . implode("' , '", $src_qry) . "'";
                    $src_artiste = str_replace('%', '', $src_trim);

                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_win_status=1 AND awn_category = '{$awn_category}' AND awn_fullname IN (".$src_artiste.") ORDER BY awn_fullname, awn_year ASC");
                } 
                else {
                    $s_stmt = $this->connect()->prepare("SELECT awn_id, awn_type, awn_category, awn_hashed, awn_cover_image, awn_fullname, awn_year, awn_biography, awn_active_status, awn_win_status FROM award_nominees WHERE awn_active_status=1 AND awn_win_status=1 AND awn_category = '{$awn_category}' AND (awn_year = YEAR(CURRENT_DATE)) ORDER BY awn_fullname, awn_year DESC LIMIT 150"); 
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
                $error = 'E0x0000000CxWINRAC: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }
    }


    class AwardPerformer extends DB_CONN
    {
        protected function read($awp_id)
        {
            try {
                $s_rows = null;
                $s_stmt = $this->connect()->prepare("SELECT awp_ip, awp_hashed, awp_image, awp_fullname, awp_year, awp_description, awp_active_status FROM award_performers WHERE awp_active_status=1 AND awp_id=:xawp_id LIMIT 1 ");
                $s_stmt->execute(array(':xawp_id'=>$awp_id));
                if ($s_stmt->rowCount() > 0) {
                    $s_rows=$s_stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $s_rows = [];
                }
                $s_stmt = null;
                return $s_rows;
                exit();
            } catch (PDOException $e) {
                $error = 'E0x0000000CxPERFR: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAll()
        {
            try {
                $s_stmt = $this->connect()->prepare("SELECT awp_ip, awp_hashed, awp_image, awp_fullname, awp_year, awp_description, awp_active_status FROM award_performers WHERE awp_active_status=1 ORDER BY awp_id DESC LIMIT 350");
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
                $error = 'E0x0000000CxPERFRA: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }

        protected function readAllByCatYear($param, $awp_category, $query_type)
        {
            try {

                if($query_type == "by_performing_year")
                {
                    $src_year = htmlspecialchars(strip_tags($param), ENT_QUOTES);
                    $s_stmt = $this->connect()->prepare("SELECT awp_ip, awp_hashed, awp_image, awp_fullname, awp_year, awp_description, awp_active_status FROM award_performers WHERE awp_active_status=1 AND awp_category = '{$awp_category}' AND awn_year IN (".$src_year.") ORDER BY awp_fullname, awp_year DESC LIMIT 150");
                }
                elseif($query_type == "by_performing_category")
                {
                    $src_qry      = explode(",", $param);
                    $src_category = "'" . implode("' , '", $src_qry) . "'";
                    $s_stmt = $this->connect()->prepare("SELECT awp_ip, awp_hashed, awp_image, awp_fullname, awp_year, awp_description, awp_active_status FROM award_performers WHERE awp_active_status=1 AND awp_category = '{$awp_category}' AND awp_category IN (".$src_category.") ORDER BY awp_fullname, awp_year ASC");
                }
                elseif($query_type == "by_performing_artiste")
                {
                    $src_qry     = explode("%,", $param);
                    $src_trim    = "'" . implode("' , '", $src_qry) . "'";
                    $src_artiste = str_replace('%', '', $src_trim);

                    $s_stmt = $this->connect()->prepare("SELECT awp_ip, awp_hashed, awp_image, awp_fullname, awp_year, awp_description, awp_active_status FROM award_performers WHERE awp_active_status=1 AND awp_category = '{$awp_category}' AND awp_fullname IN (".$src_artiste.") ORDER BY awp_fullname, awp_year ASC");
                } 
                else {
                    $s_stmt = $this->connect()->prepare("SELECT awp_ip, awp_hashed, awp_image, awp_fullname, awp_year, awp_description, awp_active_status FROM award_performers WHERE awp_active_status=1 AND awp_category = '{$awp_category}' AND (awp_year = YEAR(CURRENT_DATE)) ORDER BY awp_fullname, awp_year DESC LIMIT 150"); 
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
                $error = 'E0x0000000CxPERFRAC: UNKNOWN_ERROR_OCCURED.';
            }

            // Return error
            $s_stmt = null;
            return $error;
            exit();
        }
    }


