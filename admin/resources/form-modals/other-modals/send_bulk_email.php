<?php require_once("../../../resources/auth.inc.php"); ?>
<!-- Modal -->
<div class="modal modal-blur fade noselect" id="sendEmailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-body mx-3 text-left">
                <form class="form" id="send_bulk_email_form" method="post" novalidate enctype="multipart/form-data">
                    <div class="card-header mb-4">
                        <h4 class="weight-700">Send Bulk Email</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-12 mb-2">
                                    <div class="form-group ">
                                        <label for="select_email_draft" class="control-label">Search By Draft</label> 
                                        <?php   
                                            // search years  
                                            $in_sql01 = $db_connect->prepare("SELECT ed_title, ed_body FROM email_drafts WHERE ed_active_status!=3 ORDER BY ed_id DESC"); 
                                            $in_sql01->execute();
                                        ?>
                                        <select name="select_email_draft" data-live-search="true" class="selectpicker02 form-control form-select" id="select_email_draft" data-placeholder="Select draft" >
                                            <option data-subject="" data-body="" value=""> Select draft</option>
                                            <?php
                                                $i=0;
                                                while($in_row01=$in_sql01->fetch(PDO::FETCH_ASSOC)) 
                                                {
                                                    extract($in_row01); 
                                                    $ed_title = $in_row01['ed_title'];
                                                    $ed_body = $in_row01['ed_body'];   
                                            ?>
                                            <option data-subject="<?=$ed_title; ?>" data-body="<?=$ed_body; ?>" value="<?=$ed_title;?>" ><?=$ed_title; ?></option>
                                            <?php
                                                    $i++;
                                                }
                                            ?>
                                        </select>
                                    </div> 

                                    <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                            <label for="ed_title" class="control-label"> Subject <span class="text-danger">*</span> </label> 
                                            <input class="form-control ed_title" type="text" maxLength="350" name="ed_title">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="ed_body" class="control-label"> Body<span class="text-danger">*</span> </label> 
                                        <textarea name="ed_body" rows="10" class="form-control ed_body sb_summernote_editor"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <div class="col-md-3">
                                    <button type="button" data-model="send" class="btn btn-lg btn-success btn-block action_button"><i class="bi bi-save2 bi-center"></i> Send</button>
                                </div>
                                <div class="col-md-3 ">
                                    <button type="button" data-model="save_send" class="btn btn-lg btn-primary btn-block action_button"><i class="bi bi-save2 bi-center"></i> Save & Send</button>
                                </div>
                                <div class="col-md-3 ">
                                    <button type="button" data-model="save" class="btn btn-lg btn-info btn-block action_button"><i class="bi bi-save2 bi-center"></i> Save as Draft</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-lg btn-block btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-square bi-center"></i> Close</button>
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
    var ad_library_url = '<?php echo LIBRARY_PATH."/summernote.lib.php"; ?>';
    var ad_folder_directory = 'others';
    var ad_class_name = 'sb_summernote_editor';
    $('.sb_summernote_editor').summernote({
        tabsize: 2,
        height: 500,
        spellCheck: true,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'italic', 'superscript', 'subscript', 'clear']],
          ['fontname', ['fontname','fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture']],
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
        $('.selectpicker02').selectpicker();
    });

    $(document).ready(function() {
        // On select match option value to hidden input value
        $('#select_email_draft').change(function() {
            // var control = $(this);
            const subject = $(this).find(':selected').data('subject');
            const body = $(this).find(':selected').data('body');
            $('.ed_title').val(subject);
            $('.ed_body').summernote("code", body);
        });
    });
</script>