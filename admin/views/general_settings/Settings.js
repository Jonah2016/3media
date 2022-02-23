$(document).ready(function() {

    // Load data from classes/users/fetchUser.php
    load_data();
    function load_data() {
        // load form
        $(".settings_container").load('./settings_form.php');
        GetSettings();
    }

    function GetSettings() {
        var id = 2065;
        var formData = new FormData();
        formData.append('action', 'get_settings');
        formData.append('sett_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/settings_cl/SettingsController.php',
            method: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {
                if (data.code == "404") {
                    var msg = data.msg
                    error_load_data(msg);
                } else {
                    var set = data;
                    // Assing existing values to the settings fields
                    $('#sett_id').val(set.sett_id);
                    $('#sett_site_name').val(set.sett_site_name);
                    $('#sett_site_tagline').val(set.sett_site_tagline);
                    $('#sett_site_address').val(set.sett_site_address);
                    $('#sett_site_phone1').val(set.sett_site_phone1);
                    $('#sett_site_phone2').val(set.sett_site_phone2);
                    $('#sett_site_phone3').val(set.sett_site_phone3);
                    $('#sett_voting_opened').val(set.sett_voting_opened);
                    $('#sett_site_email').val(set.sett_site_email);
                    $('#sett_mail_server').val(set.sett_mail_server);
                    $('#sett_mail_passwod').val(set.sett_mail_passwod);
                    $('#sett_mail_address').val(set.sett_mail_address);
                    $('#sett_mail_port').val(set.sett_mail_port);
                    $('#sett_sms_api').val(set.sett_sms_api);
                    $('#sett_sms_api_number').val(set.sett_sms_api_number);
                    $('#sett_sms_api_key').val(set.sett_sms_api_key);
                    $('#sett_sms_api_auth').val(set.sett_sms_api_auth);
                    $('#sett_site_fb').val(set.sett_site_fb);
                    $('#sett_site_twitter').val(set.sett_site_twitter);
                    $('#sett_site_instagram').val(set.sett_site_instagram);
                    $('#sett_site_youtube').val(set.sett_site_youtube);
                    $('#sett_site_linkedin').val(set.sett_site_linkedin);
                    $('#sett_site_vimeo').val(set.sett_site_vimeo);
                    $('#sett_site_tiktok').val(set.sett_site_tiktok);
                    $('#sett_site_soundcloud').val(set.sett_site_soundcloud);
                    $('#hid_sett_logo_colored').val(set.sett_logo_colored);
                    $('#hid_sett_logo_black').val(set.sett_logo_black);
                    $('#hid_sett_logo_white').val(set.sett_logo_white);
                    $('#hid_sett_season_banner').val(set.sett_season_banner);

                    if (set.sett_updated_at != "0000-00-00 00:00:00" && set.sett_updated_at != null) { $(".last_update").text("Last update was on: "+set.sett_updated_at); }

                    if (set.sett_logo_colored != "" && set.sett_logo_colored != null) {
                        $('.display_img1').attr('src', '../../../uploads/system/' + set.sett_logo_colored);
                    } else {
                        $('.display_img1').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (set.sett_logo_black != "" && set.sett_logo_black != null) {
                        $('.display_img2').attr('src', '../../../uploads/system/' + set.sett_logo_black);
                    } else {
                        $('.display_img2').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (set.sett_logo_white != "" && set.sett_logo_white != null) {
                        $('.display_img3').attr('src', '../../../uploads/system/' + set.sett_logo_white);
                    } else {
                        $('.display_img3').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (set.sett_season_banner != "" && set.sett_season_banner != null) {
                        $('.display_img4').attr('src', '../../../uploads/system/' + set.sett_season_banner);
                    } else {
                        $('.display_img4').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
    }

    // update setting
    function SaveSettings(formData, index) {
        const site_name = index;
        if (site_name != '') {
            $.ajax({
                url: "../../classes/settings_cl/SettingsController.php",
                method: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if (data.code == "200") {
                        var msg = data.msg
                        success_operation(data.msg);
                        load_data();
                    } else {
                        error_operation(data.msg);
                    }
                }
            });
        }
        return false;
    };
    // End update setting


    //Update settings when 'update_settings_form' button is submitted 
    $(document).on('submit', '#update_settings_form', function(event) {
        event.preventDefault();
        const sett_site_name = $('#sett_site_name').val();
        const sett_site_address = $('#sett_site_address').val();
        const sett_site_phone1 = $('#sett_site_phone1').val();
        const sett_site_email = $('#sett_site_email').val();

        const sett_logo_colored = $('#sett_logo_colored').val();
        const sett_logo_black = $('#sett_logo_black').val();
        const sett_logo_white = $('#sett_logo_white').val();
        const sett_season_banner = $('#sett_season_banner').val();
        const hid_sett_logo_colored = $('#hid_sett_logo_colored').val();

        if(sett_logo_black != "") { 
            const extension = $('#sett_logo_black').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#sett_logo_black').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        if(sett_logo_black != "") { 
            const extension = $('#sett_logo_black').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#sett_logo_black').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        if(sett_logo_white != "") { 
            const extension = $('#sett_logo_white').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#sett_logo_white').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 

        if(sett_logo_colored != "") { 
            const extension = $('#sett_logo_colored').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#sett_logo_colored').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        else if(hid_sett_logo_colored=="" && sett_logo_colored=="") {
            error_operation("Upload original logo. This field cannot be empty.");
            return false;
        }

        if (sett_site_name == "") {
            error_operation("Site name field is required.");
            return false;
        }
        if (sett_site_address == "") {
            error_operation("Site address field is required.");
            return false;
        }
        if (sett_site_phone1 == "") {
            error_operation("Active contact number field is required.");
            return false;
        }
        if (sett_site_email == "") {
            error_operation("Site email field is required.");
            return false;
        }

        // call SaveSettings function
        var formData = new FormData(this);
        formData.append('action', 'save_settings');
        SaveSettings(formData, sett_site_name);
    });


    logoutModalCall();
    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }
    // console.clear();
});