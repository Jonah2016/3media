<?php

class UtilsLibrary extends DB_CONN
{
    protected $uploads_path;
    protected $assets_path;
    protected $backend_base_path;

    public function __construct($data)
    {
        $this->uploads_path      = $data['uploads_path'] ?? null;
        $this->assets_path       = $data['assets_path'] ?? null;
        $this->backend_base_path = $data['backend_base_path'] ?? null;
    }

    public function generateQRCode($file_name, $content)
    {
        // include("./phpqrcode/qrlib.php");
        $qr_path = '../../uploads/qrcodes/';
        $qr_file = $qr_path.$file_name.".png";
        $qr_name = $file_name.".png";
        $qr_content = $content;
        QRcode::png($qr_content, $qr_file);
        return $qr_name;
    }

    // Get main news categories
    public function getMainNewsCategories()
    {
        $s_abt_stmt = $this->connect()->prepare("SELECT category_id, category_name FROM categories ORDER BY category_name ASC ");
        $s_abt_stmt->execute();
        if ($s_abt_stmt->rowCount() > 0) {
            $s_abt_row=$s_abt_stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $s_abt_row = [];
        }

        $s_abt_stmt = null;
        return $s_abt_row;
        exit();
    }

    // Get distinct news categories
    public function getDistinctCategories()
    {
        $distinct_categories = [];
        $s_stmt = $this->connect()->prepare(" SELECT DISTINCT(news_category) AS dist_categories, news_id FROM news_posts WHERE news_active_status=1 GROUP BY dist_categories ORDER BY RAND() ");           
        $s_stmt->execute();
        if($s_stmt->rowCount() > 0)
        {
            while($s_row=$s_stmt->fetch(PDO::FETCH_ASSOC))
            {
                $q00_id = $s_row['news_id'];
                $q00_category = $s_row['dist_categories'];

                // Get category name from the comma separated string
                $cat_name = (!empty($q00_category)) ? array_filter(explode(",", $q00_category)) : [];

                foreach ($cat_name as $key => $val) 
                {
                    $ind_category = $val;
                    array_push($distinct_categories, $ind_category);
                }
            }
        }

        $s_stmt = null;
        return $distinct_categories;
        exit();
    }

    // Get awards category name
    public function getAwardCategoryName($cat_id)
    {
        $cat_name = "";
        $s_stmt = $this->connect()->prepare(" SELECT awc_title FROM award_categories WHERE awc_id=:xawc_id AND awc_active_status=1 LIMIT 1 ");           
        $s_stmt->execute([':xawc_id' => $cat_id]);
        if($s_stmt->rowCount() > 0)
        {
            while($s_row=$s_stmt->fetch(PDO::FETCH_ASSOC))
            {
                $cat_name = $s_row['awc_title'];
            }
        }

        $s_stmt = null;
        return $cat_name;
        exit();
    }

    // Get about details
    public function getAboutDetails()
    {
        $status = 1;
        $s_abt_stmt = $this->connect()->prepare("SELECT abt_organisation_name, abt_brief_description FROM about_page LIMIT 1");
        $s_abt_stmt->execute();
        if ($s_abt_stmt->rowCount() > 0) {
            $s_abt_row=$s_abt_stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $s_abt_row = [];
        }

        $s_abt_stmt = null;
        return $s_abt_row;
        exit();
    }

    // Get general settings
    public function getGeneralSettings()
    {
        $data = [];
        $sg_stmt = $this->connect()->prepare("SELECT * FROM general_settings LIMIT 1");
        $sg_stmt->execute();
        if ($sg_stmt->rowCount() > 0) {
            for($i=0; $sg_row = $sg_stmt->fetch(); $i++)
            {
                $sett_site_name       = $sg_row['sett_site_name'];
                $sett_site_tagline    = $sg_row['sett_site_tagline'];
                $sett_site_address    = $sg_row['sett_site_address'];
                $sett_site_phone1     = $sg_row['sett_site_phone1'];
                $sett_site_phone2     = $sg_row['sett_site_phone2'];
                $sett_site_phone3     = $sg_row['sett_site_phone3'];
                $sett_site_email      = $sg_row['sett_site_email'];
                $sett_voting_opened   = $sg_row['sett_voting_opened'];
                $sett_mail_server     = $sg_row['sett_mail_server'];
                $sett_mail_passwod    = $sg_row['sett_mail_passwod'];
                $sett_mail_address    = $sg_row['sett_mail_address'];
                $sett_mail_port       = $sg_row['sett_mail_port'];
                $sett_sms_api         = $sg_row['sett_sms_api'];
                $sett_sms_api_number  = $sg_row['sett_sms_api_number'];
                $sett_sms_api_key     = $sg_row['sett_sms_api_key'];
                $sett_sms_api_auth    = $sg_row['sett_sms_api_auth'];
                $sett_site_fb         = $sg_row['sett_site_fb'];
                $sett_site_twitter    = $sg_row['sett_site_twitter'];
                $sett_site_instagram  = $sg_row['sett_site_instagram'];
                $sett_site_youtube    = $sg_row['sett_site_youtube'];
                $sett_site_linkedin   = $sg_row['sett_site_linkedin'];
                $sett_site_vimeo      = $sg_row['sett_site_vimeo'];
                $sett_site_tiktok     = $sg_row['sett_site_tiktok'];
                $sett_site_snapchat   = $sg_row['sett_site_snapchat'];
                $sett_site_soundcloud = $sg_row['sett_site_soundcloud'];

                $sett_logo_colored    = $sg_row['sett_logo_colored'];
                $sett_logo_black      = $sg_row['sett_logo_black'];
                $sett_logo_white      = $sg_row['sett_logo_white'];
                $sett_season_banner   = $sg_row['sett_season_banner'];
                if (!empty($sett_logo_colored)) { $logo_coloured = $this->uploads_path."system/".$sett_logo_colored; } else { $logo_coloured = $this->assets_path."/img/logo.png"; }
                if (!empty($sett_logo_black)) { $logo_black = $this->uploads_path."system/".$sett_logo_black; } else { $logo_black = $this->assets_path."/img/logo.png"; }
                if (!empty($sett_logo_white)) { $logo_white = $this->uploads_path."system/".$sett_logo_white; } else { $logo_white = $this->assets_path."/img/logo.png"; }
                if (!empty($sett_season_banner)) { 
                    $season_banner = $this->uploads_path."system/".$sett_season_banner;
                    $body_background_style = '
                        background-image:url('.$season_banner.');
                        background-position:center center;
                        background-size:contain;
                        background-repeat:repeat;
                        background-attachment:fixed;
                    ';
                } else {  
                    $body_background_style = 'background-color: #f2f2f2;';
                }  
                // Push variables into array
                array_push($data, [
                    "sett_site_name"        => $sett_site_name,
                    "sett_site_tagline"     => $sett_site_tagline,
                    "sett_site_address"     => $sett_site_address,
                    "sett_site_phone1"      => $sett_site_phone1,
                    "sett_site_phone2"      => $sett_site_phone2,
                    "sett_site_phone3"      => $sett_site_phone3,
                    "sett_site_email"       => $sett_site_email,
                    "sett_voting_opened"    => $sett_voting_opened,
                    "sett_mail_server"      => $sett_mail_server,
                    "sett_mail_passwod"     => $sett_mail_passwod,
                    "sett_mail_address"     => $sett_mail_address,
                    "sett_mail_port"        => $sett_mail_port,
                    "sett_sms_api"          => $sett_sms_api,
                    "sett_sms_api_number"   => $sett_sms_api_number,
                    "sett_sms_api_key"      => $sett_sms_api_key,
                    "sett_sms_api_auth"     => $sett_sms_api_auth,
                    "sett_site_fb"          => $sett_site_fb,
                    "sett_site_twitter"     => $sett_site_twitter,
                    "sett_site_instagram"   => $sett_site_instagram,
                    "sett_site_youtube"     => $sett_site_youtube,
                    "sett_site_linkedin"    => $sett_site_linkedin,
                    "sett_site_vimeo"       => $sett_site_vimeo,
                    "sett_site_tiktok"      => $sett_site_tiktok,
                    "sett_site_snapchat"    => $sett_site_snapchat,
                    "sett_site_soundcloud"  => $sett_site_soundcloud,
                    "sett_logo_colored"     => $sett_logo_colored,
                    "sett_logo_black"       => $sett_logo_black,
                    "sett_logo_white"       => $sett_logo_white,
                    "sett_season_banner"    => $sett_season_banner,
                    "logo_coloured"         => $logo_coloured,
                    "logo_black"            => $logo_black,
                    "logo_white"            => $logo_white,
                    "body_background_style" => $body_background_style
                ]);
            }
        }

        $sg_stmt = null;
        return $data;
        exit();
    }

}
