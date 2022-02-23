<?php require_once("../../../resources/directories.inc.php"); ?>
<!-- Modal -->
<div class="modal fade" id="addSocialFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-lg" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form class="form addSocialFeedForm" id="add_social_feedback_form" method="post" novalidate autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header mb-4">
                                        <h4 class="weight-700">Social Media Feed Form</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8">
                                                <div class="form-group">
                                                <label for="awsoc_type" class="control-label"> Social media type<span class="text-danger">*</span> </label> 
                                                <select name="awsoc_type" class="form-control form-select awsoc_type">
                                                    <option value="">Select one</option>
                                                    <option value="facebook">Facebook</option>
                                                    <option value="twitter">Twitter</option>
                                                    <option value="youtube">Youtube</option>
                                                    <option value="snapchat">Snapchat</option>
                                                    <option value="tiktok">TikTok</option>
                                                    <option value="instagram">Instagram</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="awsoc_url" class="control-label"> Social media Url<span class="text-danger">*</span> </label> 
                                                <textarea name="awsoc_url" rows="10" id="awsoc_url" class="form-control"></textarea>
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

