<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade editEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-BS-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form edit_event_form" method="post" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Update Event Post</h3>
                                    <h5>Last update was on: <span class="text-primary ed_eve_updated_at"></span></h5>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-4 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_eve_banner" class="control-label"> Event Main Banner <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img" width="100%" style="max-height:20rem;"  /></p>
                                                <input name="ed_eve_banner" class="input-group form-control ed_eve_banner" type="file" accept="image/*" onchange="previewImage(event)" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_eve_image1" class="control-label"> Event Image one </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img1" width="100%" style="height:20rem;"  /></p>
                                                <input name="ed_eve_image1" class="input-group form-control ed_eve_image1" type="file" accept="image/*" onchange="previewImageOne(event)" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_eve_image2" class="control-label">Event Image two </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img2" width="100%" style="height:20rem;"  /></p>
                                                <input name="ed_eve_image2" class="input-group form-control ed_eve_image2" type="file" accept="image/*" onchange="previewImageTwo(event)" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class=" mt-2">
                                        <h4>Event Details</h4>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_eve_category" class="control-label"> Event Category <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <select name="ed_eve_category" class="form-control form-select ed_eve_category" >
                                                    <option value="">Select one</option>
                                                    <option value="music">Music</option>
                                                    <option value="entertainment">Entertainment</option>
                                                    <option value="fashion & lifestyle">Fashion & Lifestyle</option>
                                                    <option value="sports">Sports</option>
                                                    <option value="culture">Culture</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-8">
                                            <div class="form-group">
                                                <label for="ed_eve_name" class="control-label"> Event Name <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <input class="form-control ed_eve_name" type="text" maxLength="250" name="ed_eve_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_eve_description" class="control-label"> Description </label> 
                                                <textarea name="ed_eve_description" rows="10" class="form-control ed_summernote_editor ed_eve_description"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_eve_location" class="control-label"> Location <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <input class="form-control ed_eve_location" type="text" maxLength="250" name="ed_eve_location">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_eve_map_location" class="control-label"> Map Location Url </label> 
                                                <input class="form-control ed_eve_map_location" type="text" maxLength="450" name="ed_eve_map_location">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="ed_eve_venue" class="control-label"> Venue <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <input class="form-control ed_eve_venue" type="text" maxLength="120" name="ed_eve_venue">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_organiser_logo" class="control-label"> Organiser logo </label> 
                                                <p style="min-height: 5px;" ><img src="" class="display_img3" width="100%" style="max-height:140px;"  /></p>
                                                <input name="ed_eve_organiser_logo" class="input-group form-control ed_eve_organiser_logo" type="file" accept="image/*" onchange="previewImageThree(event)" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <div class="form-group">
                                                <label for="ed_eve_organiser" class="control-label"> Event organiser <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <input class="form-control ed_eve_organiser" type="text" maxLength="150" name="ed_eve_organiser">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ed_eve_fb_link" class="control-label"> FB link <span class="text-primary fab fa-facebook"></span></label> 
                                                <textarea class="form-control ed_eve_fb_link" name="ed_eve_fb_link" rows="2" maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ed_eve_twitter_link" class="control-label"> Twitter link <span class="text-info fab fa-twitter"></span></label> 
                                                <textarea class="form-control ed_eve_twitter_link" name="ed_eve_twitter_link" rows="2" maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ed_eve_ig_link" class="control-label"> Instagram link <span class="text-secondary fab fa-instagram"></span></label> 
                                                <textarea class="form-control ed_eve_ig_link" name="ed_eve_ig_link" rows="2" maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ed_eve_yt_video_link" class="control-label">Youtube link <span class="text-danger fab fa-youtube"></span></label> 
                                                <textarea class="form-control ed_eve_yt_video_link" name="ed_eve_yt_video_link" rows="2" maxlength="250"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_eve_tags" class="control-label"> Hash tags <small class="text-primary">(seperate each hash-tag with a comma... eg. #music,#outing,#family)</small></label> 
                                                <textarea class="form-control ed_eve_tags" name="ed_eve_tags" rows="2" maxlength="250"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_start_date" class="control-label"> Start date <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <input class="form-control ed_eve_start_date" type="date" name="ed_eve_start_date">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_end_date" class="control-label"> End date <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <input class="form-control ed_eve_end_date" type="date" name="ed_eve_end_date">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_start_time" class="control-label"> Start time <span class="text-danger fa fa-asterisk"></span> <small class="text-primary">(for each day of event)</small></label> 
                                                <input class="form-control ed_eve_start_time" type="time" name="ed_eve_start_time">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_end_time" class="control-label"> Closing time <span class="text-danger fa fa-asterisk"></span> <small class="text-primary">(for each day of event)</small></label> 
                                                <input class="form-control ed_eve_end_time" type="time" name="ed_eve_end_time">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class=" mt-2">
                                        <h4>Ticketing Details</h4>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_enable_ticket_sales" class="control-label"> Enable ticket sales for this event? <span class="text-danger fa fa-asterisk"></span> </label> 
                                                <select name="ed_eve_enable_ticket_sales" class="form-control form-select ed_eve_enable_ticket_sales">
                                                    <option value="">Select one</option>
                                                    <option data-value="yes" value="1">Yes</option>
                                                    <option data-value="no" value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2 enableTicketYes">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_eve_ticket_image" class="control-label"> Ticket image  </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img4" width="100%" style="height:auto;"  /></p>
                                                <input name="ed_eve_ticket_image" class="input-group form-control ed_eve_ticket_image" type="file" accept="image/*" onchange="previewImageFour(event)" />
                                            </div>
                                            <div class="py-2"><hr></div>
                                        </div>
                                    </div>

                                    <div class="row mt-2 enableTicketYes">
                                        <?php for ($i=1; $i < 5; $i++) { ?>
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="ed_eve_ticket_name<?php echo $i; ?>" class="control-label"> Ticket name <?php echo $i; ?> <span class="text-danger fa fa-asterisk"></span></label> 
                                                            <input class="form-control ed_eve_ticket_name<?php echo $i; ?>" type="text" maxlength="120" name="ed_eve_ticket_name<?php echo $i; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="eve_ticket_desc<?php echo $i; ?>" class="control-label"> Ticket Description <?php echo $i; ?> <small class="text-primary">(tell attendees more about the ticket type)</small></label> 
                                                            <textarea class="form-control ed_eve_ticket_desc<?php echo $i; ?>" name="ed_eve_ticket_desc<?php echo $i; ?>" rows="5" maxlength="350"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="ed_eve_ticket_price<?php echo $i; ?>" class="control-label"> Ticket price <?php echo $i; ?> <span class="text-danger fa fa-asterisk"></span></label> 
                                                            <input class="form-control ed_eve_ticket_price<?php echo $i; ?>" type="number" maxlength="15" max="50000000" name="ed_eve_ticket_price<?php echo $i; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="ed_eve_ticket_quantity<?php echo $i; ?>" class="control-label"> Ticket Quantity <?php echo $i; ?> <span class="text-danger fa fa-asterisk"></span></label> 
                                                            <input class="form-control ed_eve_ticket_quantity<?php echo $i; ?>" type="number" maxlength="15" max="50000000" name="ed_eve_ticket_quantity<?php echo $i; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="py-2"><hr></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="row mt-2 enableTicketYes">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_start_sales_on" class="control-label"> Start sales on <span class="text-danger fa fa-asterisk"></span></label> 
                                                <input class="form-control ed_eve_start_sales_on" type="date" name="ed_eve_start_sales_on">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="ed_eve_ends_sales_on" class="control-label"> End sales on <span class="text-danger fa fa-asterisk"></span></label> 
                                                <input class="form-control ed_eve_ends_sales_on" type="date" name="ed_eve_ends_sales_on">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ed_eve_audience" class="control-label"> Target audience <span class="text-danger fa fa-asterisk"></span></label> 
                                                <input type="text" class="form-control ed_dis_eve_audience" name="ed_dis_eve_audience" readonly>
                                                <select name="ed_eve_audience[]" class="form-control form-select selectpicker02 ed_eve_audience" multiple>
                                                    <option value="">Select one</option>
                                                    <option value="children">Children</option>
                                                    <option value="youth">Youth</option>
                                                    <option value="family">Family</option>
                                                    <option value="adults">Adults</option>
                                                    <option value="couples">Couples</option>
                                                    <option value="group">Group</option>
                                                    <option value="everyone">Everyone</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class=" mt-2">
                                        <h4>Options On Webite</h4>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="ed_eve_show_attendees" class="control-label"> Show attendees? <span class="text-danger fa fa-asterisk"></span></label> 
                                                <select name="ed_eve_show_attendees" class="form-control form-select ed_eve_show_attendees" >
                                                    <option value="">Select one</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="ed_eve_enable_reviews" class="control-label"> Enable reviews? <span class="text-danger fa fa-asterisk"></span></label> 
                                                <select name="ed_eve_enable_reviews" class="form-control form-select ed_eve_enable_reviews">
                                                    <option value="">Select one</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4 offset-md-2 mt-2">
                                            <input type="hidden" name="hidden_hashed" class="hidden_hashed" readonly>
                                            <input type="hidden" name="hidden_ticket_hashed" class="hidden_ticket_hashed" readonly>
                                            <input type="hidden" name="hidden_eve_banner" class="hidden_eve_banner" readonly>
                                            <input type="hidden" name="hidden_eve_image1" class="hidden_eve_image1" readonly>
                                            <input type="hidden" name="hidden_eve_image2" class="hidden_eve_image2" readonly>
                                            <input type="hidden" name="hidden_eve_organiser_logo" class="hidden_eve_organiser_logo" readonly>
                                            <input type="hidden" name="hidden_eve_ticket_image" class="hidden_eve_ticket_image" readonly> 
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
    var ed_folder_directory = 'events';
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


    //hide of unhide eve_enable_ticket_sales when 'ed_eve_enable_ticket_sales' is chosen
    $('.enableTicketYes').hide(); 
    $(document).on('change', '.ed_eve_enable_ticket_sales', function(event) {
        event.preventDefault();
        var ctrl = $(this);
        var dataValue  = ctrl.find(':selected').val();

        if (dataValue == 1) { $('.enableTicketYes').show(); } else if (dataValue == 0 || dataValue == ""){ $('.enableTicketYes').hide(); } else{$('.enableTicketYes').hide();}
    });
</script>