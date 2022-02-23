<?php
    class Voting extends DB_CONN
    {
        protected function process($name1, $name2, $name3, $name4, $tokenValue, $SessionExpire, $allowed_countries, $ip, $locationData, $countryName, $countryCode, $countryPhoneCode, $countryRegion, $awvs_nominee_id, $awvs_category_id, $voted_for)
        {

            try {

                if (!empty($_COOKIE[$name1]) && !empty($_SESSION[$name1])) {
                    $msg = "You've already voted. Please wait patiently for the final results.";
                    echo json_encode(['code'=>404, 'msg'=>$msg]);
                    exit;
                } else {
                    $msg       = null;
                    $cast_vote = true;

                    // Check if ip has voted more than 5 in database
                    $s_stmt1 = $this->connect()->prepare("SELECT awv_id FROM award_voters WHERE awv_banned != 1 AND awv_ip_address = :xawv_ip_address AND awv_created_at = CURRENT_DATE() LIMIT 10"); 
                    $s_stmt1->execute([':xawv_ip_address' => $ip]);
                    // check multiple votes for 5 times
                    $findMultiVotes = $s_stmt1->rowCount();
                    if ($findMultiVotes >= 5) {
                        $msg = "It's possible you voted using a different device. Please return later and give it another go.";
                        echo json_encode(['code'=>404, 'msg'=>$msg]);
                        exit;
                    } else {
                        // On casting vote
                        // Set cookie variables
                        setcookie($name1, $tokenValue, time() + ($SessionExpire * 30), "/"); // 86400 = 30 day
                        setcookie($name2, $countryName, time() + ($SessionExpire * 30), "/"); // 86400 = 30 day
                        setcookie($name3, $countryPhoneCode, time() + ($SessionExpire * 30), "/"); // 86400 = 30 day
                        setcookie($name4, $countryRegion, time() + ($SessionExpire * 30), "/"); // 86400 = 30 day
                        // Set session variables        
                        $_SESSION[$name1] = $tokenValue;
                        $_SESSION[$name2] = $countryName;
                        $_SESSION[$name3] = $countryPhoneCode;
                        $_SESSION[$name4] = $countryRegion;
                        $_SESSION['lastActivity'] = time();

                        // Check if user is out country defined
                        if (!in_array($countryCode, $allowed_countries)){
                            $msg = "You are not in a voting-eligible location. Thank you.";
                            echo json_encode(['code'=>404, 'msg'=>$msg]);
                            exit;
                        } else {
                            $totalCount       = count($awvs_category_id);
                            $voter_id         = ($_SESSION[$name1] != "" && $_SESSION[$name1] != null) ? $_SESSION[$name1] : $global_class->generateRandomString(21);
                            $awv_ip_address   = $ip;
                            $awv_country_name = "GHANA"; #$countryName;
                            $awv_cookie_token = $tokenValue;
                            $awv_banned       = 0;
                            $awv_timestamp    = time();
                            $awv_created_at   = date('Y-m-d H:i:s');
                            $awvs_year        = date('Y');

                            // Prepare statement to insert voters data
                            $q1_stmt = $this->connect()->prepare("INSERT INTO award_voters (awv_voter_id, awv_ip_address, awv_country_name, awv_cookie_token, awv_timestamp, awv_banned, awv_created_at) VALUES (:xawv_voter_id, :xawv_ip_address, :xawv_country_name, :xawv_cookie_token, :xawv_timestamp, :xawv_banned, :xawv_created_at)");
                            // Prepare statement to insert all votes
                            $q_stmt = $this->connect()->prepare("INSERT INTO award_vote_cast (awvs_voter_id, awvs_nominee_id, awvs_category_id, awvs_year, awvs_created_at) VALUES (:xawvs_voter_id, :xawvs_nominee_id, :xawvs_category_id, :xawvs_year, :xawvs_created_at)");

                            // Check if user token is available in database
                            $s_stmt2 = $this->connect()->prepare("SELECT awv_id, awv_voter_id, awv_ip_address, awv_country_name, awv_cookie_token, awv_timestamp FROM award_voters WHERE awv_banned != 1 AND awv_cookie_token = :xawv_cookie_token LIMIT 1"); 
                            $s_stmt2->execute([':xawv_cookie_token' => $_SESSION[$name1]]);
                            if($s_stmt2->rowCount() > 0)
                            {
                                while($s_row2=$s_stmt2->fetch(PDO::FETCH_ASSOC))
                                {
                                    // Check if user has voted before
                                    $s_stmt1 = $this->connect()->prepare("SELECT awvs_id, awvs_nominee_id, awvs_category_id FROM award_vote_cast WHERE awvs_voter_id = :xawvs_voter_id LIMIT 2"); 
                                    $s_stmt1->execute([':xawvs_voter_id' => $voter_id]);
                                    if($s_stmt1->rowCount() > 0)
                                    {
                                        $msg = "You've already voted. Please wait patiently for the final results.";
                                        $cast_vote = false;
                                    } else {
                                        // Check the total vote count
                                        if($totalCount > 1) {
                                            for($i=0; $i<$totalCount; $i++)
                                            {
                                                $v_for = $voted_for[$i];
                                                if ($v_for == 1) {
                                                    $awvs_nominee_id  = $awvs_nominee_id[$i];
                                                    $awvs_category_id = $awvs_category_id[$i];
                                                    // Insert all votes
                                                    $q_result = $q_stmt->execute(
                                                        array(
                                                            ':xawvs_voter_id' => $voter_id,
                                                            ':xawvs_nominee_id' => $awvs_nominee_id,
                                                            ':xawvs_category_id' => $awvs_category_id,
                                                            ':xawvs_year' => $awvs_year,
                                                            ':xawvs_created_at' => $awv_created_at
                                                        )
                                                    );
                                                }

                                                $msg = 'Your vote has been submitted successfully.';
                                                $cast_vote = true; 
                                            }
                                        }  
                                        else {
                                            $v_for = $voted_for[0];
                                            if ($v_for == 1) {
                                                $awvs_nominee_id  = $awvs_nominee_id[0];
                                                $awvs_category_id = $awvs_category_id[0];
                                                // Insert all votes
                                                $q_result = $q_stmt->execute(
                                                    array(
                                                        ':xawvs_voter_id' => $voter_id,
                                                        ':xawvs_nominee_id' => $awvs_nominee_id,
                                                        ':xawvs_category_id' => $awvs_category_id,
                                                        ':xawvs_year' => $awvs_year,
                                                        ':xawvs_created_at' => $awv_created_at
                                                    )
                                                );
                                            }

                                            $msg = 'Your vote has been submitted successfully.';
                                            $cast_vote = true; 
                                        }
                                    }
                                }
                            } else {
                                // Insert voter data
                                $q1_result = $q1_stmt->execute(
                                    array(
                                        ':xawv_voter_id' => $voter_id,
                                        ':xawv_ip_address' => $awv_ip_address,
                                        ':xawv_country_name' => $awv_country_name,
                                        ':xawv_cookie_token' => $awv_cookie_token,
                                        ':xawv_timestamp' => $awv_timestamp,
                                        ':xawv_banned' => $awv_banned,
                                        ':xawv_created_at' => $awv_created_at,
                                    )
                                );

                                if($totalCount > 1) {
                                    for($i=0; $i<$totalCount; $i++)
                                    {
                                        $v_for = $voted_for[$i];
                                        if ($v_for == 1) {
                                            $nominee_id  = $awvs_nominee_id[$i];
                                            $category_id = $awvs_category_id[$i];

                                            // Insert all votes
                                            $q_result = $q_stmt->execute(
                                                array(
                                                    ':xawvs_voter_id' => $voter_id,
                                                    ':xawvs_nominee_id' => $nominee_id,
                                                    ':xawvs_category_id' => $category_id,
                                                    ':xawvs_year' => $awvs_year,
                                                    ':xawvs_created_at' => $awv_created_at
                                                )
                                            );
                                        }

                                        $msg = 'Your vote has been submitted successfully.';
                                        $cast_vote = true; 
                                    }
                                } 
                                else {
                                    $v_for = $voted_for[0];
                                    if ($v_for == 1) {
                                        $nominee_id  = $awvs_nominee_id[0];
                                        $category_id = $awvs_category_id[0];

                                        // Insert all votes
                                        $q_result = $q_stmt->execute(
                                            array(
                                                ':xawvs_voter_id' => $voter_id,
                                                ':xawvs_nominee_id' => $nominee_id,
                                                ':xawvs_category_id' => $category_id,
                                                ':xawvs_year' => $awvs_year,
                                                ':xawvs_created_at' => $awv_created_at
                                            )
                                        );
                                    }

                                    $msg = 'Your vote has been submitted successfully.';
                                    $cast_vote = true; 
                                }
                            }
                        }
                    }

                    // If vote casted the end session
                    if ($cast_vote === true) {
                        echo json_encode(['code'=>200, 'msg'=>$msg]);
                        exit;
                    } else {
                        echo json_encode(['code'=>404, 'msg'=>$msg]);
                        exit;
                    }

                }

            } catch (PDOException $e) {
                $error = 'Voting could not be processed due to sever error. Please try again later.';
            }

            // Return error
            $s_stmt1 = null;
            $q1_stmt = null;
            $s_stmt2 = null;
            return ['code'=>404, 'msg'=>$error];
            exit();

        }
    }




