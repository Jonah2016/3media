$(document).ready(function() {

    // Add Contacts when contact_form is submitted
    function SaveContact(formData) {
        // Save the details by requesting to the server using ajax
        var con_sender = $("#con_sender").val();
        var con_sender_email = $("#con_sender_email").val();
        var con_message_title = $("#con_message_title").val();
        if (con_sender != "" || con_sender_email != "" || con_message_title != "") {
            $.ajax({
                url: 'classes/UserControllers.php',
                method: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if (data.code == "200") {
                        var msg = data.msg;
                        success_operation(msg);
                    } else {
                        var msg = data.msg;
                        error_operation(msg);
                    }
                },
            });
            document.getElementById("contact_form").reset();
            return false;
        } else {
            var msg = "Sorry! all fields are required.";
            error_operation(msg);
        }
    }
    // save Contacts when contact_form is submitted
    $(document).on("submit", ".contact_form", function(event) {
        event.preventDefault();
        var con_sender = $("#con_sender").val();
        var con_message_title = $("#con_message_title").val();
        var con_sender_email = $("#con_sender_email").val();
        var con_message_body = $("#con_message_body").val();
        
        if (con_sender == "") {
            var msg = "Your full name is required";
            error_operation(msg);
            return false;
        }
        if (con_message_title == "") {
            var msg = "The subject or title of your message is required";
            error_operation(msg);
            return false;
        }
        if (con_sender_email == "") {
            var msg = "Please enter a valid email";
            error_operation(msg);
            return false;
        }
        if (con_message_body == "") {
            var msg = "Sorry! you forgot the message body.";
            error_operation(msg);
            return false;
        }

        var formData = new FormData(this);
        formData.append("action", "save_contact");
        SaveContact(formData);
    });

    // console.clear();
});
