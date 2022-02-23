$(document).ready(function() {

    function load_data() {
        $("#nominees_data").load('../../classes/awards_cl/FetchNominees.php');
        $("#add_nominees_container").load('../../resources/form-modals/add-modals/add_nominees.php');
        $("#edit_nominees_container").load('../../resources/form-modals/edit-modals/edit_nominees.php');
    }

    function GetNomineeDetails(id) {
        const formData = new FormData();
        formData.append('action', 'get_nominee');
        formData.append('hashed_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/NomineesController.php',
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
                    const awn = data;
                    // Assing existing values to the modal popup fields
                    $(".hidden_hashed").val(awn.awn_hashed);
                    $(".ed_awn_category").val(awn.awn_category);
                    $(".hidden_awn_cover_image").val(awn.awn_cover_image);
                    $(".ed_awn_type").val(awn.awn_type); 
                    $(".ed_awn_year").val(awn.awn_year);
                    $('.ed_awn_biography').summernote("code", awn.awn_biography);
                    if (awn.awn_updated_at == "0000-00-00 00:00:00" || awn.awn_updated_at == null) { $(".ed_awn_updated_at").text("N/A"); } else { $(".ed_awn_updated_at").text(awn.awn_updated_at); }
                    if (awn.awn_cover_image != "") {
                        $('.display_img').attr('src', '../../../uploads/awards/' + awn.awn_cover_image);
                    } else {
                        $('.display_img').attr('src', '../../../uploads/templates/no_photo.png');
                    }

                    if(awn.awn_type == "single"){ $('.showSingle').show(); $('.showGroup').hide(); $(".ed_awn_fullname_one").val(awn.awn_fullname); } 
                    else if(awn.awn_type == "group"){ $('.showSingle').hide(); $('.showGroup').show(); $(".ed_awn_fullname_two").val(awn.awn_fullname);} 
                    else{  $('.showSingle').hide(); $('.showGroup').hide(); }
                }
            }
        });
        // Open modal
        $(".editNomineeModal").modal("show");
    }
    // Add nominee when saveNominee is submitted
    function SaveNominee(formData) {
        // Save the details by requesting to the server using ajax
        const awn_fullname = $('#awn_fullname').val();
        const awn_type = $('#awn_type').val();
        const awn_category = $('#awn_category').val();
        const awn_year = $('#awn_year').val();
        if (awn_category != "" || awn_fullname != "" || awn_year != "" || awn_type != "") {
            $.ajax({
                url: '../../classes/awards_cl/NomineesController.php',
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
                        $("#add_nominee_form")[0].reset()
                        $('.display_img').attr('src', '');
                        $('.summernote_editor').summernote('code', '');
                        $("#addNomineeModal").modal("hide");
                        load_data();
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Make sure a nominee category or name or type or year field is not empty";
            error_operation(msg);
        }
    }
    // Update nominee when UpdateNominee is submitted
    function UpdateNominee(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/NomineesController.php',
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
                    $(".editNomineeModal").modal("hide");
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Activate nominee when ActivateNominee is submitted
    function ActivateNominee(id, status, title) {
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
                formData.append('action', 'activate_nominee');
                formData.append('up_awn_id', id);
                formData.append('up_awn_active_status', status);
                // Delete news by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/NomineesController.php',
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
    // Activate winner when ActivateWinner is submitted
    function ActivateWinner(id, status, title) {
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
                formData.append('action', 'activate_winner');
                formData.append('up_awn_id', id);
                formData.append('up_awn_win_status', status);
                // Delete news by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/NomineesController.php',
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
    // Delete nominee Potrait when deleteNominee is submitted
    function DeleteNominee(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this nominee?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_nominee');
                formData.append('del_awn_id', id);
                // Delete nominee by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/NomineesController.php',
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

    // save nominee when add_nominee_form is submitted
    $(document).on('submit', '#add_nominee_form', function(event) {
        event.preventDefault();
        const awn_category = $('#awn_category').val()
        const awn_fullname_one = $('#awn_fullname_one').val()
        const awn_fullname_two = $('#awn_fullname_two').val()
        const awn_type = $('#awn_type').val()
        const awn_biography = $('#awn_biography').val()
        const awn_year = $('#awn_year').val()
        const awn_cover_image = $('#awn_cover_image').val()

        if(awn_cover_image != "") { 
            const extension = $('#awn_cover_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#awn_cover_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }
        if (awn_cover_image == '') {
            const msg = "Cover image is required";
            error_operation(msg);
            return false;
        }
        if (awn_type == '') {
            const msg = "Nominee type is required";
            error_operation(msg);
            return false;
        }
        if (awn_type == "single" && awn_fullname_one == "") {
            const msg = " Nominee name field is required.";
            error_operation(msg);
            return false;
        }
        else if (awn_type == "group" && awn_fullname_two == "") {
            const msg = " Nominees names field is required.";
            error_operation(msg);
            return false;
        }
        if (awn_category == '') {
            const msg = "Category of nomination is required";
            error_operation(msg);
            return false;
        } 
        if (awn_biography == '') {
            const msg = "Nominee biography is required";
            error_operation(msg);
            return false;
        }
        if (awn_year == '') {
            const msg = "Nomination year is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'save_nominee');
        SaveNominee(formData);
    });
    // update nominee when edit_nominee_form is submitted
    $(document).on('submit', '.edit_nominee_form', function(event) {
        event.preventDefault();
        const awn_category = $('.ed_awn_category').val()
        const awn_fullname_one = $('.ed_awn_fullname_one').val()
        const awn_fullname_two = $('.ed_awn_fullname_two').val()
        const awn_type = $('.ed_awn_type').val()
        const awn_biography = $('.ed_awn_biography').val()
        const awn_cover_image = $('.ed_awn_cover_image').val()
        const hidden_awn_cover_image = $('.hidden_awn_cover_image').val();

        if(awn_cover_image != "") { 
            const extension = $('.ed_awn_cover_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('.ed_awn_cover_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }
        if (awn_cover_image == '' && hidden_awn_cover_image=='') {
            const msg = "Cover image is required";
            error_operation(msg);
            return false;
        }

        if (awn_type == '') {
            const msg = "Nominee type is required";
            error_operation(msg);
            return false;
        }
        if (awn_type == "single" && awn_fullname_one == "") {
            const msg = " Nominee name field is required.";
            error_operation(msg);
            return false;
        }
        else if (awn_type == "group" && awn_fullname_two == "") {
            const msg = " Nominees names field is required.";
            error_operation(msg);
            return false;
        }
        if (awn_category == '') {
            const msg = "Category of nomination is required";
            error_operation(msg);
            return false;
        } 
        if (awn_biography == '') {
            const msg = "Nominee biography is required";
            error_operation(msg);
            return false;
        }
        if (awn_year == '') {
            const msg = "Nomination year is required";
            error_operation(msg);
        }

        const formData = new FormData(this);
        formData.append('action', 'update_nominee');
        UpdateNominee(formData);
    });


    // Edit nominee when edit button is clicked
    $(document).on('click', '.edit_nominee', function() {
        const id = $(this).data('id');
        // pass data-id GetNomineeDetails function
        GetNomineeDetails(id);
    });
    //Load update content when 'activate_nominee' button is clicked in table
    $(document).on('click', '.activate_nominee', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to disable this nomineee."
        }
        else if (status == 0) {
            var title = "Do you want to enable this nomineee."
        }
        else{
            var title = "Do you want to enable this nomineee."
        }
        // pass data-id ActivateNominee function
        ActivateNominee(id, status, title);
    });
    //Load update content when 'activate_winner' button is clicked in table
    $(document).on('click', '.activate_winner', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to reverse winner badge of this nomineee."
        }
        else if (status == 0) {
            var title = "Do you want to make this nomineee a winner."
        }
        else{
            var title = "Do you want to make this nomineee a winner."
        }
        // pass data-id ActivateWinner function
        ActivateWinner(id, status, title);
    });
    // Delete nominee when delete button is clicked
    $(document).on('click', '.delete_nominee', function() {
        const id = $(this).data('id');
        // pass data-id DeleteNominee function
        DeleteNominee(id);
    });


    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});