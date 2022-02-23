$(document).ready(function() {

    function load_data() {
        $("#photos_data").load('../../classes/photos_cl/FetchPhotos.php');
        $("#add_photos_container").load('../../resources/form-modals/add-modals/add_photos.php'); 
    }

    function GetPhotos() {
        $.get("../../classes/photos_cl/FetchPhotos.php", {}, function(data, status) {
            $("#photos_data").html(data);
        });
    }

    function DeletePhotos(id) {
        Swal.fire({
            title: 'Are you sure, you want to delete this photo(s)?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('action', 'delete_photos');
                formData.append('del_photos_id', id);
                // Delete user by requesting to the server using ajax
                $.ajax({
                    url: '../../classes/photos_cl/PhotosController.php',
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
                            GetPhotos();
                        } else {
                            var msg = data.msg
                            error_operation(msg);
                        }
                    }
                });
            }
        })
    }

    function UpdatePhotosStatus(id, status) {
        var formData = new FormData();
        formData.append('action', 'activate_photos');
        formData.append('up_photo_id', id);
        formData.append('up_photo_active_status', status);
        // Delete photos by requesting to the server using ajax
        $.ajax({
            url: '../../classes/photos_cl/PhotosController.php',
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
                    GetPhotos();
                } else {
                    var msg = data.msg
                    error_operation(msg);
                }
            }
        });
    }

    function AddPhotos(formData) {
        // verify settings image extension
        var extension = $('.photo_image').val().split('.').pop().toLowerCase();
        if (extension != '') {
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'webp']) == -1) {
                var msg = "Invalid image file type";
                error_operation(msg);
                return false;
            }
        }
        var photo_image = $('.photo_image').val();
        var photo_link = $('.photo_link').val();
        // Update the details by requesting to the server using ajax
        if (photo_image != "" || photo_link != "") {
            $.ajax({
                url: '../../classes/photos_cl/PhotosController.php',
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
                        // reset form 
                        $('form#add_photos_form')[0].reset();
                        $('div.photos').html('');
                        GetPhotos();
                    } else {
                        var msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            var msg = "Make sure an image was upload or a link was pasted";
            error_operation(msg);
        }
    }

    // Add photos details when update button is clicked
    $(document).on('submit', '#add_photos_form', function(event) {
        event.preventDefault();
        var photo_title = $('.photo_title').val(); 
        var photo_image = $('.photo_image').val();
        var photo_link = $('.photo_link').val();
        var photo_img_caption = $('.photo_img_caption').val()


        if (photo_title == "") {
            var msg = "Make sure photo title field is not empty";
            error_operation(msg);
            return false;
        }
        if (photo_image == "" && photo_link=="") {
            var msg = "Make sure an image was upload or a link was pasted";
            error_operation(msg);
            return false;
        }
        if (photo_image != "" && photo_link != "")  {
            var msg = "Sorry, you can only use one of the option [upload or add url]";
            error_operation(msg);
            return false;
        }
        if (photo_img_caption == '') {
            var msg = "You forgot the image caption. This field is required";
            error_operation(msg);
            return false;
        }
        var formData = new FormData(this);
        formData.append('action', 'save_photos');
        AddPhotos(formData);
    });
    // Delete photos when delete button is clicked
    $(document).on('click', '.delete_photos', function() {
        var id = $(this).data('id');
        DeletePhotos(id);
    });
    // Activate photos when enable/disable button is clicked
    $(document).on('click', '.activate_photos', function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        UpdatePhotosStatus(id, status);
    });


    // Call functions
    load_data();
    GetPhotos();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }
    // console.clear();
});