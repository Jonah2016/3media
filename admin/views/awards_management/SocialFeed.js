$(document).ready(function() {

    function load_data() {
        $("#social_feed_data").load('../../classes/awards_cl/FetchSocialFeed.php');
        $("#add_social_feed_container").load('../../resources/form-modals/add-modals/add_social_feed.php');
        $("#edit_social_feed_container").load('../../resources/form-modals/edit-modals/edit_social_feed.php');
    }

    function GetSocialFeedback(id) {
        const formData = new FormData();
        formData.append('action', 'get_social_feedback');
        formData.append('awsoc_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/SocialFeedController.php',
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
                    $(".hidden_id").val(awc.awsoc_id);
                    $(".ed_awsoc_type").val(awc.awsoc_type);
                    $(".ed_awsoc_url").val(awc.awsoc_url);
                    if (awc.awsoc_updated_at == "0000-00-00 00:00:00" || awc.awsoc_updated_at == null) { $(".ed_awsoc_updated_at").text("N/A"); } else { $(".ed_awsoc_updated_at").text(awc.awsoc_updated_at); }
                }
            }
        });
        // Open modal
        $(".editSocialFeedbackModal").modal("show");
    }
    // Add social feedback when saveSocialFeedback is submitted
    function saveSocialFeedback(formData) {
        // Save the details by requesting to the server using ajax
        const awsoc_url = $('#awsoc_url').val();
        const awsoc_type = $('#awsoc_type').val();
        if (awsoc_type != "" || awsoc_url != "" ) {
            $.ajax({
                url: '../../classes/awards_cl/SocialFeedController.php',
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
                        $("#add_social_feedback_form")[0].reset()
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Make sure a url or social media type field is not empty";
            error_operation(msg);
        }
    }
    // Update social feedback when UpdateSocialFeedback is submitted
    function UpdateSocialFeedback(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/awards_cl/SocialFeedController.php',
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
                    $("#social_feed_data").load('../../classes/awards_cl/FetchSocialFeed.php')
                    $(".editSocialFeedbackModal").modal("hide");
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Delete social feedback Potrait when deleteSocialFeedback is submitted
    function DeleteSocialFeedback(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this social feedback?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_social_feedback');
                formData.append('del_awsoc_id', id);
                // Delete video by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/awards_cl/SocialFeedController.php',
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

    // save social feedback when add_social_feedback_form is submitted
    $(document).on('submit', '#add_social_feedback_form', function(event) {
        event.preventDefault();
        const awsoc_url = $('#awsoc_url').val()
        const awsoc_type = $('#awsoc_type').val()

        if (awsoc_url == '') {
            const msg = "Title of social feedback is required";
            error_operation(msg);
            return false;
        }
        if (awsoc_type == '') {
            const msg = "social feedback description is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'save_social_feedback');
        saveSocialFeedback(formData);
    });
    // update social feedback when edit_social_feedback_form is submitted
    $(document).on('submit', '.edit_social_feedback_form', function(event) {
        event.preventDefault();
        const awsoc_url = $('.ed_awsoc_url').val()
        const awsoc_type = $('.ed_awsoc_type').val()

        if (awsoc_url == '') {
            const msg = "Title of social feedback is required";
            error_operation(msg);
            return false;
        }
        if (awsoc_type == '') {
            const msg = "social feedback description is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'update_social_feedback');
        UpdateSocialFeedback(formData);
    });

    // Edit social feedback when edit button is clicked
    $(document).on('click', '.edit_social_feedback', function() {
        const id = $(this).data('id');
        // pass data-id GetSocialFeedback function
        GetSocialFeedback(id);
    });
    // Delete social feedback when delete button is clicked
    $(document).on('click', '.delete_social_feedback', function() {
        const id = $(this).data('id');
        // pass data-id DeleteSocialFeedback function
        DeleteSocialFeedback(id);
    });



    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});