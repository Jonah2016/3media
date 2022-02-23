$(document).ready(function() {

    function load_data() {
        $("#videos_data").load('../../classes/videos_cl/FetchVideos.php');
        $("#add_videos_container").load('../../resources/form-modals/add-modals/add_videos.php');
        $("#edit_videos_container").load('../../resources/form-modals/edit-modals/edit_videos.php');
    }

    function GetVideoDetails(id) {
        const formData = new FormData();
        formData.append('action', 'get_video');
        formData.append('hashed_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/videos_cl/VideosController.php',
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
                    const vid = data;
                    // Assing existing values to the modal popup fields
                    $(".hidden_hashed").val(vid.vid_hashed);
                    $(".ed_vid_category").val(vid.vid_category);
                    $(".ed_vid_title").val(vid.vid_title);
                    $(".hidden_vid_thumbnail").val(vid.vid_thumbnail);
                    $(".ed_vid_img_caption").val(vid.vid_img_caption);
                    $(".ed_vid_youtube_url").val(vid.vid_youtube_url);
                    $(".ed_vid_author").val(vid.vid_author);
                    $(".ed_vid_date").val(vid.vid_date);
                    $('.ed_vid_description').summernote("code", vid.vid_description);
                    if (vid.vid_updated_at == "0000-00-00 00:00:00" || vid.vid_updated_at == null) { $(".ed_vid_updated_at").text("N/A"); } else { $(".ed_vid_updated_at").text(vid.vid_updated_at); }
                    if (vid.vid_thumbnail != "") {
                        $('.display_img').attr('src', '../../../uploads/videos_thumbnails/' + vid.vid_thumbnail);
                    } else {
                        $('.display_img').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
        // Open modal
        $(".editVideosModal").modal("show");
    }
    // Add video when saveVideo is submitted
    function SaveVideo(formData) {
        // Save the details by requesting to the server using ajax
        const vid_title = $('#vid_title').val();
        const vid_youtube_url = $('#vid_youtube_url').val();
        const vid_category = $('#vid_category').val();
        const vid_date = $('#vid_date').val();
        if (vid_category != "" || vid_title != "" || vid_date != "" || vid_youtube_url != "") {
            $.ajax({
                url: '../../classes/videos_cl/VideosController.php',
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
                        $("#add_videos_form")[0].reset()
                        $('.display_img').attr('src', '');
                        $('.summernote_editor').summernote('code', '');
                        $("#videos_data").load('../../classes/videos_cl/FetchVideos.php');
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Make sure a video category or title or date or URL field is not empty";
            error_operation(msg);
        }
    }
    // Update video when UpdateVideo is submitted
    function UpdateVideo(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/videos_cl/VideosController.php',
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
                    $(".editVideosModal").modal("hide");
                    load_data();
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Activate video when ActivateVideo is submitted
    function ActivateVideo(id, status, title) {
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
                formData.append('action', 'activate_video');
                formData.append('up_vid_id', id);
                formData.append('up_vid_active_status', status);
                // Delete video by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/videos_cl/VideosController.php',
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
    // Delete video Potrait when deleteVideo is submitted
    function DeleteVideo(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this video?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_video');
                formData.append('del_vid_id', id);
                // Delete video by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/videos_cl/VideosController.php',
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

    // save video when add_videos_form is submitted
    $(document).on('submit', '#add_videos_form', function(event) {
        event.preventDefault();
        const vid_category = $('#vid_category').val()
        const vid_title = $('#vid_title').val()
        const vid_youtube_url = $('#vid_youtube_url').val()
        const vid_description = $('#vid_description').val()
        const vid_author = $('#vid_author').val()
        const vid_date = $('#vid_date').val()
        const vid_thumbnail = $('#vid_thumbnail').val()
        const vid_img_caption = $('#vid_img_caption').val()

        if(vid_thumbnail != "") { 
            const extension = $('#vid_thumbnail').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#vid_thumbnail').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }
        if (vid_img_caption == '') {
            const msg = "You forgot the image caption. This field is required";
            error_operation(msg);
            return false;
        }

        if (vid_category == '') {
            const msg = "Category of video is required";
            error_operation(msg);
            return false;
        }
        if (vid_title == '') {
            const msg = "Title of video is required";
            error_operation(msg);
            return false;
        }
        if (vid_youtube_url == '') {
            const msg = "Youtube video url CODE is required";
            error_operation(msg);
            return false;
        }
        if (vid_description == '') {
            const msg = "Video description is required";
            error_operation(msg);
            return false;
        }
        if (vid_date == '') {
            const msg = "Video date is required";
            error_operation(msg);
            return false;
        }
        if (vid_author == '') {
            const msg = "Author of video story is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'save_video');
        SaveVideo(formData);
    });
    // update video when edit_videos_form is submitted
    $(document).on('submit', '.edit_videos_form', function(event) {
        event.preventDefault();
        const vid_category = $('.ed_vid_category').val()
        const vid_title = $('.ed_vid_title').val()
        const vid_youtube_url = $('.ed_vid_youtube_url').val()
        const vid_description = $('.ed_vid_description').val()
        const vid_author = $('.ed_vid_author').val()
        const vid_thumbnail = $('.ed_vid_thumbnail').val()
        const hidden_vid_thumbnail = $('.hidden_vid_thumbnail').val();
        const vid_img_caption = $('.ed_vid_img_caption').val()

        if(vid_thumbnail != "") { 
            const extension = $('.ed_vid_thumbnail').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('.ed_vid_thumbnail').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        }

        if (vid_img_caption == '') {
            const msg = "You forgot the image caption. This field is required";
            error_operation(msg);
            return false;
        }
        if (vid_category == '') {
            const msg = "Category of video is required";
            error_operation(msg);
            return false;
        }
        if (vid_title == '') {
            const msg = "Title of video is required";
            error_operation(msg);
            return false;
        }
        if (vid_youtube_url == '') {
            const msg = "Youtube video url CODE is required";
            error_operation(msg);
            return false;
        }
        if (vid_description == '') {
            const msg = "Video description is required";
            error_operation(msg);
            return false;
        }
        if (vid_author == '') {
            const msg = "Author of the video story is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'update_video');
        UpdateVideo(formData);
    });


    // Edit video when edit button is clicked
    $(document).on('click', '.edit_video', function() {
        const id = $(this).data('id');
        // pass data-id GetVideoDetails function
        GetVideoDetails(id);
    });
    //Load update content when 'activate_video' button is clicked in table
    $(document).on('click', '.activate_video', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            const title = "Do you want to disable this video."
        }
        else if (status == 0) {
            const title = "Do you want to enable this video."
        }
        else{
            const title = "Do you want to enable this video."
        }
        // pass data-id ActivateVideo function
        ActivateVideo(id, status, title);
    });
    // Delete video when delete button is clicked
    $(document).on('click', '.delete_video', function() {
        const id = $(this).data('id');
        // pass data-id DeleteVideo function
        DeleteVideo(id);
    });


    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});