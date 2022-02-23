<?php 
    // load up system core file (config)
    require_once("../../resources/config.inc.php");
?>

<div class="card">
    <div class="card-body">
        <form method="post" id="update_award_form" autocomplete="off" novalidate enctype="multipart/form-data">
            <div class="last_update py-2 text-info"></div>
            <!-- Basic info  -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="award_cover_image" class="form-control-label">Cover image <span class="text-danger">*</span></label>
                        <p><img src="" class="display_img1" height="250" width="100%" /></p>
                        <input id="award_cover_image" class="input-group form-control form-control-sm" type="file" name="award_cover_image" accept="image/*" onchange="previewImageOne(event)">
                        <input type="hidden" name="hid_award_cover_image" id="hid_award_cover_image">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="award_photo_one" class="form-control-label">Image two</label>
                        <p><img src="" class="display_img2" height="250" width="100%" /></p>
                        <input id="award_photo_one" class="input-group form-control form-control-sm" type="file" name="award_photo_one" accept="image/*" onchange="previewImageTwo(event)">
                        <input type="hidden" name="hid_award_photo_one" id="hid_award_photo_one">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="award_photo_two" class="form-control-label">Image two</label>
                        <p><img src="" class="display_img3" height="250" width="100%" /></p>
                        <input id="award_photo_two" class="input-group form-control form-control-sm" type="file" name="award_photo_two" accept="image/*" onchange="previewImageThree(event)">
                        <input type="hidden" name="hid_award_photo_two" id="hid_award_photo_two">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="award_photo_three" class="form-control-label">Image two</label>
                        <p><img src="" class="display_img4" height="250" width="100%" /></p>
                        <input id="award_photo_three" class="input-group form-control form-control-sm" type="file" name="award_photo_three" accept="image/*" onchange="previewImageFour(event)">
                        <input type="hidden" name="hid_award_photo_three" id="hid_award_photo_three">
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="award_description" class="form-control-label"> Full Description of Award</label>
                        <textarea class="form-control summernote_editor ad_award_description" name="award_description" rows="20" id="award_description"></textarea>
                    </div>
                </div>
            </div>

            <div class="row mb-1 mt-5">
                <div class="col-md-4 offset-md-4">
                    <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="bi bi-center bi-save2 bi-center"></i> Save </button>
                </div>
            </div>  
        </form>
    </div>
</div>


<!-- summernote -->
<script src="<?php echo ASSETS_PATH; ?>/vendors/summernote-0.8.18/summernote-lite.min.js"></script>
<script>
    var abt_library_url = '<?php echo LIBRARY_PATH."/summernote.lib.php"; ?>';
    var abt_folder_directory = 'awards';
    var abt_class_name = 'ad_award_description';
    $('.ad_award_description').summernote({
        tabsize: 2,
        height: 400,
        spellCheck: true,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'italic', 'superscript', 'subscript', 'clear']],
          ['fontname', ['fontname','fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'help', 'undo', 'redo']],
        ],
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable, abt_class_name, abt_folder_directory, abt_library_url);
            },
            onMediaDelete : function(target) { 
                deleteFile(target[0].src, abt_folder_directory, abt_library_url);
            }
        }
    });
</script>