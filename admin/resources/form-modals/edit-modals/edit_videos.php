<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade editVideosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-BS-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form edit_videos_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Update Videos</h3>
                                    <h5>Last update was on: <span class="text-primary ed_vid_updated_at"></span></h5>
                                </div>

                                <div class="card-body"> 
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_vid_thumbnail" class="control-label"> Video thumbnail<span class="text-danger">*</span> </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img" width="100%" style="height:auto;"  /></p>
                                                <input name="ed_vid_thumbnail" class="input-group form-control ed_vid_thumbnail" type="file" accept="image/*" onchange="previewImage(event)" />

                                                <label for="ed_vid_img_caption" class="control-label pt-1"> Video thumbnail caption<span class="text-danger">*</span> </label> 
                                                <input class="form-control imgCaption ed_vid_img_caption" type="text" maxLength="250" onchange="validateLength('imgCaption')" name="ed_vid_img_caption">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                <label for="ed_vid_title" class="control-label"> Video title<span class="text-danger">*</span> </label> 
                                                <input class="form-control videosTitle ed_vid_title" type="text" maxLength="250" onchange="validateLength('videosTitle')" name="ed_vid_title">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_vid_category" class="control-label"> Video category<span class="text-danger">*</span> </label> 
                                                <select name="ed_vid_category" class="form-control form-select ed_vid_category">
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
                                        <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                <label for="ed_vid_author" class="control-label"> Video author<span class="text-danger">*</span> </label> 
                                                <input class="form-control videosAuthor ed_vid_author" type="text" maxLength="350" onchange="validateLength('videosAuthor')" name="ed_vid_author">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_vid_description" class="control-label"> Video Description<span class="text-danger">*</span> </label> 
                                                <textarea name="ed_vid_description" rows="10" class="form-control ed_vid_description ed_summernote_editor"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ed_vid_youtube_url" class="control-label"> Youtube video url CODE <span class="text-danger"><small>(usually is the alpanumeric code at the end of the URL)</small>*</span> </label> 
                                                <input class="form-control videoUrl ed_vid_youtube_url" type="text" maxLength="25" onchange="validateLength('videoUrl')" name="ed_vid_youtube_url" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_vid_date" class="control-label"> Video Date<span class="text-danger">*</span> </label> 
                                                <input class="form-control ed_vid_date" type="date" name="ed_vid_date">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4 offset-md-2 mt-2">
                                            <input type="hidden" name="hidden_hashed" class="hidden_hashed" readonly>
                                            <input type="hidden" name="hidden_vid_thumbnail" class="hidden_vid_thumbnail" readonly>
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
    var ed_vid_library_url = '../../resources/library/summernote.lib.php';
    var ed_vid_folder_directory = 'videos_thumbnails';
    var ed_vid_class_name = 'ed_summernote_editor';
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
                sendFile(files[0], editor, welEditable, ed_vid_class_name, ed_vid_folder_directory, ed_vid_library_url);
            },
            onMediaDelete : function(target) { 
                deleteFile(target[0].src, ed_vid_folder_directory, ed_vid_library_url);
            }
        }
    });
</script>