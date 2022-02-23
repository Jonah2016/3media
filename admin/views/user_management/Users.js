$(document).ready(function() {

    // Load data from classes/users/fetchUser.php
    load_data();
    function load_data() {
        $("#user_data").load('../../classes/users_cl/FetchUsers.php')
        // load modals
        $(".add_modal_container").load('../../resources/form-modals/add-modals/add_user.php')
        $(".edit_modal_container").load('../../resources/form-modals/edit-modals/edit_user.php')
    }

    // Add new user
    $(document).on('submit', '#add_user_form', function(event) {
        event.preventDefault();
        var fname = $("#user_fname").val();
        var lname = $("#user_lname").val();
        var extension = $('#user_image').val().split('.').pop().toLowerCase();
        if (extension != '') {
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                var err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                $('#user_image').val('');
                $('#addNewUserModal').modal('hide');
                error_operation(err_msg);
                return false;
            }
        }
        if (fname != '' && lname != "") {
            $.ajax({
                url: "../../classes/users_cl/UserController.php",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if (data.code == "200") {
                        $('#add_user_form')[0].reset();
                        success_operation(data.msg);
                        $("#user_data").load('../../classes/users_cl/FetchUsers.php');
                        $('.display_img').attr('src', '');
                    } else {
                        error_operation(data.msg);
                    }
                }
            });
        }
        return false;
    });
    // End Add new user

    // Edit user data
    $(document).on('click', 'a[data-role=update_user]', function() {

        var user_code = $(this).data('id');
        var nuser_fname = $('#' + user_code + 'ususer_fname').text();
        var nuser_lname = $('#' + user_code + 'ususer_lname').text();
        var nuser_password = $('#' + user_code + 'ususer_password').text();
        var nuser_active_status = $('#' + user_code + 'ususer_active_status').text();
        var nuser_online_status = $('#' + user_code + 'ususer_online_status').text();
        var nuser_profile_pic = $('#' + user_code + 'ususer_profile_pic').text();
        var nuser_img_url = $('#' + user_code + 'ususer_img_url').text();
        var nuser_email = $('#' + user_code + 'ususer_email').text();
        var nuser_account_type = $('#' + user_code + 'ususer_account_type').text();
        var nuser_account = $('#' + user_code + 'ususer_account').text();

        // Populate permissions fields in edit form
        // Users
        var nuser_permission = $('#' + user_code + 'ususer_permission').text();
        var nuser_add = $('#' + user_code + 'ususer_add').text();
        var nuser_edit = $('#' + user_code + 'ususer_edit').text();
        var nuser_read = $('#' + user_code + 'ususer_read').text();
        var nuser_delete = $('#' + user_code + 'ususer_delete').text();
        // Settings
        var nset_permission = $('#' + user_code + 'usset_permission').text();
        var nset_add = $('#' + user_code + 'usset_add').text();
        var nset_edit = $('#' + user_code + 'usset_edit').text();
        var nset_read = $('#' + user_code + 'usset_read').text();
        var nset_delete = $('#' + user_code + 'usset_delete').text();
        // news
        var nnews_permission = $('#' + user_code + 'usnews_permission').text();
        var nnews_add = $('#' + user_code + 'usnews_add').text();
        var nnews_edit = $('#' + user_code + 'usnews_edit').text();
        var nnews_read = $('#' + user_code + 'usnews_read').text();
        var nnews_delete = $('#' + user_code + 'usnews_delete').text();
        // blogs
        var nblog_permission = $('#' + user_code + 'usblog_permission').text();
        var nblog_add = $('#' + user_code + 'usblog_add').text();
        var nblog_edit = $('#' + user_code + 'usblog_edit').text();
        var nblog_read = $('#' + user_code + 'usblog_read').text();
        var nblog_delete = $('#' + user_code + 'usblog_delete').text();
        // gallery
        var ngal_permission = $('#' + user_code + 'usgal_permission').text();
        var ngal_add = $('#' + user_code + 'usgal_add').text();
        var ngal_edit = $('#' + user_code + 'usgal_edit').text();
        var ngal_read = $('#' + user_code + 'usgal_read').text();
        var ngal_delete = $('#' + user_code + 'usgal_delete').text();
        // media
        var nmed_permission = $('#' + user_code + 'usmed_permission').text();
        var nmed_add = $('#' + user_code + 'usmed_add').text();
        var nmed_edit = $('#' + user_code + 'usmed_edit').text();
        var nmed_read = $('#' + user_code + 'usmed_read').text();
        var nmed_delete = $('#' + user_code + 'usmed_delete').text();
        // events
        var neve_permission = $('#' + user_code + 'useve_permission').text();
        var neve_add = $('#' + user_code + 'useve_add').text();
        var neve_edit = $('#' + user_code + 'useve_edit').text();
        var neve_read = $('#' + user_code + 'useve_read').text();
        var neve_delete = $('#' + user_code + 'useve_delete').text();
        // adverts
        var nadv_permission = $('#' + user_code + 'usadv_permission').text();
        var nadv_add = $('#' + user_code + 'usadv_add').text();
        var nadv_edit = $('#' + user_code + 'usadv_edit').text();
        var nadv_read = $('#' + user_code + 'usadv_read').text();
        var nadv_delete = $('#' + user_code + 'usadv_delete').text();
        // sales
        var nsal_permission = $('#' + user_code + 'ussal_permission').text();
        var nsal_add = $('#' + user_code + 'ussal_add').text();
        var nsal_edit = $('#' + user_code + 'ussal_edit').text();
        var nsal_read = $('#' + user_code + 'ussal_read').text();
        var nsal_delete = $('#' + user_code + 'ussal_delete').text();
        // contacts
        var ncon_permission = $('#' + user_code + 'uscon_permission').text();
        var ncon_add = $('#' + user_code + 'uscon_add').text();
        var ncon_edit = $('#' + user_code + 'uscon_edit').text();
        var ncon_read = $('#' + user_code + 'uscon_read').text();
        var ncon_delete = $('#' + user_code + 'uscon_delete').text();

        // Populate fields in edit form
        $('.ed_user_code').val(user_code);
        $('.ed_user_fname').val(nuser_fname);
        $('.ed_user_lname').val(nuser_lname);
        $('.ed_user_email').val(nuser_email);
        $('.ed_user_account_type').val(nuser_account_type);
        $('.ed_user_account').val(nuser_account);
        $('.ed_user_active_status').val(nuser_active_status);
        $('.ed_user_online_status').val(nuser_online_status);
        $("#display_img").attr("src", nuser_img_url);
        $('.ed_hidden_user_pic').val(nuser_profile_pic);
        $('.ed_hidden_user_id').val(user_code);

        // fill user permissions into edit forms
        // Users
        (nuser_permission == 1) ? $('input[name=ed_user_permission]').attr('checked', true): $('input[name=ed_user_permission]').attr('checked', false);
        (nuser_add == 1) ? $('input[name=ed_user_add]').attr('checked', true): $('input[name=ed_user_add]').attr('checked', false);
        (nuser_edit == 1) ? $('input[name=ed_user_edit]').attr('checked', true): $('input[name=ed_user_edit]').attr('checked', false);
        (nuser_read == 1) ? $('input[name=ed_user_read]').attr('checked', true): $('input[name=ed_user_read]').attr('checked', false);
        (nuser_delete == 1) ? $('input[name=ed_user_delete]').attr('checked', true): $('input[name=ed_user_delete]').attr('checked', false);
        // settings
        (nset_permission == 1) ? $('input[name=ed_set_permission]').attr('checked', true): $('input[name=ed_set_permission]').attr('checked', false);
        (nset_add == 1) ? $('input[name=ed_set_add]').attr('checked', true): $('input[name=ed_set_add]').attr('checked', false);
        (nset_edit == 1) ? $('input[name=ed_set_edit]').attr('checked', true): $('input[name=ed_set_edit]').attr('checked', false);
        (nset_read == 1) ? $('input[name=ed_set_read]').attr('checked', true): $('input[name=ed_set_read]').attr('checked', false);
        (nset_delete == 1) ? $('input[name=ed_set_delete]').attr('checked', true): $('input[name=ed_set_delete]').attr('checked', false);
        // news
        (nnews_permission == 1) ? $('input[name=ed_news_permission]').attr('checked', true): $('input[name=ed_news_permission]').attr('checked', false);
        (nnews_add == 1) ? $('input[name=ed_news_add]').attr('checked', true): $('input[name=ed_news_add]').attr('checked', false);
        (nnews_edit == 1) ? $('input[name=ed_news_edit]').attr('checked', true): $('input[name=ed_news_edit]').attr('checked', false);
        (nnews_read == 1) ? $('input[name=ed_news_read]').attr('checked', true): $('input[name=ed_news_read]').attr('checked', false);
        (nnews_delete == 1) ? $('input[name=ed_news_delete]').attr('checked', true): $('input[name=ed_news_delete]').attr('checked', false);
        // blogs
        (nblog_permission == 1) ? $('input[name=ed_blog_permission]').attr('checked', true): $('input[name=ed_blog_permission]').attr('checked', false);
        (nblog_add == 1) ? $('input[name=ed_blog_add]').attr('checked', true): $('input[name=ed_blog_add]').attr('checked', false);
        (nblog_edit == 1) ? $('input[name=ed_blog_edit]').attr('checked', true): $('input[name=ed_blog_edit]').attr('checked', false);
        (nblog_read == 1) ? $('input[name=ed_blog_read]').attr('checked', true): $('input[name=ed_blog_read]').attr('checked', false);
        (nblog_delete == 1) ? $('input[name=ed_blog_delete]').attr('checked', true): $('input[name=ed_blog_delete]').attr('checked', false);
        // gallery
        (ngal_permission == 1) ? $('input[name=ed_gal_permission]').attr('checked', true): $('input[name=ed_gal_permission]').attr('checked', false);
        (ngal_add == 1) ? $('input[name=ed_gal_add]').attr('checked', true): $('input[name=ed_gal_add]').attr('checked', false);
        (ngal_edit == 1) ? $('input[name=ed_gal_edit]').attr('checked', true): $('input[name=ed_gal_edit]').attr('checked', false);
        (ngal_read == 1) ? $('input[name=ed_gal_read]').attr('checked', true): $('input[name=ed_gal_read]').attr('checked', false);
        (ngal_delete == 1) ? $('input[name=ed_gal_delete]').attr('checked', true): $('input[name=ed_gal_delete]').attr('checked', false);
        // media
        (nmed_permission == 1) ? $('input[name=ed_med_permission]').attr('checked', true): $('input[name=ed_med_permission]').attr('checked', false);
        (nmed_add == 1) ? $('input[name=ed_med_add]').attr('checked', true): $('input[name=ed_med_add]').attr('checked', false);
        (nmed_edit == 1) ? $('input[name=ed_med_edit]').attr('checked', true): $('input[name=ed_med_edit]').attr('checked', false);
        (nmed_read == 1) ? $('input[name=ed_med_read]').attr('checked', true): $('input[name=ed_med_read]').attr('checked', false);
        (nmed_delete == 1) ? $('input[name=ed_med_delete]').attr('checked', true): $('input[name=ed_med_delete]').attr('checked', false);
        // events
        (neve_permission == 1) ? $('input[name=ed_eve_permission]').attr('checked', true): $('input[name=ed_eve_permission]').attr('checked', false);
        (neve_add == 1) ? $('input[name=ed_eve_add]').attr('checked', true): $('input[name=ed_eve_add]').attr('checked', false);
        (neve_edit == 1) ? $('input[name=ed_eve_edit]').attr('checked', true): $('input[name=ed_eve_edit]').attr('checked', false);
        (neve_read == 1) ? $('input[name=ed_eve_read]').attr('checked', true): $('input[name=ed_eve_read]').attr('checked', false);
        (neve_delete == 1) ? $('input[name=ed_eve_delete]').attr('checked', true): $('input[name=ed_eve_delete]').attr('checked', false);
        // adverts
        (nadv_permission == 1) ? $('input[name=ed_adv_permission]').attr('checked', true): $('input[name=ed_adv_permission]').attr('checked', false);
        (nadv_add == 1) ? $('input[name=ed_adv_add]').attr('checked', true): $('input[name=ed_adv_add]').attr('checked', false);
        (nadv_edit == 1) ? $('input[name=ed_adv_edit]').attr('checked', true): $('input[name=ed_adv_edit]').attr('checked', false);
        (nadv_read == 1) ? $('input[name=ed_adv_read]').attr('checked', true): $('input[name=ed_adv_read]').attr('checked', false);
        (nadv_delete == 1) ? $('input[name=ed_adv_delete]').attr('checked', true): $('input[name=ed_adv_delete]').attr('checked', false);
        // sales
        (nsal_permission == 1) ? $('input[name=ed_sal_permission]').attr('checked', true): $('input[name=ed_sal_permission]').attr('checked', false);
        (nsal_add == 1) ? $('input[name=ed_sal_add]').attr('checked', true): $('input[name=ed_sal_add]').attr('checked', false);
        (nsal_edit == 1) ? $('input[name=ed_sal_edit]').attr('checked', true): $('input[name=ed_sal_edit]').attr('checked', false);
        (nsal_read == 1) ? $('input[name=ed_sal_read]').attr('checked', true): $('input[name=ed_sal_read]').attr('checked', false);
        (nsal_delete == 1) ? $('input[name=ed_sal_delete]').attr('checked', true): $('input[name=ed_sal_delete]').attr('checked', false);
        // contacts
        (ncon_permission == 1) ? $('input[name=ed_con_permission]').attr('checked', true): $('input[name=ed_con_permission]').attr('checked', false);
        (ncon_add == 1) ? $('input[name=ed_con_add]').attr('checked', true): $('input[name=ed_con_add]').attr('checked', false);
        (ncon_edit == 1) ? $('input[name=ed_con_edit]').attr('checked', true): $('input[name=ed_con_edit]').attr('checked', false);
        (ncon_read == 1) ? $('input[name=ed_con_read]').attr('checked', true): $('input[name=ed_con_read]').attr('checked', false);
        (ncon_delete == 1) ? $('input[name=ed_con_delete]').attr('checked', true): $('input[name=ed_con_delete]').attr('checked', false);

        $('.editUserModal').modal('show');
    });
    $(document).on('submit', '.edit_user_form', function(event) {
        event.preventDefault();
        var fname = $(".ed_user_fname").val();
        var lname = $(".ed_user_lname").val();
        var extension = $('.ed_user_image').val().split('.').pop().toLowerCase();
        if (extension != '') {
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                var edit_error = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                $('.ed_user_image').val('');
                $('.editUserModal').modal('hide');
                error_operation(edit_error);
                return false;
            }
        }
        if (fname != '' && lname != "") {
            $.ajax({
                url: '../../classes/users_cl/UserController.php',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if (data.code == "200") {
                        $('.edit_user_form')[0].reset();
                        $('.editUserModal').modal('hide');
                        success_operation(data.msg);
                        $("#user_data").load('../../classes/users_cl/FetchUsers.php');
                        $('.display_img').attr('src', '');
                    } else {
                        error_operation(data.msg);
                    }
                }
            })
        }
    });
    // End Edit user data

    // activate and deactivate user
    function ActivateUser(ucode, status, new_title) {
        Swal.fire({
            title: new_title,
            text: "You can revert this later!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('action', 'activate_status');
                formData.append('up_user_code', ucode);
                formData.append('up_user_active_status', status);
                $.ajax({
                    url: '../../classes/users_cl/UserController.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.code == "200") {
                            var msg = data.msg
                            success_operation(msg);
                            $("#user_data").load('../../classes/users_cl/FetchUsers.php');
                        } else {
                            var msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }
    // End activate and deactivate user

    // Delete user data 
    function DeleteUser(ucode, title, action, new_url, token) {
        Swal.fire({
            title: title,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('action', action);
                formData.append(token, ucode);
                // Update status by requesting to the server using ajax
                $.ajax({
                    url: new_url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.code == "200") {
                            var msg = data.msg
                            success_operation(msg);
                            $("#user_data").load('../../classes/users_cl/FetchUsers.php');
                        } else {
                            var msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }

    //Update content when 'activate_status' button is clicked 
    $(document).on('click', '.activate_status', function(event) {
        event.preventDefault();
        var ucode = $(this).data('id');
        var status = $(this).data('status');
        if (status == 0) {
            var new_title = "Do you want to enable this user?"
        } else if (status == 1) {
            var new_title = "Do you want to disable this user?"
        }
        // pass data-id ActivateUser function
        ActivateUser(ucode, status, new_title);
    });
    //Delete content when 'delete_user' button is clicked in table
    $(document).on('click', '.delete_user', function(event) {
        event.preventDefault();
        var ucode = $(this).data('id');
        var title = "Do you want to delete this user?";
        var action = "delete_user";
        var token = "del_user_code"
        var url = "../../classes/users_cl/UserController.php";
        DeleteUser(ucode, title, action, url, token);
    });



    logoutModalCall();
    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }
    // console.clear();
});