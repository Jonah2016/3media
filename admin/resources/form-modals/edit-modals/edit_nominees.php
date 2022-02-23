<?php require_once("../../../resources/auth.inc.php"); ?>
<!-- Modal -->
<div class="modal fade editNomineeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-BS-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form edit_nominee_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Update Nominee</h3>
                                    <h5>Last update was on: <span class="text-primary ed_awn_updated_at"></span></h5>
                                </div>

                                <div class="card-body"> 
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_awn_cover_image" class="control-label"> Cover photo<span class="text-danger">*</span> </label> 
                                                <p><img src="" class="display_img" height="230" width="100%" /></p>
                                                <input name="ed_awn_cover_image" class="input-group form-control ed_awn_cover_image" type="file" accept="image/*" onchange="previewImage(event)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="ed_awn_type" class="control-label"> Nominee type<span class="text-danger">*</span> </label> 
                                                <select name="ed_awn_type" class="form-control form-select ed_awn_type">
                                                    <option value="">Select one</option>
                                                    <option value="single">Single</option>
                                                    <option value="group">Group</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-10 showSingle">
                                                <div class="form-group">
                                                <label for="ed_awn_fullname_one" class="control-label"> Nominee name<span class="text-danger">*</span> </label> 
                                                <input class="form-control nomineesTitle ed_awn_fullname_one" type="text" maxLength="150" onchange="validateLength('nomineesTitle')" name="ed_awn_fullname_one" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7 showGroup">
                                                <div class="form-group">
                                                <label for="ed_awn_fullname_two" class="control-label"> Nominees names<span class="text-danger">*</span> </label> 
                                                <input class="form-control nomineesTitle ed_awn_fullname_two" type="text" maxLength="500" onchange="validateLength('nomineesTitle')" name="ed_awn_fullname_two">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_awn_category" class="control-label"> Nominee category<span class="text-danger">*</span> </label>
                                                <?php   
                                                    // search category  
                                                    $in_sql01 = $db_connect->prepare("SELECT DISTINCT(awc_title) FROM award_categories WHERE awc_active_status=1 ORDER BY awc_title ASC"); 
                                                    $in_sql01->execute();
                                                ?>
                                                <select name="ed_awn_category" class="form-select form-control ed_awn_category" data-placeholder="Select category" >
                                                    <option value=""> Select category</option>
                                                    <?php
                                                        $i=0;
                                                        while($in_row01=$in_sql01->fetch(PDO::FETCH_ASSOC)) 
                                                        {
                                                            extract($in_row01); 
                                                            $awc_title = strtoupper($in_row01['awc_title']);   
                                                    ?>
                                                    <option value="<?=$awc_title;?>" ><?=$awc_title; ?></option>
                                                    <?php
                                                            $i++;
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_awn_biography" class="control-label"> Norminee Biography </label> 
                                                <textarea name="ed_awn_biography" rows="10" class="form-control ed_awn_biography ed_summernote_editor"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="ed_awn_year" class="control-label"> Nomination Year<span class="text-danger">*</span> </label> 
                                                <select name="ed_awn_year" class="form-control form-select ed_awn_year">
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

                                    <div class="row mb-3">
                                        <div class="col-md-4 offset-md-2 mt-2">
                                            <input type="hidden" name="hidden_hashed" class="hidden_hashed" readonly>
                                            <input type="hidden" name="hidden_awn_cover_image" class="hidden_awn_cover_image" readonly>
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
<script src="<?php echo BASE_URL; ?>assets/vendors/summernote-0.8.18/summernote-lite.min.js"></script>
<script>
    $('.ed_summernote_editor').summernote({
        tabsize: 2,
        height: 300,
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

<script>
    //hide of unhide awn_type when 'awn_type' is chosen
    $(document).on('change', '#awn_type', function(event) {
        event.preventDefault();
        var ctrl = $(this);
        var dataValue  = ctrl.find(':selected').val();

        if (dataValue == "single") { $('.showSingle').show(); $('.showGroup').hide(); } else if (dataValue == "group"){ $('.showGroup').show(); $('.showSingle').hide(); } else{$('.showGroup').hide(); $('.showSingle').hide();}
    });
</script>