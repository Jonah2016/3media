<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );
?>
<!-- Modal -->
<div class="modal modal-blur fade noselect" id="SignUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <!-- modal-dialog -->
    <div class="modal-dialog modal-md" role="document" style="width: 100%;">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-body mx-3">
                <form class="form" id="signup_form" method="post" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-12 noselect" align="center" >
                                    <img align="center" src="<?php echo ASSETS_PATH.'/img/logo.png'; ?>" width="80px" height="80px">
                                </div>
                                <div class="col-12">
                                    <h4 class="weight-700">Coversation Panel</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h5>Your signup matters. Discussions are strictly moderated for civility and serenity.</h5>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="signup_message" maxLength="1500" onchange="validateLength('signup_message')" class="form-control signup_message" ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <div class="col-md-4 offset-md-2 col-sm-12 mb-1">
                                    <button type="submit" class="btn btn-md btn-primary btn-block"><i class="bi bi-save2 bi-center"></i> Save</button>
                                </div>
                                <div class="col-md-4  col-sm-12 mb-1">
                                    <button type="button" class="btn btn-md btn-block btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-square bi-center text-uppercase"></i> Close Panel</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3 mt-3">
                                <div class="col-md-12">
                                    <a href="#"> Terms & Conditions </a> | <a href="#"> Privacy </a>
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
<!-- // modal -->

