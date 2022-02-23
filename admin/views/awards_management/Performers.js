$(document).ready(function() {

    function load_data() {
        $("#performers_data").load('../../classes/awards_cl/FetchPerformers.php');
        $("#add_performers_container").load('../../resources/form-modals/add-modals/add_performers.php');
        $("#edit_performers_container").load('../../resources/form-modals/edit-modals/edit_performers.php');
    }

    function GetPerformerDetails(id) {
        const formData = new FormData();
        formData.append('action', 'get_performer');
        formData.append('hashed_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/PerformersController.php',
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
                    const awp = data;
                    // Assing existing values to the modal popup fields
                    $(".hidden_hashed").val(awp.awp_hashed);
                    $(".hidden_awp_image").val(awp.awp_image);
                    $(".ed_awp_fullname").val(awp.awp_fullname);
                    $(".ed_awp_year").val(awp.awp_year);
                    $('.ed_awp_description').summernote("code", awp.awp_description);
                    if (awp.awp_updated_at == "0000-00-00 00:00:00" || awp.awp_updated_at == null) { $(".ed_awp_updated_at").text("N/A"); } else { $(".ed_awp_updated_at").text(awp.awp_updated_at); }
                    if (awp.awp_image != "") {
                        $('.display_img').attr('src', '../../../uploads/awards/' + awp.awp_image);
                    } else {
                        $('.display_img').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
        // Open modal
        $(".editPerformerModal").modal("show");
    }
    // Add performer when savePerformer is submitted
    function SavePerformer(formData) {
        // Save the details by requesting to the server using ajax
        const awp_fullname = $('#awp_fullname').val();
        const awp_year = $('#awp_year').val();
        if (awp_year != "" || awp_fullname != "" ) {
            $.ajax({
                url: '../../classes/awards_cl/PerformersController.php',
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
                        $("#add_performer_form")[0].reset()
                        $('.display_img').attr('src', '');
                        $('.summernote_editor').summernote('code', '');
                        $("#addPerformerModal").modal("hide");
                        load_data();
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Make sure a performer name or year field is not empty";
            error_operation(msg);
        }
    }
    // Update performer when UpdatePerformer is submitted
    function UpdatePerformer(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/PerformersController.php',
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
                    $(".editPerformerModal").modal("hide");
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Activate performer when ActivatePerformer is submitted
    function ActivatePerformer(id, status, title) {
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
                formData.append('action', 'activate_performer');
                formData.append('up_awp_id', id);
                formData.append('up_awp_active_status', status);
                // Delete news by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/PerformersController.php',
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
    // Delete performer Potrait when deletePerformer is submitted
    function DeletePerformer(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this performer?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_performer');
                formData.append('del_awp_id', id);
                // Delete performer by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/PerformersController.php',
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

    // save performer when add_performer_form is submitted
    $(document).on('submit', '#add_performer_form', function(event) {
        event.preventDefault();
        const awp_fullname = $('#awp_fullname').val()
        const awp_year = $('#awp_year').val()
        const awp_image = $('#awp_image').val()

        if(awp_image != "") { 
            const extension = $('#awp_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#awp_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }
        if (awp_image == '') {
            const msg = "Photo is required";
            error_operation(msg);
            return false;
        }
        if (awp_fullname == '') {
            const msg = "Name of performer is required";
            error_operation(msg);
            return false;
        }
        if (awp_year == '') {
            const msg = "Performing year is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'save_performer');
        SavePerformer(formData);
    });
    // update nominee when edit_performer_form is submitted
    $(document).on('submit', '.edit_performer_form', function(event) {
        event.preventDefault();
        const awp_fullname = $('.ed_awp_fullname').val()
        const awp_image = $('.ed_awp_image').val()
        const hidden_awp_image = $('.hidden_awp_image').val();

        if(awp_image != "") { 
            const extension = $('.ed_awp_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('.ed_awp_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }
        if (awp_image == '' && hidden_awp_image=='') {
            const msg = "Photo is required";
            error_operation(msg);
            return false;
        }


        if (awp_fullname == '') {
            const msg = "Name of performer is required";
            error_operation(msg);
            return false;
        }
        if (awp_year == '') {
            const msg = "Performing year is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'update_performer');
        UpdatePerformer(formData);
    });


    // Edit nominee when edit button is clicked
    $(document).on('click', '.edit_performer', function() {
        const id = $(this).data('id');
        // pass data-id GetPerformerDetails function
        GetPerformerDetails(id);
    });
    //Load update content when 'activate_performer' button is clicked in table
    $(document).on('click', '.activate_performer', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to disable this performer."
        }
        else if (status == 0) {
            var title = "Do you want to enable this performer."
        }
        else{
            var title = "Do you want to enable this performer."
        }
        // pass data-id ActivatePerformer function
        ActivatePerformer(id, status, title);
    });
    // Delete nominee when delete button is clicked
    $(document).on('click', '.delete_performer', function() {
        const id = $(this).data('id');
        // pass data-id DeletePerformer function
        DeletePerformer(id);
    });


    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});