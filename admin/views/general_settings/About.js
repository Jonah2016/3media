$(document).ready(function() {

    // Load data from classes/users/fetchUser.php
    load_data();
    function load_data() {
        // load form
        $(".about_container").load('./about_form.php');
        GetAbout();
    }

    function GetAbout() {
        var id = 2066;
        var formData = new FormData();
        formData.append('action', 'get_about');
        formData.append('abt_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/settings_cl/AboutController.php',
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
                    var abt = data;
                    // Assing existing values to the settings fields
                    $('#abt_id').val(abt.abt_id);
                    $('#abt_organisation_name').val(abt.abt_organisation_name);
                    $('#hid_abt_photo_one').val(abt.abt_photo_one);
                    $('#hid_abt_photo_two').val(abt.abt_photo_two);
                    $('#hid_abt_photo_three').val(abt.abt_photo_three);
                    $('#abt_brief_description').val(abt.abt_brief_description);
                    $('#abt_full_description').summernote("code", abt.abt_full_description);

                    if (abt.abt_updated_at != "0000-00-00 00:00:00" && abt.abt_updated_at != null) { $(".last_update").text("Last update was on: "+abt.abt_updated_at); }

                    if (abt.abt_photo_one != "" && abt.abt_photo_one != null) {
                        $('.display_img1').attr('src', '../../../uploads/system/' + abt.abt_photo_one);
                    } else {
                        $('.display_img1').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (abt.abt_photo_two != "" && abt.abt_photo_two != null) {
                        $('.display_img2').attr('src', '../../../uploads/system/' + abt.abt_photo_two);
                    } else {
                        $('.display_img2').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (abt.abt_photo_three != "" && abt.abt_photo_three != null) {
                        $('.display_img3').attr('src', '../../../uploads/system/' + abt.abt_photo_three);
                    } else {
                        $('.display_img3').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
    }

    // update setting
    function SaveAbout(formData, index) {
        const abt_organisation_name = index;
        if (abt_organisation_name != '') {
            $.ajax({
                url: "../../classes/settings_cl/AboutController.php",
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
        const abt_photo_one = $('#abt_photo_one').val();
        const abt_organisation_name = $('#abt_organisation_name').val();
        const abt_brief_description = $('#abt_brief_description').val();
        const abt_full_description = $('#abt_full_description').val();

        if(abt_photo_one != "") { 
            const extension = $('#abt_photo_one').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#abt_photo_one').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        else if(hid_abt_photo_one=="" && abt_photo_one=="") {
            error_operation("Cover image field cannot be empty.");
            return false;
        }

        if (abt_organisation_name == "") {
            error_operation("Company name field is required.");
            return false;
        }
        if (abt_brief_description == "") {
            error_operation("Summarized description field is required.");
            return false;
        }
        if (abt_full_description == "") {
            error_operation("Full description field is required.");
            return false;
        } 

        // call SaveAbout function
        var formData = new FormData(this);
        formData.append('action', 'save_about');
        SaveAbout(formData, abt_organisation_name);
    });


    logoutModalCall();
    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }
    // console.clear();
});