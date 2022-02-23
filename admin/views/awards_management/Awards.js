$(document).ready(function() {

    function load_data() {
        $("#awards_category_data").load('../../classes/awards_cl/FetchAwardsCategory.php');
        $("#add_awards_category_container").load('../../resources/form-modals/add-modals/add_awards_category.php');
        $("#edit_awards_category_container").load('../../resources/form-modals/edit-modals/edit_awards_category.php');
    }

    // Retrieve about awards
    function GetAboutAward() {
        var id = 2064;
        var formData = new FormData();
        formData.append('action', 'get_about_award');
        formData.append('award_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/AwardsController.php',
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
                    var award = data;
                    // Assing existing values to the settings fields
                    $('#award_id').val(award.award_id);
                    $('#award_organisation_name').val(award.award_organisation_name);
                    $('#hid_award_cover_image').val(award.award_cover_image);
                    $('#hid_award_photo_one').val(award.award_photo_one);
                    $('#hid_award_photo_two').val(award.award_photo_two);
                    $('#hid_award_photo_three').val(award.award_photo_three);
                    $('#award_description').summernote("code", award.award_description);

                    if (award.award_updated_at != "0000-00-00 00:00:00" && award.award_updated_at != null) { $(".last_update").text("Last update was on: "+award.award_updated_at); }

                    if (award.award_cover_image != "" && award.award_cover_image != null) {
                        $('.display_img1').attr('src', '../../../uploads/awards/' + award.award_cover_image);
                    } else {
                        $('.display_img1').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (award.award_photo_one != "" && award.award_photo_one != null) {
                        $('.display_img2').attr('src', '../../../uploads/awards/' + award.award_photo_one);
                    } else {
                        $('.display_img2').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (award.award_photo_two != "" && award.award_photo_two != null) {
                        $('.display_img3').attr('src', '../../../uploads/awards/' + award.award_photo_two);
                    } else {
                        $('.display_img3').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                    if (award.award_photo_three != "" && award.award_photo_three != null) {
                        $('.display_img4').attr('src', '../../../uploads/awards/' + award.award_photo_three);
                    } else {
                        $('.display_img4').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
        $("#about_awards_form").load('./about_awards_form.php');
    }
    // update about awards
    function SaveAboutAwards(formData, description) {
        const award_description = description;
        if (award_description != '') {
            $.ajax({
                url: "../../classes/awards_cl/AwardsController.php",
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
                        GetAboutAward();
                    } else {
                        error_operation(data.msg);
                    }
                }
            });
        }
        return false;
    };
    //Update settings when 'update_award_form' button is submitted 
    $(document).on('submit', '#update_award_form', function(event) {
        event.preventDefault();
        const award_cover_image = $('#award_cover_image').val();
        const award_description = $('#award_description').val();

        if(award_cover_image != "") { 
            const extension = $('#award_cover_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#award_cover_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        else if(hid_award_cover_image=="" && award_cover_image=="") {
            error_operation("Cover image field cannot be empty.");
            return false;
        }
        if (award_description == "") {
            error_operation("About 3Music award field is required.");
            return false;
        }

        // call SaveAboutAwards function
        var formData = new FormData(this);
        formData.append('action', 'save_about_award');
        SaveAboutAwards(formData, award_description);
    });




    function GetAwardCategory(id) {
        const formData = new FormData();
        formData.append('action', 'get_award_category');
        formData.append('hashed_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/AwardsController.php',
            method: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {
                if (data.code == "404") {
                    const msg = data.msg
                    error_operation(msg);
                } else {
                    const awc = data;
                    // Assing existing values to the modal popup fields
                    $(".hidden_hashed").val(awc.awc_hashed);
                    $(".ed_awc_description").val(awc.awc_description);
                    $(".ed_awc_title").val(awc.awc_title);
                    // multi select collection options
                    let selected_awc_year_values = awc.awc_year.split(',');
                    $('.ed_awc_year').selectpicker('val', selected_awc_year_values);

                    $(".hidden_awc_cover_image").val(awc.awc_cover_image);
                    $('.ed_awc_description').summernote("code", awc.awc_description);
                    if (awc.awc_updated_at == "0000-00-00 00:00:00" || awc.awc_updated_at == null) { $(".ed_awc_updated_at").text("N/A"); } else { $(".ed_awc_updated_at").text(awc.awc_updated_at); }
                    if (awc.awc_cover_image != "") {
                        $('.display_img').attr('src', '../../../uploads/awards/' + awc.awc_cover_image);
                    } else {
                        $('.display_img').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
        // Open modal
        $(".editAwardCategoryModal").modal("show");
    }
    // Add award category when saveAwardCategory is submitted
    function SaveAwardCategory(formData) {
        // Save the details by requesting to the server using ajax
        const awc_title = $('#awc_title').val();
        const awc_cover_image = $('#awc_cover_image').val();
        const awc_description = $('#awc_description').val();
        if (awc_description != "" || awc_title != "" || awc_cover_image != "") {
            $.ajax({
                url: '../../classes/awards_cl/AwardsController.php',
                method: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if (data.code == "200") {
                        const msg = data.msg;
                        success_operation(msg);
                        $("#add_award_category_form")[0].reset()
                        $('.display_img').attr('src', '');
                        $('.summernote_editor').summernote('code', '');
                        $("#addAwardCategoryModal").modal("hide");
                        load_data();
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Make sure a video description or title or cover image field is not empty";
            error_operation(msg);
        }
    }
    // Update award category when UpdateAwardCategory is submitted
    function UpdateAwardCategory(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/AwardsController.php',
            method: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(data) {
                if (data.code == "200") {
                    const msg = data.msg
                    success_operation(msg);
                    $('.display_img').attr('src', '');
                    $('.ed_summernote_editor').summernote('code', '');
                    load_data();
                    $(".editAwardCategoryModal").modal("hide");
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Activate award category when ActivateAwardCategory is submitted
    function ActivateAwardCategory(id, status, title) {
        Swal.fire({
            title: title,
            text: "You can change this later!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'activate_award_category');
                formData.append('up_awc_id', id);
                formData.append('up_awc_active_status', status);
                // Delete news by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/AwardsController.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.code == "200") {
                            const msg = data.msg
                            success_operation(msg);
                            load_data();
                        } else {
                            const msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }
    // Delete award category Potrait when deleteAwardCategory is submitted
    function DeleteAwardCategory(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this award category?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_award_category');
                formData.append('del_awc_id', id);
                // Delete video by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/AwardsController.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.code == "200") {
                            const msg = data.msg
                            success_operation(msg);
                            load_data();
                        } else {
                            const msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }

    // save award category when add_award_category_form is submitted
    $(document).on('submit', '#add_award_category_form', function(event) {
        event.preventDefault();
        const awc_title = $('#awc_title').val()
        const awc_description = $('#awc_description').val()
        const awc_cover_image = $('#awc_cover_image').val()
        const awc_year = $('#awc_year').val()

        if (awc_cover_image == '') {
            const msg = "Cover image is required";
            error_operation(msg);
            return false;
        }
        if(awc_cover_image != "") { 
            const extension = $('#awc_cover_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#awc_cover_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }

        if (awc_title == '') {
            const msg = "Title of award category is required";
            error_operation(msg);
            return false;
        }
        if (awc_description == '') {
            const msg = "Award category description is required";
            error_operation(msg);
            return false;
        }
        if (awc_year == '') {
            const msg = "Award year is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'save_award_category');
        SaveAwardCategory(formData);
    });
    // update award category when edit_award_category_form is submitted
    $(document).on('submit', '.edit_award_category_form', function(event) {
        event.preventDefault();
        const awc_title = $('.ed_awc_title').val()
        const awc_description = $('.ed_awc_description').val()
        const awc_cover_image = $('.ed_awc_cover_image').val()
        const hidden_awc_cover_image = $('.hidden_awc_cover_image').val()
        const awc_year = $('select.ed_awc_year').val()

        if(awc_cover_image != "") { 
            const extension = $('#awc_cover_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#awc_cover_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }
        if (awc_cover_image == '' && hidden_awc_cover_image == '') {
            const msg = "Cover image is required";
            error_operation(msg);
            return false;
        }

        if (awc_title == '') {
            const msg = "Title of award category is required";
            error_operation(msg);
            return false;
        }
        if (awc_description == '') {
            const msg = "Award category description is required";
            error_operation(msg);
            return false;
        }
        if (awc_year == '') {
            const msg = "Award year is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'update_award_category');
        UpdateAwardCategory(formData);
    });

    // Edit award category when edit button is clicked
    $(document).on('click', '.edit_award_category', function() {
        const id = $(this).data('id');
        // pass data-id GetAwardCategory function
        GetAwardCategory(id);
    });
    //Load update content when 'activate_award_category' button is clicked in table
    $(document).on('click', '.activate_award_category', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to disable this award category."
        }
        else if (status == 0) {
            var title = "Do you want to enable this award category."
        }
        else{
            var title = "Do you want to enable this award category."
        }
        // pass data-id ActivateAwardCategory function
        ActivateAwardCategory(id, status, title);
    });
    // Delete award category when delete button is clicked
    $(document).on('click', '.delete_award_category', function() {
        const id = $(this).data('id');
        // pass data-id DeleteAwardCategory function
        DeleteAwardCategory(id);
    });



    // Call functions
    load_data();
    GetAboutAward();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});