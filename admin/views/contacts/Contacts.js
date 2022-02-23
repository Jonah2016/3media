$(document).ready(function() {

    function load_data() {
        $("#contact_data").load('../../classes/contacts_cl/FetchContact.php')
    }

    // Activate Contact when ActivateContact is submitted
    function ActivateContact(id, status, title) {
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
                formData.append('action', 'activate_contact');
                formData.append('up_con_id', id);
                formData.append('up_con_active_status', status);
                // Delete contact by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/contacts_cl/ContactController.php',
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
    // Delete contacts Potrait when deleteContact is submitted
    function DeleteContact(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this contact?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('action', 'delete_contact');
                formData.append('del_con_id', id);
                // Delete contact by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/contacts_cl/ContactController.php',
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

    //Load update content when 'activate_contact' button is clicked in table
    $(document).on('click', '.activate_contact', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to close this contact conversation."
        }
        else if (status == 0) {
            var title = "Do you want to open this contact conversation."
        }
        else{
            var title = "Do you want to open this contact conversation."
        }
        // pass data-id ActivateContact function
        ActivateContact(id, status, title);
    });
    // Delete Contact when delete button is clicked
    $(document).on('click', '.delete_contact', function() {
        var id = $(this).data('id');
        // pass data-id DeleteContact function
        DeleteContact(id);
    });

    // Load data from classes/contacts/FetchContact.php
    load_data();

    // console.clear();
});