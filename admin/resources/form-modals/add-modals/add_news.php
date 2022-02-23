<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form addNewsForm" id="add_news_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header mb-4">
                                        <h4 class="weight-700">News Post Form</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="news_image" class="control-label"> Cover Image<span class="text-danger">*</span> </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img" width="100%" style="height:auto;"  /></p>
                                                <input name="news_image" id="news_image" class="input-group form-control" type="file" accept="image/*" onchange="previewImage(event)" />

                                                <label for="news_img_caption" class="control-label pt-1"> News image caption<span class="text-danger">*</span> </label> 
                                                <input class="form-control imgCaption" type="text" maxLength="250" onchange="validateLength('imgCaption')" name="news_img_caption" id="news_img_caption">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-12">
                                                <div class="form-group">
                                                <label for="news_category" class="control-label"> News Category<span class="text-danger">*</span> </label> 
                                                <select name="news_category[]" class="form-control form-select selectpicker01" id="news_category" multiple>
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
                                                <label for="news_title" class="control-label"> News Title<span class="text-danger">*</span> </label> 
                                                <input class="form-control newsTitle" type="text" maxLength="350" onchange="validateLength('newsTitle')" name="news_title" id="news_title">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-7">
                                            <div class="form-group">
                                                <label for="news_by" class="control-label"> Author<span class="text-danger">*</span> </label> 
                                                <input class="form-control newsBy" type="text" maxLength="80" onchange="validateLength('newsBy')" name="news_by" id="news_by">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="news_date" class="control-label"> Date<span class="text-danger">*</span> </label> 
                                                <input class="form-control" type="date" name="news_date" id="news_date">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                                <div class="form-group">
                                                <label for="news_featured" class="control-label"> Featured?<span class="text-danger">*</span> </label> 
                                                <select name="news_featured" class="form-control form-select" id="news_featured">
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
                                                <label for="news_briefing" class="control-label"> News Briefing<span class="text-danger">*</span> </label> 
                                                <textarea name="news_briefing" maxLength="350" onchange="validateLength('news_briefing')" class="form-control news_briefing" ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="news_body" class="control-label"> News Body<span class="text-danger">*</span> </label> 
                                                <textarea name="news_body" rows="10" id="news_body" class="form-control summernote_editor"></textarea>
                                            </div>
                                        </div>
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
<script src="<?php echo ASSETS_PATH; ?>/vendors/summernote-0.8.18/summernote-lite.min.js"></script>
<script>
    var ad_library_url = '../../resources/library/summernote.lib.php';
    var ad_folder_directory = 'news';
    var ad_class_name = 'summernote_editor';
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
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'help', 'undo', 'redo']],
        ],
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable, ad_class_name, ad_folder_directory, ad_library_url);
            },
            onMediaDelete : function(target) { 
                deleteFile(target[0].src, ad_folder_directory, ad_library_url);
            }
        }
    });

    //Multple select field 
    jQuery(document).ready(function() {
        $('.selectpicker01').selectpicker();
    });
</script>