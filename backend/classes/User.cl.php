<?php

class Subscription extends DB_CONN
{

    protected function process($subs_ip, $subscribe_email) {

        try {
            $error = null;
            $subs_active_status = 1;
            $subs_created_at  = date('Y-m-d H:i:s');
            // Check if user already subscribed
            $s_stmt = $this->connect()->prepare('SELECT subs_email FROM subscriptions WHERE subs_email =:xsub_email');
            $s_stmt->bindParam(':xsub_email',$subscribe_email);
            $s_stmt->execute();
            if($s_stmt->rowCount() > 0){
                $error = "This email address has already subscribed to our newsletter. Try again.";
            }
            if($error == null)
            {
                $a_stmt =  $this->connect()->prepare("INSERT INTO subscriptions ( subs_ip, subs_email, subs_active_status, subs_created_at ) VALUES (:xsubs_ip, :xsubs_email, :xsubs_active_status, :xsubs_created_at ) ");
                $a_result = $a_stmt->execute(
                    array(
                        ':xsubs_ip' =>  $subs_ip,
                        ':xsubs_email' =>  $subscribe_email,
                        ':xsubs_active_status' =>  $subs_active_status,
                        ':xsubs_created_at' => $subs_created_at
                    )
                );

                if(!empty($a_result))
                {
                    $a_stmt = null;
                    $success = "You are all set! Thank you for subscribing to our newsletter. Stay in the know by subscribing to our social media pages.";
                    return ['code'=>200, 'msg'=>$success];
                    exit();
                }
                    
            }
        } catch (PDOException $e) {
            $error = 'E0x0000000CxUSP: UNKNOWN_ERROR_OCCURED.';
        }

        // Return error
        $s_stmt1 = null;
        $a_stmt = null;
        return ['code'=>404, 'msg'=>$error];
        exit();
    }

}


class TicketPayment extends DB_CONN
{

    protected function write($pay_hash_key, $pay_fname, $pay_lname, $pay_email, $pay_phone, $pay_location, $event_hash, $ticket_name) {
        try {
            $error = null;
            // Set session variables        
            $_SESSION['upKey']      = $pay_hash_key;
            $_SESSION['upFname']    = $pay_fname;
            $_SESSION['upLname']    = $pay_lname;      
            $_SESSION['upEmail']    = $pay_email;
            $_SESSION['upPhone']    = $pay_phone;
            $_SESSION['upLocation'] = $pay_location; 
            $_SESSION['upEvHash']   = $event_hash;
            $_SESSION['upTicket']   = $ticket_name;

            // Set cookie variables
            setcookie("upKey", $pay_hash_key, time() + (2592000 * 30), "/" );
            setcookie("upFname", $pay_fname, time() + (2592000 * 30), "/");
            setcookie("upLname", $pay_lname, time() + (2592000 * 30), "/");
            setcookie("upEmail", $pay_email, time() + (2592000 * 30), "/");
            setcookie("upPhone", $pay_phone, time() + (2592000 * 30), "/");
            setcookie("upLocation", $pay_location, time() + (2592000 * 30), "/");
            setcookie("upEvHash", $event_hash, time() + (2592000 * 30), "/");
            setcookie("upTicket", $ticket_name, time() + (2592000 * 30), "/");

            $success = "You are all set! Thank you for providing your details. Please proceed to check out.";
            return ['code'=>200, 'msg'=>$success];

        } catch (PDOException $e) {
            $error = 'Something went wrong please try again.';
        }

        // Return error
        return ['code'=>404, 'msg'=>$error];
        exit();
    }
}


