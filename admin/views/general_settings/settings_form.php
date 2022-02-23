<?php 
    // load up system core file (config)
    require_once("../../resources/config.inc.php");
?>

<form method="post" id="update_settings_form" autocomplete="off" novalidate enctype="multipart/form-data">
    <div class="last_update py-2 text-info"></div>
    <div class="card-header mb-2">
        <h5 class="weight-700">-- Basic Info</h5>
    </div>
    <!-- Basic info  -->
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="sett_logo_colored" class="form-control-label">Original Logo <span class="text-danger">*</span></label>
                <p><img src="" class="display_img1" height="100" width="100" /></p>
                <input id="sett_logo_colored" class="input-group form-control form-control-sm" type="file" name="sett_logo_colored" accept="image/*" onchange="previewImageOne(event)">
                <input type="hidden" name="hid_sett_logo_colored" id="hid_sett_logo_colored">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="sett_logo_black" class="form-control-label">Logo black</label>
                <p><img src="" class="display_img2" height="100" width="100" /></p>
                <input id="sett_logo_black" class="input-group form-control form-control-sm" type="file" name="sett_logo_black" accept="image/*" onchange="previewImageTwo(event)">
                <input type="hidden" name="hid_sett_logo_black" id="hid_sett_logo_black">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="sett_logo_white" class="form-control-label">Logo white</label>
                <p><img src="" class="display_img3" height="100" width="100" /></p>
                <input id="sett_logo_white" class="input-group form-control form-control-sm" type="file" name="sett_logo_white" accept="image/*" onchange="previewImageThree(event)">
                <input type="hidden" name="hid_sett_logo_white" id="hid_sett_logo_white">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="sett_season_banner" class="form-control-label">Season's Theme</label>
                <p><img src="" class="display_img4" height="100" width="100" /></p>
                <input id="sett_season_banner" class="input-group form-control form-control-sm" type="file" name="sett_season_banner" accept="image/*" onchange="previewImageFour(event)">
                <input type="hidden" name="hid_sett_season_banner" id="hid_sett_season_banner">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="sett_site_name" class="form-control-label">Site name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="sett_site_name" id="sett_site_name" maxlength="60" required="required">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="sett_site_tagline" class="form-control-label"> Site tagline</label>
                <input type="text" class="form-control" name="sett_site_tagline" id="sett_site_tagline" maxlength="120" >
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="sett_site_address" class="form-control-label">Site address<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="sett_site_address" id="sett_site_address" maxlength="120" required="required">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_phone1" class="form-control-label">Active contact<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="sett_site_phone1" id="sett_site_phone1"  maxlength="15" required="required">
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_phone2" class="form-control-label"> Contact two </label>
                <input type="text" class="form-control" name="sett_site_phone2" id="sett_site_phone2" maxlength="15" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_phone3" class="form-control-label">Contact three </label>
                <input type="text" class="form-control" name="sett_site_phone3" id="sett_site_phone3" maxlength="15" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_email" class="form-control-label"> Email address<span class="text-danger">*</span> </label>
                <input type="email" class="form-control" name="sett_site_email" id="sett_site_email" maxlength="80" required="required">
            </div>
        </div>
    </div>

 
    <div class="card-header mb-2 mt-5">
        <h5 class="weight-700">-- System Settings</h5>
    </div>
    <!-- Other Settings -->
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_voting_opened" class="form-control-label">Voting Opened</label>
                <select class="form-control form-select" name="sett_voting_opened" id="sett_voting_opened">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Email Settings -->
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_mail_server" class="form-control-label">Mail server name </label>
                <input type="text" class="form-control" name="sett_mail_server" id="sett_mail_server" maxlength="80" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_mail_passwod" class="form-control-label"> Mail password </label>
                <input type="password" class="form-control" name="sett_mail_passwod" id="sett_mail_passwod" maxlength="80" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_mail_address" class="form-control-label">Mail address </label>
                <input type="email" class="form-control" name="sett_mail_address" id="sett_mail_address" maxlength="80" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_mail_port" class="form-control-label"> Mail port</label>
                <input type="number" class="form-control" name="sett_mail_port" id="sett_mail_port" maxlength="5" >
            </div>
        </div>
    </div>
    <!-- SMS Settings -->
    <div class="row mt-2">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_sms_api" class="form-control-label">SMS API type</label>
                <select class="form-control form-select" name="sett_sms_api" id="sett_sms_api">
                	<option value=""></option>
                	<option value="twilio">Twilio API</option>
                	<option value="nexmo">Nexmo API</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_sms_api_number" class="form-control-label"> Phone number </label>
                <input type="text" class="form-control" name="sett_sms_api_number" id="sett_sms_api_number" maxlength="15" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_sms_api_key" class="form-control-label">API key </label>
                <input type="text" class="form-control" name="sett_sms_api_key" id="sett_sms_api_key" maxlength="250" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_sms_api_auth" class="form-control-label"> Authorization key</label>
                <input type="text" class="form-control" name="sett_sms_api_auth" id="sett_sms_api_auth" maxlength="250" >
            </div>
        </div>
    </div>

    <div class="card-header mb-2 mt-5">
        <h5 class="weight-700">-- Social Media</h5>
    </div>
    <!-- social media Settings -->
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_fb" class="form-control-label">Facebook <span class="pl-1 bi bi-center bi-facebook"></span></label>
                <input type="text" class="form-control" name="sett_site_fb" id="sett_site_fb" maxlength="250" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_twitter" class="form-control-label"> Twitter <span class="pl-1 bi bi-center bi-twitter"></span></label>
                <input type="text" class="form-control" name="sett_site_twitter" id="sett_site_twitter" maxlength="250" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_instagram" class="form-control-label">Instagram <span class="pl-1 bi bi-center bi-instagram"></span></label>
                <input type="text" class="form-control" name="sett_site_instagram" id="sett_site_instagram" maxlength="250" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_youtube" class="form-control-label"> Youtube <span class="pl-1 bi bi-center bi-youtube"></span></label>
                <input type="text" class="form-control" name="sett_site_youtube" id="sett_site_youtube" maxlength="250" >
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_linkedin" class="form-control-label">LinkedIn <span class="pl-1 bi bi-center bi-linkedin"></span></label>
                <input type="text" class="form-control" name="sett_site_linkedin" id="sett_site_linkedin" maxlength="250" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_tiktok" class="form-control-label"> TikTok <span class="pl-1 fas fa-tiktok"></span></label>
                <input type="text" class="form-control" name="sett_site_tiktok" id="sett_site_tiktok" maxlength="250" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_soundcloud" class="form-control-label">Sound cloud <span class="pl-1 fa fa-soundcloud"></span></label>
                <input type="text" class="form-control" name="sett_site_soundcloud" id="sett_site_soundcloud" maxlength="250" >
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label for="sett_site_vimeo" class="form-control-label"> Vimeo <span class="pl-1 fas fa-vimeo"></span> </label>
                <input type="text" class="form-control" name="sett_site_vimeo" id="sett_site_vimeo" maxlength="250" >
            </div>
        </div>
    </div>

    <div class="row mb-3 mt-5">
        <div class="col-md-4 offset-md-4">
            <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="bi bi-center bi-save2 bi-center"></i> Save </button>
        </div>
    </div>  
</form>


