<?php 
    // load up system core file (config)
    require_once("../../resources/config.inc.php");
?>

<div class="card">
    <div class="card-body">
        <form method="post" id="update_settings_form" autocomplete="off" novalidate enctype="multipart/form-data">
            <div class="last_update py-2 text-info"></div>
            <!-- Basic info  -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="abt_photo_one" class="form-control-label">Cover image <span class="text-danger">*</span></label>
                        <p><img src="" class="display_img1" height="200" width="100%" /></p>
                        <input id="abt_photo_one" class="input-group form-control form-control-sm" type="file" name="abt_photo_one" accept="image/*" onchange="previewImageOne(event)">
                        <input type="hidden" name="hid_abt_photo_one" id="hid_abt_photo_one">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="abt_photo_two" class="form-control-label">Image two</label>
                        <p><img src="" class="display_img2" height="200" width="100%" /></p>
                        <input id="abt_photo_two" class="input-group form-control form-control-sm" type="file" name="abt_photo_two" accept="image/*" onchange="previewImageTwo(event)">
                        <input type="hidden" name="hid_abt_photo_two" id="hid_abt_photo_two">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="abt_photo_three" class="form-control-label">Image three</label>
                        <p><img src="" class="display_img3" height="200" width="100%" /></p>
                        <input id="abt_photo_three" class="input-group form-control form-control-sm" type="file" name="abt_photo_three" accept="image/*" onchange="previewImageThree(event)">
                        <input type="hidden" name="hid_abt_photo_three" id="hid_abt_photo_three">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="abt_organisation_name" class="form-control-label">Company name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="abt_organisation_name" id="abt_organisation_name" maxlength="250" >
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="form-group">
                        <label for="abt_brief_description" class="form-control-label">Summarized description of Company<span class="text-danger">*</span></label>
                        <textarea class="form-control" name="abt_brief_description"  rows="5" id="abt_brief_description" maxlength="350"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="abt_full_description" class="form-control-label"> Full Description of Company</label>
                        <textarea class="form-control summernote_editor" name="abt_full_description" rows="20" id="abt_full_description"></textarea>
                    </div>
                </div>
            </div>

            <div class="row mb-3 mt-5">
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
    $('.summernote_editor').summernote({
        tabsize: 2,
        height: 120,
        spellCheck: true,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'italic', 'superscript', 'subscript', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['view', ['fullscreen', 'undo', 'redo']],
        ],
    }) 
    $('.summernote_editor').summernote('fontSize', 21);
</script> 