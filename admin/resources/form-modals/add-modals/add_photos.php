
<!-- Modal -->
<div class="modal fade" id="addPhotosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal-dialog -->
	<div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body m-2 text-left">
                <form method="post" novalidate class="addPhotosForm form" id="add_photos_form" autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header mb-2">
                                        <h4 class="weight-700">Add Photo Album Form</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8">
                                            <div class="form-group">
                                                <label for="photo_title" class="control-label">Photo Title*</label> 
                                                <input class="form-control photo_title"  name="photo_title" type="text" maxlength="250" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="photo_date" class="control-label">Photo Date</label> 
                                                <input class="form-control photo_date"  name="photo_date" type="date" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="photo_image" class="control-label">Photo <small class="text-danger">(Optimize photos to < 5MB)</small></label> 
                                                <input class="input-group form-control photo_image" type="file" name="photo_image[]" onchange="previewMultipleImage(this, 'div.photos')" accept="image/*"  multiple />
                                                <div class="photos"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="photo_link" class="control-label">Photo(S) Link <small class="text-danger">(Separate links with comma and one space when you want to paste multiple urls)</small> </label>
                                                <textarea name="photo_link" rows="5" class="form-control photo_link"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="photo_img_caption" class="control-label pt-1"> Photos caption<span class="text-danger">*</span> </label> 
                                                <input class="form-control imgCaption photo_img_caption" type="text" maxLength="250" onchange="validateLength('imgCaption')" name="photo_img_caption" >
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

