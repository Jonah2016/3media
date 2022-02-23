
<!-- Modal -->
<div class="modal fade" id="addAdvModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form addAdvForm" id="add_adv_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header mb-4">
                                        <h4 class="weight-700">Ad Campaign Form</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="adverts_cover_image" class="control-label"> Cover Image <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <p style="min-height: 100px; border: 1px solid grey;" ><img src="" class="display_img" width="100%" style="height:auto;"  /></p>
                                                <input name="adverts_cover_image" id="adverts_cover_image" class="input-group form-control" type="file" accept="image/*" onchange="previewImage(event)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                <label for="adverts_type" class="control-label"> Ad Type <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <select name="adverts_type" class="form-control form-select" id="adverts_type">
                                                    <option value="">Select one</option>
                                                    <option value="video">Video</option>
                                                    <option value="image">Image</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="adverts_category" class="control-label"> Ad Page/Category <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <select name="adverts_category" class="form-control form-select" id="adverts_category">
                                                    <option value="">Select one</option>
                                                    <option value="home-page">Home Page</option>
                                                    <option value="about-page">About Page</option>
                                                    <option value="award-page">Awards Page</option>
                                                    <option value="videos-page">Videos Page</option>
                                                    <option value="music-page">Music Page</option>
                                                    <option value="news-page">News Page</option>
                                                    <option value="events-page">Events Page</option>
                                                    <option value="music">Music Category</option>
                                                    <option value="entertainment">Entertainment Category</option>
                                                    <option value="fashion & lifestyle">Fashion & Lifestyle Category</option>
                                                    <option value="sports">Sports Category</option>
                                                    <option value="culture">Culture Category</option>
                                                    <option value="snapshot-page">Snapshots Page</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                <label for="adverts_dimension" class="control-label"> Ad Orientation <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <select name="adverts_dimension" class="form-control form-select" id="adverts_dimension">
                                                    <option value="">Select one</option>
                                                    <option value="square">Square</option>
                                                    <option value="horizontal-rectangle">Horizontal Rectangle</option>
                                                    <option value="vertical-rectangle">Vertical Rectangle</option>
                                                    <option value="circle">Circle</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-7">
                                                <div class="form-group">
                                                <label for="adverts_title" class="control-label"> Ad Title <span class="text-danger">*</span> </label> 
                                                <input class="form-control" type="text" maxLength="350" name="adverts_title" id="adverts_title">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5">
                                                <div class="form-group">
                                                <label for="adverts_organisation" class="control-label"> Campaigner (Organisation) <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <input class="form-control" type="text" maxLength="150"  name="adverts_organisation" id="adverts_organisation">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                <label for="adverts_url" class="control-label"> Ad External Url </label> 
                                                <input class="form-control" type="url" maxLength="500" name="adverts_url" id="adverts_url">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                <label for="adverts_video_url" class="control-label"> Video Url <span class="text-info">(for video campaigns only)</span> </label> 
                                                <input class="form-control" type="url" maxLength="450" name="adverts_video_url" id="adverts_video_url">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                <label for="adverts_campaign_days" class="control-label"> Campaign Days <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <select name="adverts_campaign_days[]" class="selectpicker01 form-control" id="adverts_campaign_days" data-placeholder="Select campaign days" multiple>
                                                    <option value="">Select one</option>
                                                    <option value="ALL">ALL</option>
                                                    <option value="MONDAY">MONDAY</option>
                                                    <option value="TEUSDAY">TEUSDAY</option>
                                                    <option value="WEDNESDAY">WEDNESDAY</option>
                                                    <option value="THURSDAY">THURSDAY</option>
                                                    <option value="FRIDAY">FRIDAY</option>
                                                    <option value="SATURDAY">SATURDAY</option>
                                                    <option value="SUNDAY">SUNDAY</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="adverts_start_date" class="control-label"> Campaign Start Date <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <input class="form-control" type="date" name="adverts_start_date" id="adverts_start_date">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="adverts_end_date" class="control-label"> Campaign End Date <span class="text-danger fas fa-asterisk"></span> </label> 
                                                <input class="form-control" type="date" name="adverts_end_date" id="adverts_end_date">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="adverts_briefing" class="control-label"> Ad Briefing </label> 
                                                <textarea name="adverts_briefing" maxLength="350" rows="3" class="form-control" id="adverts_briefing"></textarea>
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

<script>
    //Multple select field 
    jQuery(document).ready(function() {
        $('.selectpicker01').selectpicker();
    });
</script>