<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade editNewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-BS-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form edit_news_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Update News Post</h3>
                                    <h5>Last update was on: <span class="text-primary ed_news_updated_at"></span></h5>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_news_image" class="control-label"> Cover Image<span class="text-danger">*</span> </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img" width="100%" style="height:auto;"  /></p>
                                                <input name="ed_news_image" class="input-group form-control ed_news_image" type="file" accept="image/*" onchange="previewImage(event)" />

                                                <label for="ed_news_img_caption" class="control-label pt-1"> News image caption<span class="text-danger">*</span> </label> 
                                                <input class="form-control imgCaption ed_news_img_caption" type="text" maxLength="250" onchange="validateLength('imgCaption')" name="ed_news_img_caption">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_news_category" class="control-label"> News Category<span class="text-danger">*</span> </label> 
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Previously Selected</span>
                                                    </div>
                                                    <input type="text" name="ed_dis_news_category" class="form-control ed_dis_news_category" aria-label="categories" aria-describedby="basic-addon1" readonly >
                                                </div>
                                                <select name="ed_news_category[]" class="form-control form-select ed_news_category selectpicker02" multiple>
                                                    <option value="">Select one</option>
                                                    <option value="music">Music</option>
                                                    <option value="entertainment">Entertainment</option>
                                                    <option value="fashion & lifestyle">Fashion & Lifestyle</option>
                                                    <option value="sports">Sports</option>
                                                    <option value="culture">Culture</option>
                                                    <option value="3music awards">3Music Awards</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                <label for="ed_news_title" class="control-label"> News Title<span class="text-danger">*</span> </label> 
                                                <input class="form-control ed_news_title newsTitle" type="text" maxLength="250" onchange="validateLength('newsTitle')" name="ed_news_title" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-7">
                                            <div class="form-group">
                                                <label for="ed_news_by" class="control-label"> Author<span class="text-danger">*</span> </label> 
                                                <input class="form-control ed_news_by newsBy" type="text" maxLength="60" onchange="validateLength('newsBy')" name="ed_news_by" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_news_date" class="control-label"> Date<span class="text-danger">*</span> </label> 
                                                <input class="form-control ed_news_date" type="date" name="ed_news_date" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                                <div class="form-group">
                                                <label for="ed_news_featured" class="control-label"> Featured?<span class="text-danger">*</span> </label> 
                                                <select name="ed_news_featured" class="form-control form-select ed_news_featured">
                                                    <option value="">Select one</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_news_briefing" class="control-label"> News Briefing<span class="text-danger">*</span> </label> 
                                                <textarea name="ed_news_briefing" maxLength="350" onchange="validateLength('ed_news_briefing')" class="form-control ed_news_briefing" ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_news_body" class="control-label"> News Body<span class="text-danger">*</span> </label> 
                                                <textarea name="ed_news_body" rows="10" class="form-control ed_news_body ed_summernote_editor" id="ed_news_body"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4 offset-md-2 mt-2">
                                            <input type="hidden" name="hidden_hashed" class="hidden_hashed" readonly>
                                            <input type="hidden" name="hidden_news_image" class="hidden_news_image" readonly> 
                                            <button type="submit" class="btn btn-md btn-info btn-block">Update</button>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <button type="button" class="btn btn-md btn-block btn-danger" data-BS-dismiss="modal">Close</button>
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
    var ed_library_url = '../../resources/library/summernote.lib.php';
    var ed_folder_directory = 'news';
    var ed_class_name = 'ed_summernote_editor';
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
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'help', 'undo', 'redo']],
        ],
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable, ed_class_name, ed_folder_directory, ed_library_url);
            },
            onMediaDelete : function(target) { 
                deleteFile(target[0].src, ed_folder_directory, ed_library_url);
            }
        }
    });

    //Multple select field 
    jQuery(document).ready(function() {
        $('.selectpicker02').selectpicker();
    });
</script>