$(document).ready(function() {

    function load_data() {
        $("#events_data").load('../../classes/events_cl/FetchEvents.php');
        $("#add_events_container").load('../../resources/form-modals/add-modals/add_event.php');
        $("#edit_events_container").load('../../resources/form-modals/edit-modals/edit_event.php');
    }

    function GetEventDetails(id) {
        const formData = new FormData();
        formData.append('action', 'get_event');
        formData.append('hashed_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/events_cl/EventController.php',
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
                    const eve = data;

                    const featured = (eve.eve_featured == "" || eve.eve_featured == null) ? "no" : eve.eve_featured;
                    // Assing existing values to the modal popup fields
                    $(".hidden_hashed").val(eve.eve_hashed);
                    $(".ed_eve_name").val(eve.eve_name);
                    $(".ed_eve_category").val(eve.eve_category);
                    $(".ed_eve_location").val(eve.eve_location);
                    $(".ed_eve_map_location").val(eve.eve_map_location);
                    $(".ed_eve_venue").val(eve.eve_venue);
                    $(".ed_eve_rating").val(eve.eve_rating);
                    $(".ed_eve_organiser").val(eve.eve_organiser);
                    $(".hidden_eve_organiser_logo").val(eve.eve_organiser_logo);
                    $(".ed_eve_fb_link").val(eve.eve_fb_link);
                    $(".ed_eve_twitter_link").val(eve.eve_twitter_link);
                    $(".ed_eve_ig_link").val(eve.eve_ig_link);
                    $(".ed_eve_tags").val(eve.eve_tags);
                    $(".hidden_eve_banner").val(eve.eve_banner);
                    $(".hidden_eve_image1").val(eve.eve_image1);
                    $(".hidden_eve_image2").val(eve.eve_image2);
                    $(".ed_eve_yt_video_link").val(eve.eve_yt_video_link);
                    $(".ed_eve_start_date").val(eve.eve_start_date);
                    $(".ed_eve_end_date").val(eve.eve_end_date);
                    $(".ed_eve_start_time").val(eve.eve_start_time);
                    $(".ed_eve_end_time").val(eve.eve_end_time);
                    $(".ed_eve_enable_ticket_sales").val(eve.eve_enable_ticket_sales);
                    $(".hidden_ticket_hashed").val(eve.eve_ticket_hashed);
                    $(".hidden_eve_ticket_image").val(eve.eve_ticket_image);

                    $(".ed_eve_ticket_name1").val(eve.eve_ticket_name1);
                    $(".ed_eve_ticket_desc1").val(eve.eve_ticket_desc1);
                    $(".ed_eve_ticket_price1").val(eve.eve_ticket_price1);
                    $(".ed_eve_ticket_quantity1").val(eve.eve_ticket_quantity1);
                    $(".ed_eve_ticket_name2").val(eve.eve_ticket_name2);
                    $(".ed_eve_ticket_desc2").val(eve.eve_ticket_desc2);
                    $(".ed_eve_ticket_price2").val(eve.eve_ticket_price2);
                    $(".ed_eve_ticket_quantity2").val(eve.eve_ticket_quantity2);
                    $(".ed_eve_ticket_name3").val(eve.eve_ticket_name3);
                    $(".ed_eve_ticket_desc3").val(eve.eve_ticket_desc3);
                    $(".ed_eve_ticket_price3").val(eve.eve_ticket_price3);
                    $(".ed_eve_ticket_quantity3").val(eve.eve_ticket_quantity3);
                    $(".ed_eve_ticket_name4").val(eve.eve_ticket_name4);
                    $(".ed_eve_ticket_desc4").val(eve.eve_ticket_desc4);
                    $(".ed_eve_ticket_price4").val(eve.eve_ticket_price4);
                    $(".ed_eve_ticket_quantity4").val(eve.eve_ticket_quantity4);

                    $(".ed_eve_start_sales_on").val(eve.eve_start_sales_on);
                    $(".ed_eve_ends_sales_on").val(eve.eve_ends_sales_on);
                    $(".ed_eve_show_attendees").val(eve.eve_show_attendees);
                    $(".ed_eve_enable_reviews").val(eve.eve_enable_reviews);
                    $(".ed_eve_audience").val(eve.eve_audience);
                    $(".ed_dis_eve_audience").val(eve.eve_audience);

                    $('.ed_eve_description').summernote("code", eve.eve_description);
                    if (eve.eve_updated_at == "0000-00-00 00:00:00" || eve.eve_updated_at == null) { $(".ed_eve_updated_at").text("N/A"); } else { $(".ed_eve_updated_at").text(eve.eve_updated_at); }

                    (eve.eve_banner != "") ? $('.display_img').attr('src', '../../../uploads/events/' + eve.eve_banner) : $('.display_img').attr('src', '../../../uploads/templates/no_photo.png'); 
                    (eve.eve_image1 != "") ? $('.display_img1').attr('src', '../../../uploads/events/' + eve.eve_image1) : $('.display_img1').attr('src', '../../../uploads/templates/no_photo.png'); 
                    (eve.eve_image2 != "") ? $('.display_img2').attr('src', '../../../uploads/events/' + eve.eve_image2) : $('.display_img2').attr('src', '../../../uploads/templates/no_photo.png'); 
                    (eve.eve_organiser_logo != "") ? $('.display_img3').attr('src', '../../../uploads/events/' + eve.eve_organiser_logo) : $('.display_img3').attr('src', '../../../uploads/templates/no_photo.png');
                    (eve.eve_ticket_image != "") ? $('.display_img4').attr('src', '../../../uploads/tickets/' + eve.eve_ticket_image) : $('.display_img4').attr('src', '../../../uploads/templates/no_photo.png');

                    if(eve.eve_enable_ticket_sales == 1){ $('.enableTicketYes').show(); } 
                    else if(eve.eve_enable_ticket_sales == 0){ $('.enableTicketYes').hide(); } 
                    else{  $('.enableTicketYes').hide(); }
                }
            }
        });
        // Open modal
        $(".editEventModal").modal("show");
    }
    // Add event when SaveEvent is submitted
    function SaveEvent(formData) {
        // Save the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/events_cl/EventController.php',
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
                    $("#add_event_form")[0].reset()
                    $('.display_img').attr('src', '');
                    $('.display_img1').attr('src', '');
                    $('.display_img2').attr('src', '');
                    $('.display_img3').attr('src', '');
                    $('.display_img4').attr('src', '');
                    $('.summernote_editor').summernote('code', '');
                    $("#addEventModal").modal("hide");
                    load_data();
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
        return false;
    }
    // Update event when UpdateEvent is submitted
    function UpdateEvent(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/events_cl/EventController.php',
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
                    $('.display_img1').attr('src', '');
                    $('.display_img2').attr('src', '');
                    $('.display_img3').attr('src', '');
                    $('.display_img4').attr('src', '');
                    $('.ed_summernote_editor').summernote('code', '');
                    $(".editEventModal").modal("hide");
                    load_data();
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Activate event when ActivateEvent is submitted
    function ActivateEvent(id, status, title) {
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
                formData.append('action', 'activate_event');
                formData.append('up_eve_id', id);
                formData.append('up_eve_active_status', status);
                // Delete event by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/events_cl/EventController.php',
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
    // Delete event Potrait when DeleteEvent is submitted
    function DeleteEvent(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this event?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_event');
                formData.append('del_eve_id', id);
                // Delete event by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/events_cl/EventController.php',
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

    // save event when add_event_form is submitted
    $(document).on('submit', '#add_event_form', function(event) {
        event.preventDefault();
        const eve_name                = $('#eve_name').val();
        const eve_category            = $('#eve_category').val();
        const eve_location            = $('#eve_location').val();
        const eve_venue               = $('#eve_venue').val();
        const eve_organiser           = $('#eve_organiser').val();
        const eve_banner              = $('#eve_banner').val();
        const eve_start_date          = $('#eve_start_date').val();
        const eve_end_date            = $('#eve_end_date').val();
        const eve_start_time          = $('#eve_start_time').val();
        const eve_end_time            = $('#eve_end_time').val();
        const eve_enable_ticket_sales = $('#eve_enable_ticket_sales').val();
        const eve_show_attendees      = $('#eve_show_attendees').val();
        const eve_enable_reviews      = $('#eve_enable_reviews').val();
        const eve_audience            = $('#eve_audience').val();

        if (eve_banner == '') {
            const msg = "Upload an event banner/image. This field is required";
            error_operation(msg);
            return false;
        }
        if(eve_banner != "") { 
            const extension = $('#eve_banner').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#eve_banner').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        if (eve_category == '') {
            const msg = "Event category field is required";
            error_operation(msg);
            return false;
        }
        if (eve_location == '') {
            const msg = "Location of event is required";
            error_operation(msg);
            return false;
        }
        if (eve_venue == '') {
            const msg = "Venue of event is required";
            error_operation(msg);
            return false;
        }
        if (eve_organiser == '') {
            const msg = "Event organiser name is required";
            error_operation(msg);
            return false;
        }
        if (eve_start_date == '') {
            const msg = "Event start date is required";
            error_operation(msg);
            return false;
        }
        if (eve_end_date == '') {
            const msg = "Event end date is required";
            error_operation(msg);
            return false;
        }
        if (eve_start_time == '') {
            const msg = "Event start time is required";
            error_operation(msg);
            return false;
        }
        if (eve_end_time == '') {
            const msg = "Event end time is required";
            error_operation(msg);
            return false;
        }
        if (eve_show_attendees == '') {
            const msg = "Indicate if you want to show attendees? This field is required";
            error_operation(msg);
            return false;
        }
        if (eve_enable_reviews == '') {
            const msg = "Indicate if you want to enable event reviews. This field is required";
            error_operation(msg);
            return false;
        }
        if (eve_audience == '') {
            const msg = "Event audience field is required. Who are your target group?";
            error_operation(msg);
            return false;
        }

        if (eve_enable_ticket_sales == 1) {
            const eve_ticket_name1     = $('#eve_ticket_name1').val();
            const eve_ticket_price1    = $('#eve_ticket_price1').val();
            const eve_ticket_quantity1 = $('#eve_ticket_quantity1').val();
            const eve_start_sales_on   = $('#eve_start_sales_on').val();
            const eve_ends_sales_on    = $('#eve_ends_sales_on').val();

            const eve_ticket_name2     = $('#eve_ticket_name2').val();
            const eve_ticket_name3     = $('#eve_ticket_name3').val();
            const eve_ticket_name4     = $('#eve_ticket_name4').val();

            if (eve_ticket_name1 == '') {
                const msg = "Ticket name is required, since you enable ticket sales";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_price1 == '') {
                const msg = "Ticket pricing is required";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_quantity1 == '') {
                const msg = "Ticket quantity available for sale is required";
                error_operation(msg);
                return false;
            }
            if (eve_start_sales_on == '') {
                const msg = "Ticket sales starts date field is required";
                error_operation(msg);
                return false;
            }
            if (eve_ends_sales_on == '') {
                const msg = "Ticket sales ends date field is required";
                error_operation(msg);
                return false;
            }

            
            if (eve_ticket_name1 == eve_ticket_name2 || eve_ticket_name1 == eve_ticket_name3 || eve_ticket_name1 == eve_ticket_name4) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_name2 == eve_ticket_name1 || eve_ticket_name2 == eve_ticket_name3 || eve_ticket_name2 == eve_ticket_name4) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_name3 == eve_ticket_name1 || eve_ticket_name3 == eve_ticket_name2 || eve_ticket_name3 == eve_ticket_name4) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_name4 == eve_ticket_name1 || eve_ticket_name4 == eve_ticket_name2 || eve_ticket_name4 == eve_ticket_name3) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
        }

        const formData = new FormData(this);
        formData.append('action', 'save_event');
        SaveEvent(formData);
    });
    // update event when edit_event_form is submitted
    $(document).on('submit', '.edit_event_form', function(event) {
        event.preventDefault();
        const eve_name = $('.ed_eve_name').val();
        const eve_category = $('.ed_eve_category').val();
        const eve_location = $('.ed_eve_location').val();
        const eve_venue = $('.ed_eve_venue').val();
        const eve_organiser = $('.ed_eve_organiser').val();
        const eve_banner = $('.ed_eve_banner').val();
        const hidden_eve_banner = $('.hidden_eve_banner').val();
        const eve_start_date = $('.ed_eve_start_date').val();
        const eve_end_date = $('.ed_eve_end_date').val();
        const eve_start_time = $('.ed_eve_start_time').val();
        const eve_end_time = $('.ed_eve_end_time').val();

        const eve_enable_ticket_sales = $('.ed_eve_enable_ticket_sales').val();
        
        const eve_show_attendees = $('.ed_eve_show_attendees').val();
        const eve_enable_reviews = $('.ed_eve_enable_reviews').val();
        const eve_audience = $('.ed_eve_audience').val();

        if(eve_banner != "") { 
            const extension = $('.ed_eve_banner').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('.ed_eve_banner').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        else if(hidden_eve_banner=="" && eve_banner=="") {
            error_operation("Upload an event banner/image. An image is require.");
            return false;
        }

        if (eve_category == '') {
            const msg = "Event category field is required";
            error_operation(msg);
            return false;
        }
        if (eve_location == '') {
            const msg = "Location of event is required";
            error_operation(msg);
            return false;
        }
        if (eve_venue == '') {
            const msg = "Venue of event is required";
            error_operation(msg);
            return false;
        }
        if (eve_organiser == '') {
            const msg = "Event organiser name is required";
            error_operation(msg);
            return false;
        }
        if (eve_start_date == '') {
            const msg = "Event start date is required";
            error_operation(msg);
            return false;
        }
        if (eve_end_date == '') {
            const msg = "Event end date is required";
            error_operation(msg);
            return false;
        }
        if (eve_start_time == '') {
            const msg = "Event start time is required";
            error_operation(msg);
            return false;
        }
        if (eve_end_time == '') {
            const msg = "Event end time is required";
            error_operation(msg);
            return false;
        }
        if (eve_show_attendees == '') {
            const msg = "Indicate if you want to show attendees? This field is required";
            error_operation(msg);
            return false;
        }
        if (eve_enable_reviews == '') {
            const msg = "Indicate if you want to enable event reviews. This field is required";
            error_operation(msg);
            return false;
        }
        if (eve_audience == '') {
            const msg = "Event audience field is required. Who are your target group?";
            error_operation(msg);
            return false;
        }

        if (eve_enable_ticket_sales == 1) {
            const eve_ticket_name1     = $('.ed_eve_ticket_name1').val();
            const eve_ticket_price1    = $('.ed_eve_ticket_price1').val();
            const eve_ticket_quantity1 = $('.ed_eve_ticket_quantity1').val();
            const eve_start_sales_on   = $('.ed_eve_start_sales_on').val();
            const eve_ends_sales_on    = $('.ed_eve_ends_sales_on').val();

            const eve_ticket_name2     = $('.ed_eve_ticket_name2').val();
            const eve_ticket_name3     = $('.ed_eve_ticket_name3').val();
            const eve_ticket_name4     = $('.ed_eve_ticket_name4').val();

            if (eve_ticket_name1 == '') {
                const msg = "Ticket name is required, since you enable ticket sales";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_price1 == '') {
                const msg = "Ticket pricing is required";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_quantity1 == '') {
                const msg = "Ticket quantity available for sale is required";
                error_operation(msg);
                return false;
            }
            if (eve_start_sales_on == '') {
                const msg = "Ticket sales starts date field is required";
                error_operation(msg);
                return false;
            }
            if (eve_ends_sales_on == '') {
                const msg = "Ticket sales ends date field is required";
                error_operation(msg);
                return false;
            }

            if (eve_ticket_name1 == eve_ticket_name2 || eve_ticket_name1 == eve_ticket_name3 || eve_ticket_name1 == eve_ticket_name4) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_name2 == eve_ticket_name1 || eve_ticket_name2 == eve_ticket_name3 || eve_ticket_name2 == eve_ticket_name4) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_name3 == eve_ticket_name1 || eve_ticket_name3 == eve_ticket_name2 || eve_ticket_name3 == eve_ticket_name4) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
            if (eve_ticket_name4 == eve_ticket_name1 || eve_ticket_name4 == eve_ticket_name2 || eve_ticket_name4 == eve_ticket_name3) {
                const msg = "Duplicate ticket name detected. Please rectify";
                error_operation(msg);
                return false;
            }
        }

        const formData = new FormData(this);
        formData.append('action', 'update_event');
        UpdateEvent(formData);
    });


    // Edit event when delete button is clicked
    $(document).on('click', '.edit_event', function() {
        const id = $(this).data('id');
        // pass data-id GetEventDetails function
        GetEventDetails(id);
    });
    //Load update content when 'activate_event' button is clicked in table
    $(document).on('click', '.activate_event', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to disable this event."
        }
        else if (status == 0) {
            var title = "Do you want to enable this event."
        }
        else{
            var title = "Do you want to enable this event."
        }
        // pass data-id ActivateEvent function
        ActivateEvent(id, status, title);
    });
    // Delete event when delete button is clicked
    $(document).on('click', '.delete_event', function() {
        const id = $(this).data('id');
        // pass data-id DeleteEvent function
        DeleteEvent(id);
    });


    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});