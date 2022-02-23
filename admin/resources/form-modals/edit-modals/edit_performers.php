<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade editPerformerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-BS-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form edit_performer_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Update Performer</h3>
                                    <h5>Last update was on: <span class="text-primary ed_awp_updated_at"></span></h5>
                                </div>

                                <div class="card-body"> 
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_awp_image" class="control-label"> Photo<span class="text-danger">*</span> </label> 
                                                <p><img src="" class="display_img" height="120" width="100%" /></p>
                                                <input name="ed_awp_image" class="input-group form-control ed_awp_image" type="file" accept="image/*" onchange="previewImage(event)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-10 showSingle">
                                                <div class="form-group">
                                                <label for="ed_awp_fullname" class="control-label"> Nominee name<span class="text-danger">*</span> </label> 
                                                <input class="form-control performersTitle ed_awp_fullname" type="text" maxLength="150" onchange="validateLength('performersTitle')" name="ed_awp_fullname" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="ed_awp_year" class="control-label"> Performing Year<span class="text-danger">*</span> </label> 
                                                <select name="ed_awp_year" class="form-control form-select ed_awp_year">
                                                    <option value="">Select one</option>
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
                                                <label for="ed_awp_description" class="control-label"> Performer Description </label> 
                                                <textarea name="ed_awp_description" rows="10" class="form-control ed_awp_description ed_summernote_editor"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4 offset-md-2 mt-2">
                                            <input type="hidden" name="hidden_hashed" class="hidden_hashed" readonly>
                                            <input type="hidden" name="hidden_awp_image" class="hidden_awp_image" readonly>
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

<!-- summernote -->
<script src="<?php echo ASSETS_PATH; ?>/vendors/summernote-0.8.18/summernote-lite.min.js"></script>
<script>
    var ed_per_library_url = '../../resources/library/summernote.lib.php';
    var ed_per_folder_directory = 'awards';
    var ed_per_class_name = 'ed_summernote_editor';
    $('.ed_summernote_editor').summernote({
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
                sendFile(files[0], editor, welEditable, ed_per_class_name, ed_per_folder_directory, ed_per_library_url);
            },
            onMediaDelete : function(target) { 
                deleteFile(target[0].src, ed_per_folder_directory, ed_per_library_url);
            }
        }
    });
</script>