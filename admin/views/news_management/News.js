$(document).ready(function() {

    function load_data() {
        $("#news_data").load('../../classes/news_cl/FetchNews.php');
        $("#add_news_container").load('../../resources/form-modals/add-modals/add_news.php');
        $("#edit_news_container").load('../../resources/form-modals/edit-modals/edit_news.php');
    }

    function GetNewsDetails(id) {
        const formData = new FormData();
        formData.append('action', 'get_news');
        formData.append('hashed_id', id);
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/news_cl/NewsController.php',
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
                    const news = data;

                    const featured = (news.news_featured == "" || news.news_featured == null) ? "no" : news.news_featured;
                    // Assing existing values to the modal popup fields
                    $(".hidden_hashed").val(news.news_hashed);
                    $(".ed_dis_news_category").val(news.news_category);
                    $(".ed_news_title").val(news.news_title);
                    $(".hidden_news_image").val(news.news_cover_image);
                    $(".ed_news_img_caption").val(news.news_img_caption);
                    $(".ed_news_briefing").val(news.news_briefing);
                    $(".ed_news_by").val(news.news_author);
                    $(".ed_news_date").val(news.news_date);
                    $(".ed_news_featured").val(featured);
                    $('.ed_news_body').summernote("code", news.news_body);
                    if (news.news_updated_at == "0000-00-00 00:00:00" || news.news_updated_at == null) { $(".ed_news_updated_at").text("N/A"); } else { $(".ed_news_updated_at").text(news.news_updated_at); }
                    if (news.news_cover_image != "") {
                        $('.display_img').attr('src', '../../../uploads/news/' + news.news_cover_image);
                    } else {
                        $('.display_img').attr('src', '../../../uploads/templates/no_photo.png');
                    }
                }
            }
        });
        // Open modal
        $(".editNewsModal").modal("show");
    }
    // Add news when saveNews is submitted
    function SaveNews(formData) {
        // Save the details by requesting to the server using ajax
        const news_title = $('#news_title').val();
        const news_briefing = $('#news_briefing').val();
        const news_category = $('#news_category').val();
        const news_date = $('#news_date').val();
        if (news_category != "" || news_title != "" || news_date != "" || news_briefing != "") {
            $.ajax({
                url: '../../classes/news_cl/NewsController.php',
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
                        $("#add_news_form")[0].reset()
                        $('.display_img').attr('src', '');
                        $('.summernote_editor').summernote('code', '');
                        $("#addNewsModal").modal("hide");
                        load_data();
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "Make sure an news category or title or date or briefing field is not empty";
            error_operation(msg);
        }
    }
    // Update news when saveNews is submitted
    function UpdateNews(formData) {
        // Update the details by requesting to the server using ajax
        $.ajax({
            url: '../../classes/news_cl/NewsController.php',
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
                    $(".editNewsModal").modal("hide");
                    load_data();
                } else {
                    const msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }
    // Activate news when ActivateNews is submitted
    function ActivateNews(id, status, title) {
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
                formData.append('action', 'activate_news');
                formData.append('up_news_id', id);
                formData.append('up_news_active_status', status);
                // Delete news by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/news_cl/NewsController.php',
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
    // Delete news Potrait when deleteNews is submitted
    function DeleteNews(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this news?',
            text: "You won't be able to change this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete_news');
                formData.append('del_news_id', id);
                // Delete news by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/news_cl/NewsController.php',
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

    // save news when add_news_form is submitted
    $(document).on('submit', '#add_news_form', function(event) {
        event.preventDefault();
        const news_category = $('#news_category').val()
        const news_title = $('#news_title').val()
        const news_briefing = $('#news_briefing').val()
        const news_body = $('#news_body').val()
        const news_author = $('#news_author').val()
        const news_date = $('#news_date').val()
        const news_image = $('#news_image').val()
        const news_img_caption = $('#news_img_caption').val()
        const news_featured = $('#news_featured').val()

        if(news_image != "") { 
            const extension = $('#news_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('#news_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 

        if (news_img_caption == '') {
            const msg = "You forgot the image caption. This field is required";
            error_operation(msg);
            return false;
        }
        if (news_category == '') {
            const msg = "Category of news is required";
            error_operation(msg);
            return false;
        }
        if (news_title == '') {
            const msg = "Title of news is required";
            error_operation(msg);
            return false;
        }
        if (news_briefing == '') {
            const msg = "News briefing is required";
            error_operation(msg);
            return false;
        }
        if (news_featured == '') {
            const msg = "Is the news featured? This field is required.";
            error_operation(msg);
            return false;
        }
        if (news_body == '') {
            const msg = "News body is required";
            error_operation(msg);
            return false;
        }
        if (news_date == '') {
            const msg = "News date is required";
            error_operation(msg);
            return false;
        }
        if (news_author == '') {
            const msg = "Author of story is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'save_news');
        SaveNews(formData);
    });
    // update news when edit_news_form is submitted
    $(document).on('submit', '.edit_news_form', function(event) {
        event.preventDefault();
        const news_title = $('.ed_news_title').val()
        const news_briefing = $('.ed_news_briefing').val()
        const news_body = $('.ed_news_body').val()
        const news_author = $('.ed_news_author').val()
        const news_image = $('.ed_news_image').val()
        const news_img_caption = $('.ed_news_img_caption').val()
        const hidden_news_image = $('.hidden_news_image').val();
        const news_featured = $('.ed_news_featured').val()

        if(news_image != "") { 
            const extension = $('.ed_news_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp', 'jfif']) == -1) {
                    const err_msg = "Invalid image file type (valid types: jpeg, jpg, png, gif, webp)";
                    $('.ed_news_image').val('');
                    error_operation(err_msg);
                    return false;
                }
            }
        } 
        else if(hidden_news_image=="" && news_image=="") {
            error_operation("Upload a cover image for the post. This field cannot be empty.");
            return false;
        }

        if (news_img_caption == '') {
            const msg = "You forgot the image caption. This field is required";
            error_operation(msg);
            return false;
        }
        if (news_title == '') {
            const msg = "Title of news is required";
            error_operation(msg);
            return false;
        }
        if (news_briefing == '') {
            const msg = "News briefing is required";
            error_operation(msg);
            return false;
        }
        if (news_body == '') {
            const msg = "News body is required";
            error_operation(msg);
            return false;
        }
        if (news_featured == '') {
            const msg = "Is the news featured? This field is required.";
            error_operation(msg);
            return false;
        }
        if (news_author == '') {
            const msg = "Author of story is required";
            error_operation(msg);
            return false;
        }

        const formData = new FormData(this);
        formData.append('action', 'update_news');
        UpdateNews(formData);
    });


    // Edit news when delete button is clicked
    $(document).on('click', '.edit_news', function() {
        const id = $(this).data('id');
        // pass data-id GetNewsDetails function
        GetNewsDetails(id);
    });
    //Load update content when 'activate_news' button is clicked in table
    $(document).on('click', '.activate_news', function(event) {
        event.preventDefault();
        const id = $(this).data('id');
        const status = $(this).data('status');
        if (status == 1) {
            var title = "Do you want to disable this news post."
        }
        else if (status == 0) {
            var title = "Do you want to enable this news post."
        }
        else{
            var title = "Do you want to enable this news post."
        }
        // pass data-id ActivateNews function
        ActivateNews(id, status, title);
    });
    // Delete news when delete button is clicked
    $(document).on('click', '.delete_news', function() {
        const id = $(this).data('id');
        // pass data-id DeleteNews function
        DeleteNews(id);
    });


    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});