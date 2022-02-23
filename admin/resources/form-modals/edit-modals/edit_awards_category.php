<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade editAwardCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <!-- modal-dialog -->
    <div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-BS-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form edit_award_category_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Update Award Category</h3>
                                    <h5>Last update was on: <span class="text-primary ed_awc_updated_at"></span></h5>
                                </div>

                                <div class="card-body"> 
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_awc_cover_image" class="control-label"> Cover photo<span class="text-danger">*</span> </label> 
                                                <p><img src="" class="display_img" height="230" width="100%" /></p>
                                                <input name="ed_awc_cover_image" class="input-group form-control ed_awc_cover_image" type="file" accept="image/*" onchange="previewImage(event)" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                <label for="ed_awc_title" class="control-label"> Award title<span class="text-danger">*</span> </label> 
                                                <input class="form-control awardTitle ed_awc_title" type="text" maxLength="250" onchange="validateLength('awardTitle')" name="ed_awc_title">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_awc_year" class="control-label"> Category Year<span class="text-danger">*</span> </label>
                                                <select name="ed_awc_year[]" class="form-control form-select ed_awc_year selectpicker01" data-live-search="true" multiple data-actions-box="true">
                                                    <option value="">Select...</option>
                                                    <?php 
                                                        $init_year = 2005;
                                                        $end_year = 2050;

                                                        for($year=$init_year; $year <= $end_year; $year++) {
                                                    ?>
                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_awc_description" class="control-label"> Award Description<span class="text-danger">*</span> </label> 
                                                <textarea name="ed_awc_description" rows="10" class="form-control ed_awc_description ed_summernote_editor"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4 offset-md-2 mt-2">
                                            <input type="hidden" name="hidden_hashed" class="hidden_hashed" readonly>
                                            <input type="hidden" name="hidden_awc_cover_image" class="hidden_awc_cover_image" readonly>
                                            <button type="submit" class="btn btn-md btn-info btn-block">Update</button>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <button type="button" class="btn btn-md btn-block btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- // modal-content -->
    </div>
    <!--// modal-dialog -->
</div>
<!-- // modal -->

<script>
    // instantiate selectpicker  
    $(".selectpicker01").selectpicker();
</script>

<!-- summernote -->
<script src="<?php echo ASSETS_PATH; ?>/vendors/summernote-0.8.18/summernote-lite.min.js"></script>
<script>
    var ed_awc_library_url = '../../resources/library/summernote.lib.php';
    var ed_awc_folder_directory = 'awards';
    var ed_awc_class_name = 'ed_awc_description';
    $('.ed_awc_description').summernote({
        tabsize: 2,
        height: 400,
        spellCheck: true,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'italic', 'superscript', 'subscript', 'clear']],
          ['fontname', ['fontname','fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['view', ['help', 'undo', 'redo']],
        ],
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable, ed_awc_class_name, ed_awc_folder_directory, ed_awc_library_url);
            },
            onMediaDelete : function(target) { 
                deleteFile(target[0].src, ed_awc_folder_directory, ed_awc_library_url);
            }
        }
    });
</script>