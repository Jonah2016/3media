<?php

require_once('../core/Auth.php');

// Define routing path
$route_check = [ 
    'zLc9H5zH3BCVxalkfGnwcL4kPAax4mbSHycudUm', 'Qau7FkKRfDxQP5j8FLtdafYunUiLrFV8Cnm6Rb', 'G2uGfeydjtWGh3DCgPNap09gmfDg2XgKpQPd3EVr', 'HjkhVmBub7XH8yiRc957ny5F8tftr9jhcmprF586bKM', 'Cm4yS5WaflkjEAdpfhg8xSaAwRcneFngKQdzwLfZyzi', 'pb8ptwtWdZjjsalbmb2ZMP8D25AvmxtWecSVtH', 'giMBjVfZpeeQhvDxPuMjWvPCh6Tybw2yEPH82V', 'ZAQKWHppWgdnjnuC6Zhj8RuU8dF7zTnARpunmb9aVL', 'VFurJCbRj5ambKhkHR8cYKFdBGCzfTMqmbQTJniHPc', 'J9BhffhMfhdDVj3890387W33ZdVXP6jvteLcM4U', 'nBcEkYuWm6XyiKn84ZWQELJGdZ56547iNdyCgyL', 'GSyC458zw2kmUfSxFdd5NN3L575k8pV9PrfLU4dpBA', '8CRrgSuGzuaH2US33WkQvtBWMykhkjtxVkJHK6JnmD', '8h4hWgqagXpNu7E4uGKK5kSUeVfuhKjV8gZaUM', '66dZV3HeXup5464683MN8Q2f8pD4Ax558ZH', 'tPDRinu3vuNAQA9zbshkjg55VUTEgMRAJxwJqxu', 'ceC74BT2TGuV87sdM6KJ2JmT3TLyxMJAL8U23', 'GD8GBvMt6H3FfzeShn7GbGfm5edJfZXPP3v4M', '98Ue6465eQp4HgXJ9NA7zzjlsd8MpZPtFzxehU', 'UCNm9uEHWc6VypeKbqcSBQmrbQjFfkNeJpU', 'gKdSuB76ywyk2Tdsdd2p9Hd772CmmQTe7g', 'ChY3AcFZ8MAcWVkcfPjyZAYB6c6dfqaRahmWPf', 'bQJc8EPfGE4MqwLh587kdgxzY86fxqeTLxBEkC', 'Pe4D3BJK5Gxa6AwGmjslgdjlvRCbVZkiyc2', 'R3Lvy5mbbmZN3YbYH64kdskhdBAprd8czVLnV6', 'WYuS8rdmQPzSa464646cbvDiJ2NM', 'xbEPWx2kjkj8YbV3wJ54648eSfzej34gBZS2gCubM', 'jAFjvzya5hkQKSDahDaKqJZQUarT564Pc2zY3LWK', 'rhcf9xNFPSJPG7ZjGMBmvt2XQZyAUv4JzbHuZQ', 'D4yRxLMexivB5q8rQ5gY74KnaimqLiaCSjAaxQ', 'TN9JLrbKWWFsdk3543nxL3CEZytnUEeRxXeg', 'KdYPFdpEFZmcjpyMFepYu9kqDiMV7KFEjRRY89g4', 'YzV9vVhkhu49qRd38JEybt5q8L4KBBGPLTna67YKexM', '944zPSrjuLxu6CjX8bEzPnvFbwUTgggTVj3fPq3u', 'FfwtyEXYFNHctctSL37ub3Zh2m6V9YqdKnApbpvV', '4jjCxRkd5223cDGkpdtqbKD5tSWR57tRxf', 'u2RcHjAJhkhizfaiQVTGNnicB7mtFFdA3ACqi3Az', 'eibSd53WX4TgJzwYxSTc3buRZSMikkcc4MEh4xK6', 'MBP9mMbQtrryrajddf7VyuQ9nfVZZM8cJRxzPG', 'MJQcdsgssmHXjXfndQnKwvCMdZrFrdZhVVyQ', 'ECmSWCRikhkQj66D3Jg4NHSb2BEgaeYJytiDuD4y', '25qZQwhGVm5jhgjjgzQh6EpAPKBU76Mcecp', '4vFKHgBnSfjgjgjVQQyqkVKuVziAFx75A', 'zMAderUikxxcDyTACTYwu8KSVQSAxBvg9bkmYJFv', 'f645DWKthWcrNjJV73pPewQMRmv73AMHvdwEevKM', 'u2uyVkinnFWmrhjhjQp4BAeWDS5V6wgc5Gn2QNJ5', 'pAemPNwQaz3NYhBDr8HibpERD2WS5qen7Ah3CaUE', 'KwJWggLKNVDQrA2VEjG7hB49Jr27Xt6VSXXfp3YC', 'CJSAPfY4Y9CQhjdfdaRfWtMruaZZJrZCtYhGxEU', 'ZYjjfds545RQNthAjznwcCVY2dFjQ2BJ2fkjEELThq2eY' 
];
// Randomize array elements
shuffle($route_check);
// Select random route
$route_id = $route_check[0];

// Initialize curl
$curl = curl_init();

// Get page reference of transaction
$reference = isset($_GET['reference']) ? htmlspecialchars(strip_tags($_GET['reference'])) : null;
if($reference === null){
    // Reroute to failure page
    $routing = SECTION_PATH."tickets/payment_error?pid=".$route_id;
    header("location:".$routing);
    exit;
}

// Setup curl and verify
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authorization: Bearer ".$_ENV['PAYSTACK_SKEY'],
        "cache-control: no-cache"
    ],
));

$response    = curl_exec($curl);
$result      = json_decode($response);
$tranx_array = json_decode(json_encode($result), true);
$err         = curl_error($curl);

if($err){
    // echo 'Curl returned error: ' . $err;
    // echo "There was an error contacting the payment gateway";
    $routing = SECTION_PATH."tickets/payment_error?pid=".$route_id;
    header("location:".$routing);
    exit;
}

// Create an object instance
$tranx = $result;

if(!$tranx->status){
    // echo "Error: ".$tranx->message;
    $routing = SECTION_PATH."tickets/payment_error?pid=".$route_id;
    header("location:".$routing);
    exit;
}

if('success' == $tranx->data->status){
    // transaction was successful...
    // please check other things like whether you already gave value for this ref
    // if the email matches the customer who owns the product etc
    // Give value

    // Data from paystack response
    $trans_reference = htmlspecialchars(strip_tags($tranx->data->reference), ENT_QUOTES);
    $fname           = htmlspecialchars(strip_tags($tranx->data->customer->first_name), ENT_QUOTES);
    $first_name      = ($fname != "") ? $fname : $_SESSION["upFname"];
    $lname           = htmlspecialchars(strip_tags($tranx->data->customer->last_name), ENT_QUOTES) ?? $_SESSION["upLname"];
    $last_name       = ($lname != "") ? $lname : $_SESSION["upLname"];
    $email           = htmlspecialchars(strip_tags($tranx->data->customer->email), ENT_QUOTES);
    $customer_code   = htmlspecialchars(strip_tags($tranx->data->customer->customer_code), ENT_QUOTES);
    $mobile          = htmlspecialchars(strip_tags($tranx->data->customer->phone), ENT_QUOTES) ?? $_SESSION["upPhone"];
    $phone           = ($mobile != "") ? $mobile : $_SESSION["upPhone"];
    $transact_date   = htmlspecialchars(strip_tags($tranx->data->transaction_date), ENT_QUOTES);

    // Data from session
    $cus_hash_key      = htmlspecialchars(strip_tags($_SESSION['upKey']), ENT_QUOTES) ?? $global_class->generateRandomString(27);
    $cus_location      = htmlspecialchars(strip_tags($_SESSION['upLocation']), ENT_QUOTES); 
    $cus_active_status = 1;
    $created_at        = date('Y-m-d H:i:s');
    // Insert if customer transaction was successful
    try {
        $s_stmt = $db_connect->prepare('SELECT cus_email FROM user_ticket_payment_details WHERE cus_email =:xcus_email');
        $s_stmt->bindParam(':xcus_email',$email);
        $s_stmt->execute();

        if($s_stmt->rowCount() < 1){
            // Insert customer details temporarily stored in session
            $a_stmt =  $db_connect->prepare("INSERT INTO user_ticket_payment_details ( cus_hash_key, cus_fname, cus_lname, cus_email, cus_phone, cus_location, cus_active_status, cus_created_at ) VALUES (:xcus_hash_key, :xcus_fname, :xcus_lname, :xcus_email, :xcus_phone, :xcus_location, :xcus_active_status, :xcus_created_at ) ");
            $a_result = $a_stmt->execute(
                array(
                    ':xcus_hash_key' => $cus_hash_key,
                    ':xcus_fname' => $first_name,
                    ':xcus_lname' => $last_name,
                    ':xcus_email' => $email,
                    ':xcus_phone' => $phone,
                    ':xcus_location' => $cus_location,
                    ':xcus_active_status' => $cus_active_status,
                    ':xcus_created_at' => $created_at
                )
            );
        } 

        // If successful then insert individual payment
        if(!empty($email))
        {
            if(isset($_SESSION["cart_item"])){
                $item_total = 0;
                $pay_hash_key = strtoupper($first_name)."-".$global_class->generateRandomString(6);
                $pay_active_status = 1;
                // Check if session array greater than 1
                if (count($_SESSION["cart_item"]) > 0) {
                    foreach ($_SESSION["cart_item"] as $key => $item) {
                        $tprice          = floatval($item["ticket_price"]);
                        $tqty            = floatval($item["ticket_qty"]);
                        $cus_event_hash  = htmlspecialchars(strip_tags($item['event_code']), ENT_QUOTES);
                        $cus_event_name  = htmlspecialchars(strip_tags($item['event_name']), ENT_QUOTES);
                        $cus_ticket_name = htmlspecialchars(strip_tags($item['ticket_name']), ENT_QUOTES);

                        // Insert individual ticket payments from session cart
                        $a_stmt1 =  $db_connect->prepare("INSERT INTO ticket_payments ( pay_hash_key, pay_trans_reference, pay_trans_cus_code, pay_customer_id, transact_date, pay_event_hash, pay_ticket_name, pay_indiv_qty, pay_indiv_amt, pay_active_status, pay_created_at ) VALUES (:xpay_hash_key, :xpay_trans_reference, :xpay_trans_cus_code, :xpay_customer_id, :xtransact_date, :xpay_event_hash, :xpay_ticket_name, :xpay_indiv_qty, :xpay_indiv_amt, :xpay_active_status, :xpay_created_at ) ");
                        $a_result1 = $a_stmt1->execute(
                            array(
                                ':xpay_hash_key' => $pay_hash_key,
                                ':xpay_trans_reference' => $trans_reference,
                                ':xpay_trans_cus_code' => $customer_code,
                                ':xpay_customer_id' => $cus_hash_key,
                                ':xtransact_date' => $transact_date,
                                ':xpay_event_hash' => $cus_event_hash,
                                ':xpay_ticket_name' => $cus_ticket_name,
                                ':xpay_indiv_qty' => $tqty,
                                ':xpay_indiv_amt' => $tprice,
                                ':xpay_active_status' => $pay_active_status,
                                ':xpay_created_at' => $created_at
                            )
                        );

                        // Generate QR code
                        $filename   = $last_name."_".$cus_event_hash."_".$cus_ticket_name."_".date('Ymd');
                        $qr_content = BASE_URL."/ticketDetails?tid=".$pay_hash_key. " \r\n";
                        $qr_content .= "NAME: ".$first_name. " " .$last_name. " \r\n";
                        $qr_content .= "EVENT NAME: ".$cus_event_name. " \r\n";
                        $qr_content .= "TICKET TYPE: ".$cus_ticket_name. " \r\n";
                        $qr_content .= "PASS-KEY: ".$pay_hash_key. " \r\n";
                        $content    = $qr_content;
                        // Get qr code filename
                        $qr_file_name = $utils_class->generateQRCode($filename, $content);

                        // Attachment file
                        $filePath = "../../uploads/qrcodes/".$qr_file_name;
                        //Set email server parameters
                        ini_set('SMTP', SECURE_SMTP);
                        ini_set("SMTP", EMAIL_HOST);
                        ini_set("sendmail_from", EMAIL_ADDRESS);
                        ini_set("smtp_port", EMAIL_PORT);
                        // Send Email
                        $to = $email;
                        $subject = "Event Ticket - 3 Music.tv";
                        // Sender
                        $from = EMAIL_ADDRESS;
                        // Email body content
                        $htmlContent = "<h4>Dear ".$first_name.",</h4>";
                        $htmlContent .= "<h4>Thank you for purchasing a ticket on our online ticketing platform. Your ticket has been attached to this mail asSee below the description of your purchase.</h4>";
                        $htmlContent .= "<h4>Your ticket has been attached to this mail as a QR code. Which will be scanned at the venue. Below is also some information regarding your purchase.</h4><br><br>";
                        $htmlContent .= "<h4>NAME: ".$first_name. " " .$last_name. "</h4>";
                        $htmlContent .= "<h4>EVENT NAME: ".$cus_event_name. "</h4>";
                        $htmlContent .= "<h4>TICKET TYPE: ".$cus_ticket_name. "</h4>";
                        $htmlContent .= "<h4>PASS-KEY: ".$pay_hash_key. "</h4><br><br>";
                        $htmlContent .= "<h4>Thank You.</h4>";
                        $htmlContent .= "<h4>Kind regards,</h4><br><br>";
                        $htmlContent .= "";
                        $htmlContent .= "<h4>Location: N0. 12 Afunya Street, Abelenkpe <br> Phone: 030 279 1949 <br> Email: shout@3music.tv</h4>";

                        $message = $htmlContent;
                        //read from the uploaded file & base64_encode content
                        $handle = fopen($filePath, "r"); // set the file handle only for reading the file
                        $size = filesize($filePath);
                        $content = fread($handle, $size); // reading the file
                        fclose($handle);  // close upon completion
                            
                        $encoded_content = chunk_split(base64_encode($content));
                        $boundary = md5(time()); // define boundary with a md5 hashed value
                        // Header
                        $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
                        $headers .= "From:".$from."\r\n"; // Sender Email
                        $headers .= "Reply-To: ".$from."\r\n"; // Email address to reach back
                        $headers .= "Content-Type: multipart/mixed;"; // Defining Content-Type
                        $headers .= "boundary = $boundary\r\n"; //Defining the Boundary
                        // Plain text
                        $body = "--$boundary\r\n";
                        $body .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
                        $body .= chunk_split(base64_encode($message));
                        // Attachment
                        $body .= "--$boundary\r\n";
                        $body .="Content-Type: text/html; name=".$qr_file_name."\r\n";
                        $body .="Content-Disposition: attachment; filename=".$qr_file_name."\r\n";
                        $body .="Content-Transfer-Encoding: base64\r\n";
                        $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
                        $body .= $encoded_content; // Attaching the encoded file with email
                        //SEND MAIL
                        $sendMail = mail($to, $subject, $body, $headers);
                        
                    }
                }
            }

            // Unset session cart items on success
            if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
                unset($_SESSION["cart_item"]);
            }

            // Reroute to success page
            $routing = SECTION_PATH."tickets/payment_success?pid=".$route_id;
            header("location:".$routing);
            exit;
        }    
        
    } catch (Exception $e) {
        // Reroute to failure page
        $routing = SECTION_PATH."tickets/payment_error?pid=".$route_id;
        header("location:".$routing);
        exit;
    }
} else {
    header("location:javascript://history.go(-1)");
    exit;
}