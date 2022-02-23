<?php

class GlobalFunctions extends DB_CONN
{
    public function getCategoryUrl($category){
        $categoy_url = "";
        if(strtolower($category) == "culture") {  $categoy_url = SECTION_PATH."news/culture"; } 
        elseif (strtolower($category)  == "music") {  $categoy_url = SECTION_PATH."music/"; }
        elseif (strtolower($category)  == "sports") {  $categoy_url = SECTION_PATH."news/sports"; }
        elseif (strtolower($category)  == "entertainment") {  $categoy_url = SECTION_PATH."news/entertainment"; }
        elseif (strtolower($category)  == "fashion & lifestyle") {  $categoy_url = SECTION_PATH."news/fashion_lifestyle"; }
        elseif (strtolower($category)  == "3music awards") {  $categoy_url = SECTION_PATH."award/"; }

        return $categoy_url;
    }

    public function getIpAddress()
    {
        $ipAddress = '';
        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            // to get shared ISP IP address
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (! empty($ip)) {
                    // if you prefer, you can check for valid IP address here
                    $ipAddress = $ip;
                    break;
                }
            }
        } else if (! empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (! empty($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (! empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
     
        return $ipAddress;
    }

    public function getLocationData($ip)
    {
        $ch = curl_init('http://ipwhois.app/json/' . $ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        // Decode JSON response
        $ipWhoIsResponse = json_decode($json, true);
        // Country code output, field "country_code"
        return $ipWhoIsResponse;
    }


    public function generateRandomString($length) {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '1234567890';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $letters[rand(0, strlen($letters) - 1)];
        }
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $digits[rand(0, strlen($digits) - 1)];
        }
        $shuffledString = str_shuffle($randomString);
        return substr($shuffledString,0,$length);
    }

    // timestamp to time elapsed string
    public function time_elapsed_string($timestamp, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($timestamp);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    // Get total of items in a table
    public function query_total($statement){
        $sql0001 = $this->connect()->prepare($statement);
        $sql0001->execute();
        if($sql0001->rowCount() > 0)
        {
            while($row0001=$sql0001->fetch(PDO::FETCH_ASSOC))
            {
                
                if ($row0001['total'] > 0 || $row0001['total'] != NULL || !empty($row0001['total'])) {
                    $total = $row0001['total'];
                } else {
                    $total = 0;
                }
            }
        } else {
            $total = 0;
        }

        return $total;
    }


    // Insert and return views count on news, video and blog posts
    public function post_view_count($key, $type, $update_count_statement) {
        $sql0002 = $this->connect()->prepare($update_count_statement);
        $result0002 = $sql0002->execute();
        if(!empty($result0002)) {

            if(!empty($type) && $type == "video"){$hash = "vid_hashed"; $hash_val=$key; $param = "vid_views_count"; $table = "videos"; $status = "vid_active_status";}
            if(!empty($type) && $type == "news"){$hash = "news_hashed"; $hash_val=$key; $param = "news_views_count"; $table = "news_posts"; $status = "news_active_status";}

            $qry0002 = $this->connect()->prepare("SELECT $param AS total FROM $table WHERE $status=1 AND $hash LIKE '%$hash_val%' ");
            $qry0002->execute();
            if($qry0002->rowCount() > 0)
            {
                while($qrow0002=$qry0002->fetch(PDO::FETCH_ASSOC))
                {
                    ($qrow0002['total'] > 0 || $qrow0002['total'] != NULL || !empty($qrow0002['total'])) ?  $total_count = $qrow0002['total'] :  $total_count = 0;
                }
            } else {
                $total_count = 0;
            }
        } else {
            $total_count = 0;
        }
        return  $total_count;
    }


    // Function to remove the spacial chars and space
    public function removeSpecialChar($str) {
            $string = str_replace(' ', '_', $str); // Replaces all spaces with underscore.
            $res = preg_replace('/[^A-Za-z0-9\-]/', '_', $string);
            return $res;
    }


    // Function to return duplicates in array
    public function returnDuplicates($array) 
    {
        $results    = [];
        $duplicates = [];
        foreach ($array as $item) {
            if (in_array($item, $results)) { $duplicates[] = $item; }
            $results[] = $item;
        }
        return $duplicates;
    }
    
}
