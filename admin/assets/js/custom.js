// Preview image after upload
function previewImage(event) {
    var id = $(this);
    var reader = new FileReader();
    reader.onload = function() {
        $('.display_img').attr('src', reader.result);
    }
    reader.readAsDataURL(event.target.files[0]);
}
// Preview image after upload
function previewImageOne(event) {
    var id = $(this);
    var reader = new FileReader();
    reader.onload = function() {
        $('.display_img1').attr('src', reader.result);
    }
    reader.readAsDataURL(event.target.files[0]);
}
// Preview image after upload
function previewImageTwo(event) {
    var id = $(this);
    var reader = new FileReader();
    reader.onload = function() {
        $('.display_img2').attr('src', reader.result);
    }
    reader.readAsDataURL(event.target.files[0]);
}
// Preview image after upload
function previewImageThree(event) {
    var id = $(this);
    var reader = new FileReader();
    reader.onload = function() {
        $('.display_img3').attr('src', reader.result);
    }
    reader.readAsDataURL(event.target.files[0]);
}
// Preview image after upload
function previewImageFour(event) {
    var id = $(this);
    var reader = new FileReader();
    reader.onload = function() {
        $('.display_img4').attr('src', reader.result);
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Preview multiple images after upload
function previewMultipleImage(input, placeToInsertImagePreview) {
    var filesAmount = input.files.length;
    if (input.files.length > 0) {
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event) {
                $($.parseHTML('<img width="80px" class="p-1" >')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
            }

            reader.readAsDataURL(input.files[i]);
        }
    } else {
        $('div.gallery').html('No image selected');
    }
}



// Auto hide other fields when parameters match
function autoHideFields(className, ctrlValue, toggleClass) {
    var mainValue = $('.' + className).val();
    //get the selected option from select box
    (mainValue == ctrlValue) ? $('.' + toggleClass).show(): $('.' + toggleClass).hide()
}

// tool-tips [data-toggle="tooltip" title="Edit"]
function tool_tip() {
    $('[data-toggle="tooltip"]').tooltip({ delay: { show: 200, hide: 100 }, placement: 'auto' });
}

// Sweet alert success functions 
function success_operation(msg) {
    // Success alert auto close
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: 'success',
        title: '<span style="color:#f5f5f5">' + msg + '</span>',
        background: 'rgb(51, 153, 102, 0.97)',
    });
}
// Sweet alert error functions
function error_operation(msg) {
    // Error alert auto close
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: 'error',
        title: '<span style="color:#f5f5f5">' + msg + '</span>',
        background: 'rgba(187, 57, 57, 0.89)',
    });
}


// Summernotes Reusables 
function sendFile(file, editor, welEditable, field_class_name, upload_dir, lib_url) {
    data = new FormData();
    data.append("file", file);
    data.append("action", 'upload_file');
    data.append("upload_directory", upload_dir);
    $.ajax({
        data: data,
        type: "POST",
        url: lib_url,
        cache: false,
        processData: false,
        contentType: false,
        success: function(url) {
            var image = $('<img>').attr('src', url);
            $('.'+field_class_name).summernote("insertNode", image[0]);
        }
    });
}
function deleteFile(src, delete_dir, lib_url) {
    data = new FormData();
    data.append("img_src", src);
    data.append("action", 'remove_file');
    data.append("delete_directory", delete_dir);
    $.ajax({
        data: data,
        type: "POST",
        url: lib_url,
        cache: false,
        processData: false,
        contentType: false,
        success: function(resp) {
            console.log(resp);
        }
    });
}