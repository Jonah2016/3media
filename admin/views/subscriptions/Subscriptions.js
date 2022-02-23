$(document).ready(function() {

    function load_data() {
        $("#subscription_data").load('../../classes/subscriptions_cl/FetchSubscription.php');
        $("#email_draft_data").load('../../classes/subscriptions_cl/FetchEmailDrafts.php');
        $("#send_bulk_email_container").load('../../resources/form-modals/other-modals/send_bulk_email.php');
    }

    // Activate subscription when ActivateSubscription is submitted
    function ActivateSubscription(id, status, title) {
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
                var formData = new FormData();
                formData.append('action', 'activate_subscription');
                formData.append('up_subs_id', id);
                formData.append('up_subs_active_status', status);
                // Delete subscription by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/subscriptions_cl/SubscriptionController.php',
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
                            load_data();
                        } else {
                            var msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }
    // Delete subscriptions Potrait when deleteSubscription is submitted
    function DeleteSubscription(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this subscription?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('action', 'delete_subscription');
                formData.append('del_subs_id', id);
                // Delete subscription by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/subscriptions_cl/SubscriptionController.php',
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
                            load_data();
                        } else {
                            var msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }

    //Load update content when 'activate_subscription' button is clicked in table
    $(document).on('click', '.activate_subscription', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to suspend this subscription conversation."
        }
        else if (status == 0) {
            var title = "Do you want to enable this subscription conversation."
        }
        else{
            var title = "Do you want to enable this subscription conversation."
        }
        // pass data-id ActivateSubscription function
        ActivateSubscription(id, status, title);
    });
    // Delete subscription when delete button is clicked
    $(document).on('click', '.delete_subscription', function() {
        var id = $(this).data('id');
        // pass data-id DeleteSubscription function
        DeleteSubscription(id);
    });



    // Send, save email draft when send_bulk_email_form is submitted
    function emailAction(formData) {
        // Save the details by requesting to the server using ajax
        const title = $('.ed_title').val()
        const body = $('.ed_body').val()
        if (title != "" || body != "") {
            $.ajax({
                url: '../../classes/subscriptions_cl/emailController.php',
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
                        $("#send_bulk_email_form")[0].reset();
                        $('.sb_summernote_editor').summernote('code', '');
                        $("#sendEmailModal").modal("hide");
                        load_data();
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Make sure a subject or body field is not empty";
            error_operation(msg);
        }
    }
    // Activate draft when ActivateDraft is submitted
    function ActivateDraft(id, status, title) {
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
                var formData = new FormData();
                formData.append('action', 'activate_draft');
                formData.append('up_ed_id', id);
                formData.append('up_ed_active_status', status);
                // Delete subscription by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/subscriptions_cl/emailController.php',
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
                            load_data();
                        } else {
                            var msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }
    // Delete draft Potrait when deleteDraft is submitted
    function DeleteDraft(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this draft?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('action', 'delete_draft');
                formData.append('del_ed_id', id);
                // Delete subscription by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/subscriptions_cl/emailController.php',
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
                            load_data();
                        } else {
                            var msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }
    // Perform action on button clicked
    $(document).on('click', '.action_button', function(event) {
        event.preventDefault();
        var model = $(this).data('model');
        if (model == "send") {
            var action = "send_draft";
        }
        if (model == "save") {
            var action = "save_draft";
        }
        if (model == "save_send") {
            var action = "save_send_draft";
        }

        const ed_title = $('.ed_title').val()
        const ed_body = $('.ed_body').val()

        if (ed_title == '') {
            const msg = "Subject of the email is required.";
            error_operation(msg);
            return false;
        }
        if (ed_title.length < 5) {
            const msg = "Subject of the email should be more than 5 characters.";
            error_operation(msg);
            return false;
        }
        if (ed_body == '') {
            const msg = "Body of the email is required.";
            error_operation(msg);
            return false;
        }

        const formData = new FormData();
        formData.append('action', action);
        formData.append('ed_body', ed_body);
        formData.append('ed_title', ed_title);
        emailAction(formData);
    });
    //Load update content when 'activate_draft' button is clicked in table
    $(document).on('click', '.activate_draft', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to suspend this email draft."
        }
        else if (status == 0) {
            var title = "Do you want to enable this email draft."
        }
        else{
            var title = "Do you want to enable this email draft."
        }

        // pass data-id ActivateDraft function
        ActivateDraft(id, status, title);
    });
    // Delete draft when delete button is clicked
    $(document).on('click', '.delete_draft', function() {
        var id = $(this).data('id');
        // pass data-id DeleteDraft function
        DeleteDraft(id);
    });





    // Load data from classes/subscriptions/FetchSubscription.php
    load_data();

    // console.clear();
});