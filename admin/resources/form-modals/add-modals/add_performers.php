<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade" id="addPerformerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form addPerformerForm" id="add_performer_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header mb-4">
                                        <h4 class="weight-700">Add Performer Form</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="awp_image" class="control-label"> Photo<span class="text-danger">*</span> </label> 
                                                <p><img src="" class="display_img" height="140" width="100%" /></p>
                                                <input name="awp_image" id="awp_image" class="input-group form-control" type="file" accept="image/*" onchange="previewImage(event)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-10">
                                                <div class="form-group">
                                                <label for="awp_fullname" class="control-label"> Peroformer(s) name<span class="text-danger">*</span> </label> 
                                                <input class="form-control performerTitle" type="text" maxLength="500" onchange="validateLength('performerTitle')" name="awp_fullname" id="awp_fullname" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="awp_year" class="control-label"> Performing Year<span class="text-danger">*</span> </label>
                                                <select name="awp_year" class="form-control form-select" id="awp_year">
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
                                                <label for="awp_description" class="control-label"> Performer Description </label> 
                                                <textarea name="awp_description" rows="10" id="awp_description" class="form-control summernote_editor"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4 offset-md-2 mt-2">
                                            <button type="submit" class="btn btn-md btn-info btn-block">Save</button>
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
<script src="<?php echo BASE_URL; ?>assets/vendors/summernote-0.8.18/summernote-lite.min.js"></script>
<script>
    $('.summernote_editor').summernote({
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
    });
</script>