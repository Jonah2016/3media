$(document).ready(function() {

    function load_data() {
        $("#adverts_data").load('../../classes/advs_mgt_cl/FetchAdvs.php');
        $("#add_advs_container").load('../../resources/form-modals/add-modals/add_advs.php');
        $("#edit_advs_container").load('../../resources/form-modals/edit-modals/edit_advs.php');
    }

    function GetAdvertsDetails(id) {
        const formData = new FormData();
        formData.append('action', 'get_adv');
        formData.append('hashed_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/advs_mgt_cl/AdvsController.php',
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
                    const adv = data;
                    // Assing existing values to the modal popup fields
                    $(".hidden_hashed").val(adv.adverts_hashed);
                    $(".ed_adverts_type").val(adv.adverts_type);
                    $(".ed_adverts_dimension").val(adv.adverts_dimension);
                    $(".ed_adverts_category").val(adv.adverts_category);
                    $(".ed_adverts_title").val(adv.adverts_title);
                    $(".ed_adverts_briefing").val(adv.adverts_briefing);
                    $(".ed_adverts_organisation").val(adv.adverts_organisation);
                    $(".prev_adverts_campaign_days").val(adv.adverts_campaign_days);
                    $(".ed_adverts_start_date").val(adv.adverts_start_date);
                    $(".ed_adverts_end_date").val(adv.adverts_end_date);
                    $(".ed_adverts_url").val(adv.adverts_url);
                    $(".ed_adverts_video_url").val(adv.adverts_video_url);
                    $(".hidden_adverts_cover_image").val(adv.adverts_cover_image);

                    if (adv.adverts_updated_at == "0000-00-00 00:00:00" || adv.adverts_updated_at == null) { $(".ed_adverts_updated_at").text("N/A"); } else { $(".ed_adverts_updated_at").text(adv.adverts_updated_at); }
                    if (adv.adverts_cover_image != "") {
                        $('.display_img').attr('src', '../../../uploads/advsImages/' + adv.adverts_cover_image);
                    } else {
                        $('.display_img').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
        // Open modal
        $(".editAdvModal").modal("show");
    }
    // Add advert when saveAdverts is submitted
    function SaveAdverts(formData) {
        // Save the details by requesting to the server using ajax
        const adverts_title = $('#adverts_title').val();
        const adverts_type = $('#adverts_type').val();
        const adverts_category = $('#adverts_category').val();
        const adverts_start_date = $('#adverts_start_date').val();
        const adverts_end_date = $('#adverts_end_date').val();
        const adverts_organisation = $('#adverts_organisation').val();
        if (adverts_category != "" || adverts_title != "" || adverts_start_date != "" || adverts_end_date != "" || adverts_organisation != "" || adverts_type != "") {
            $.ajax({
                url: '../../classes/advs_mgt_cl/AdvsController.php',
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
                        $("#add_adv_form")[0].reset()
                        $('.display_img').attr('src', '');
                        $("#addAdvModal").modal("hide");
                        load_data();
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Something went wrong! Make sure an category or title or date or organisation field is not empty";
            error_operation(msg);
        }
    }
    // Update advert when UpdateAdverts is submitted
    function UpdateAdverts(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/advs_mgt_cl/AdvsController.php',
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
                    $(".editAdvModal").modal("hide");
                    load_data();
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Activate advert when ActivateAdverts is submitted
    function ActivateAdverts(id, status, title) {
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
                formData.append('action', 'activate_adv');
                formData.append('up_adv_id', id);
                formData.append('up_adv_active_status', status);
                // Delete advert by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/advs_mgt_cl/AdvsController.php',
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
    // Delete advert Potrait when deleteAdvert is submitted
    function DeleteAdvert(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this advert?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_adv');
                formData.append('del_adv_id', id);
                // Delete advert by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/advs_mgt_cl/AdvsController.php',
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

    // save advert when add_adv_form is submitted
    $(document).on('submit', '#add_adv_form', function(event) {
        event.preventDefault();

        const adverts_title = $('#adverts_title').val();
        const adverts_type = $('#adverts_type').val();
        const adverts_category = $('#adverts_category').val();
        const adverts_start_date = $('#adverts_start_date').val();
        const adverts_end_date = $('#adverts_end_date').val();
        const adverts_organisation = $('#adverts_organisation').val();
        const adverts_campaign_days = $('select#adverts_campaign_days').val();
        const adverts_dimension = $('#adverts_dimension').val()
        const adverts_cover_image = $('#adverts_cover_image').val()

        if(adverts_cover_image != "") { 
            const extension = $('#adverts_cover_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#adverts_cover_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }
        if (adverts_cover_image == '') {
            const msg = "Upload a cover image for the advert. This field cannot be empty.";
            error_operation(msg);
            return false;
        } 

        if (adverts_title == '') {
            const msg = "Title of advert is required";
            error_operation(msg);
            return false;
        }
        if (adverts_type == '') {
            const msg = "Select the ad type. Field is required.";
            error_operation(msg);
            return false;
        }
        if (adverts_category == '') {
            const msg = "Category of ad is required";
            error_operation(msg);
            return false;
        }
        if (adverts_campaign_days == '') {
            const msg = "Ad days to display is required";
            error_operation(msg);
            return false;
        }
        if (adverts_dimension == '') {
            const msg = "Dimension for this ad is required";
            error_operation(msg);
            return false;
        }
        if (adverts_organisation == '') {
            const msg = "Organisation publishing this ad is required";
            error_operation(msg);
            return false;
        }
        if (adverts_start_date == '') {
            const msg = "Ad campaign start date is required";
            error_operation(msg);
            return false;
        }
        if (adverts_end_date == '') {
            const msg = "Ad campaign end date is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'save_adv');
        SaveAdverts(formData);
    });
    // update advert when edit_advert_form is submitted
    $(document).on('submit', '.edit_adv_form', function(event) {
        event.preventDefault();
        const adverts_title = $('.ed_adverts_title').val();
        const adverts_type = $('.ed_adverts_type').val();
        const adverts_category = $('.ed_adverts_category').val();
        const adverts_start_date = $('.ed_adverts_start_date').val();
        const adverts_end_date = $('.ed_adverts_end_date').val();
        const adverts_organisation = $('.ed_adverts_organisation').val();
        const adverts_dimension = $('.ed_adverts_dimension').val()
        const adverts_cover_image = $('.ed_adverts_cover_image').val()
        const hidden_adverts_cover_image = $('.hidden_adverts_cover_image').val();

        if(adverts_cover_image != "") { 
            const extension = $('.ed_adverts_cover_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('.ed_adverts_cover_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        else if(hidden_adverts_cover_image=="" && adverts_cover_image=="") {
            error_operation("Upload a cover image for the advert. This field cannot be empty.");
            return false;
        }

        if (adverts_title == '') {
            const msg = "Title of advert is required";
            error_operation(msg);
            return false;
        }
        if (adverts_type == '') {
            const msg = "Select the ad type. Field is required.";
            error_operation(msg);
            return false;
        }
        if (adverts_category == '') {
            const msg = "Category of ad is required";
            error_operation(msg);
            return false;
        }
        if (adverts_dimension == '') {
            const msg = "Dimension for this ad is required";
            error_operation(msg);
            return false;
        }
        if (adverts_organisation == '') {
            const msg = "Organisation publishing this ad is required";
            error_operation(msg);
            return false;
        }
        if (adverts_start_date == '') {
            const msg = "Ad campaign start date is required";
            error_operation(msg);
            return false;
        }
        if (adverts_end_date == '') {
            const msg = "Ad campaign end date is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'update_adv');
        UpdateAdverts(formData);
    });


    // Edit advert when edit button is clicked
    $(document).on('click', '.edit_adv', function() {
        const id = $(this).data('id');
        // pass data-id GetAdvertsDetails function
        GetAdvertsDetails(id);
    });
    //Load update content when 'activate_adv' button is clicked in table
    $(document).on('click', '.activate_adv', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to disable this advert campaign."
        }
        else if (status == 0) {
            var title = "Do you want to enable this advert campaign."
        }
        else{
            var title = "Do you want to enable this advert campaign."
        }
        // pass data-id ActivateAdverts function
        ActivateAdverts(id, status, title);
    });
    // Delete advert when delete button is clicked
    $(document).on('click', '.delete_adv', function() {
        const id = $(this).data('id');
        // pass data-id DeleteAdvert function
        DeleteAdvert(id);
    });


    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});