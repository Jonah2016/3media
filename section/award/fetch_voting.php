<?php   
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );
?>

<form id="votingForm" class="vote_cat_container" method="post" novalidate enctype="multipart/form-data">
    <div class="row">
        <?php  
            if(!empty($_POST["action"]) && (isset($_POST['action']) == "fetch_voting_data"))
            {
                // Retrieve all news data by cateory and ids from News class
                $awn_year = "";
                $awc_year = date('Y');
                // Retrieve all award categories data by year and AwardCategories class
                $award_categories_class = new AwardCategoryController([
                    'awc_year' => $awc_year,
                ]);
                $award_categories = $award_categories_class->getAllAwardCategoriesByYear();
                if(count($award_categories) > 0) {
                    foreach ($award_categories as $key => $awd_cat_data) {
                        $random_id = "cat".rand(10000,10000);
                        $awc_id    = $awd_cat_data['awc_id']; 
                        $awc_title = $awd_cat_data['awc_title']; 
        ?>
        <div class="my-4">
            <div class="col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-12 offset-sm-0">
                <div class="card">
                    <div class="card-header vote_cat_header">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-12 vote_cat_header_text">
                                <h2><?php echo $awc_title; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <?php 
                            $query_param = $awc_title;
                            // Retrieve all nominees data by cateory and ids from AwardNominees class
                            $nominee_class = new NomineeController([
                                'param'        => $query_param,
                                'awn_category' => $awc_title,
                                'query_type'   => 'by_nomination_category'
                            ]);
                            $nominees = $nominee_class->getAllNomineesByCatYear();
                            if(count($nominees) > 0) {
                                foreach ($nominees as $key => $nominee_data) {
                                    if ($nominee_data['awn_year'] == date('Y')) {
                                        $awn_id          = $nominee_data['awn_id'];
                                        $awn_year        = $nominee_data['awn_year'];
                                        $awn_type        = $nominee_data['awn_type'];
                                        $awn_category    = $nominee_data['awn_category'];
                                        $awn_fullname    = $nominee_data['awn_fullname'];
                                        $awn_biography   = htmlspecialchars_decode($nominee_data['awn_biography']);
                                        $awn_hashed      = $nominee_data['awn_hashed'];
                                        $awn_win_status  = $nominee_data['awn_win_status'];
                                        $awn_cover_image = $nominee_data['awn_cover_image'];
                                        $photo_directory = (!empty($awn_cover_image)) ? UPLOAD_PATH."awards/".$awn_cover_image : UPLOAD_PATH."templates/no_photo.png";

                                        // Count total votes counted
                                        $voter_id = $_COOKIE['browsingToken'] ?? $_SESSION['browsingToken'] ?? "";
                                        $stmt02 = $db_connect->prepare("SELECT awvs_id FROM award_vote_cast WHERE awvs_voter_id='$voter_id' AND awvs_nominee_id = '$awn_id' AND awvs_category_id = '$awc_id' ");  
                                        $stmt02->execute();
                                        $tot_row02=$stmt02->rowCount();

                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 h-100">
                            <div class="row vote_cat_body clean_shadow">
                                <div class="col-lg-4 col-md-12 col-sm-12 d-flex align-items-center h-100">
                                    <div class="vote_avatar">
                                        <img class="noselect fluid_img" src="<?php echo $photo_directory; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12 vote_desc_container">
                                    <div class="row py-3 px-1 h-100">
                                        <div class="col-lg-9 col-md-9 col-sm-12 h-100">
                                            <div class="vote_description mx-auto h-100">
                                                <div class="vote_description_title">
                                                    <h3><?php echo $awn_fullname; ?></h3>
                                                </div>
                                                <div class="mt-3">
                                                    <a class="btn btn-sm mb-1 biography_btn" data-name="<?php echo $awn_fullname; ?>" data-desc="<?php echo htmlentities($awn_biography); ?>" onclick="PopUpNomineeDesc(this)">Full Biography</a> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="vote_form noselect">
                                                <div class="vote_res_sect p-2 text-center">
                                                    <?php if(empty($_COOKIE["browsingToken"]) && empty($_SESSION["browsingToken"])) : ?>
                                                    <h4 class="fs-6">Vote</h4>
                                                    <div class="checkbox pt-1 voteCheckmark" data-id="check<?php echo $awn_id; ?>" data-nominee_id="<?php echo $awn_id; ?>">
                                                        <input class="<?php echo $random_id; ?>" id="check<?php echo $awn_id; ?>" name="check" type="checkbox" />
                                                        <label for="check<?php echo $awn_id; ?>"></label>
                                                    </div>
                                                    <?php else: ?>
                                                        <?php if($tot_row02 > 0) : ?>
                                                        <h4 class="pt-1 fs-5 text-success fw-bolder"><i class="bi bi-check2 fs-3 fw-bolder"></i></h4>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" readonly name="awvs_nominee_id[]" value="<?php echo $awn_id; ?>">
                                <input type="hidden" readonly name="awvs_category_id[]" value="<?php echo $awc_id; ?>">
                                <input type="hidden" readonly name="voted_for[]" id="votedFor<?php echo $awn_id; ?>" value="0">
                            </div>
                        </div>
                        <?php  }  } ?>
                        <?php if ($awn_year == ""): ?>
                            <div class="col-12 boder_all_grey">
                                 <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No nominee(s) to display within this year.</strong></span></div>
                            </div>
                        <?php endif ?>
                        <?php } else { ?>
                        <div class="col-12 boder_all_grey">
                            <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No nominee(s) to display within this category.</strong></span></div>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php     
                    }
                }
            }
            else {
        ?>
        <div class="col-12 boder_all_grey">
            <div class="show_exhausted"><span class="bg-secondary px-4 py-3 d-block w-100"><strong>No nominee(s) to display within this year.</strong></span></div>
        </div>
        <?php } ?>  
    </div>

    <?php if(isset($_SESSION["browsingToken"]) && empty($_COOKIE["browsingToken"]) && empty($_SESSION["browsingToken"])) : ?>
    <div class="row py-4">
        <div class="col-lg-2 col-md-2 offset-md-5 col-sm-12">
            <button type="submit" class="btn btn-lg btn-success" id="submitVote"><i class="bi bi-check2 fs-5 pr-2"></i> Submit Votes </button>
        </div>
    </div>
    <?php endif ?>
</form>


<!-- nominee pop up modal -->
<div class="modal fade popUpNomineeFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center justify-content-between m-auto">
                    <div class="p-2 w-100 popUpNomineeTitle text-dark fs-3"></div>
                    <div class="p-2 flex-shrink-1">
                        <button type="button" class="close weight-700 text-danger btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="bi bi-x-octagon fs-5 bi-center text-light"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="performerDescDisplay"><p class="popUpNomineeDesc"></p></div>
            </div>
        </div>
    </div>
</div> 

<script>
    // pop up nominee description
    function PopUpNomineeDesc(property){
        let name = $(property).data('name');
        let description =  $(property).data('desc');
        $('.popUpNomineeDesc').html(description).css({
            'color': '#000',
            'min-width': '50%',
            'min-height': '300px',
            'max-height': '500px',
            'padding': '10px'
        });
        $('.performerDescDisplay').css({
            'display': 'flex',
            'justify-content': 'center',
            'align-items': 'center',
            'color': '#000',
            'overflow-y': 'scroll'
        });
        $('.popUpNomineeTitle').text(name);
        $('.popUpNomineeFrame').modal('show');
    }
</script>