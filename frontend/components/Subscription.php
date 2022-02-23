
<section class="subscription_section">
    <div class="subs_container container bg_light mb-0 h-100">
        <div class="row h-100">
            <div class="col-lg-8 subs_captions h-100" style="min-height: 30rem; max-height:42rem">
                <div class="subs_title">IN YOUR INBOX, YOU WILL RECEIVE ORIGINAL REPORTING ON EVERYTHING THAT IS IMPORTANT.</div>
                <div class="subs_form">
                    <form class="form ad_subscription_form" method="post" novalidate enctype="multipart/form-data">
                        <div class="row">                                
                            <div class="form-group col-12 col-lg-10 col-md-10 col-sm-12 mb-2">
                                <input type="email" maxlength="80" pattern="^[a-zA-Z0-9.-_+]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" name="subscribe_email" class="form-control ad_subscribe_email" placeholder="Email Address">
                            </div>
                            <div class="form-group  col-12 col-lg-2 col-md-2 col-sm-12">
                                <button class="btn btn-lg btn-light subs_btn"> Subscribe</button>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <p>By subscribing to the 3MUSIC newsletter, you consent to receive electronic communications from 3MUSIC, which may include ads or sponsored material on occasion.</p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 p-0" style="min-height: 30rem; max-height:42rem">
                <?php
                    $date_now01        = date('Y-m-d');
                    $adverts_category  = $page_name;
                    $adverts_dimension = "square";
                    $adverts_type      = "image";
                    // Retrieve all ads by parameters data from Ads class
                    $home_ad_class = new AdsController([
                        'date_now'          => $date_now01,
                        'adverts_category'  => $adverts_category,
                        'adverts_dimension' => $adverts_dimension,
                        'adverts_type'      => $adverts_type
                    ]);
                    $home_ads_data   = $home_ad_class->getAdByParams();
                    $sliced_ad_array = array_slice($home_ads_data, 0, 1, true);
                    if(count($sliced_ad_array) > 0) {
                        foreach ($sliced_ad_array as $key => $subs_ad) {
                            $advs01_url = $subs_ad['adverts_url'];
                            $advs01_title = $subs_ad['adverts_title'];
                            $advs01_cover_image = $subs_ad['adverts_cover_image'];
                            $advs01_cover_image1 = (!empty($advs01_cover_image)) ? UPLOAD_PATH."advsImages/".$advs01_cover_image : ASSETS_PATH."/img/placeholders/ad_placeholder.png";  
                ?>
                <div class="subs_adv_image h-100" style="min-height: 30rem; max-height:42rem">
                    <img class="noselect fluid_img" src="<?php echo $advs01_cover_image1; ?>" alt="<?php echo $advs01_title; ?>">
                </div> 
                <?php 
                        } 
                    } 
                    else { 
                ?>
                <div class="subs_adv_image h-100" style="min-height: 30rem; max-height:42rem">
                    <img class="noselect fluid_img" src="<?php echo ASSETS_PATH."/img/placeholders/ad_placeholder.png"; ?>" alt="ad banner">
                </div> 
                <?php 
                    } 
                ?>
            </div>
        </div>
    </div>    
</section>


<script>
    $(document).ready(function() {
        // Add Subscription when ad_subscription_form is submitted
        function SaveAdSubscription(formData, form_name, field_name) {
            // Save the details by requesting to the server using ajax 
            var ad_subscribe_email = $("."+field_name).val(); 
            if (ad_subscribe_email != "") {
                $.ajax({
                    url: '<?php echo MODELS_PATH; ?>/user.mod.php',
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.code == "200") {
                            var msg = data.msg;
                            $('.'+form_name)[0].reset();
                            success_operation(msg);
                        } else {
                            var msg = data.msg;
                            error_operation(msg);
                        }
                    },
                }); 
                return false;
            } else {
                var msg = "Make sure your entered a valid email";
                error_operation(msg);
            }
        }
        // save Subscription when ad_subscription_form is submitted
        $(document).on("submit", ".ad_subscription_form", function(event) {
            event.preventDefault(); 
            var ad_subscribe_email = $(".ad_subscribe_email").val();  
            if (ad_subscribe_email == "") {
                var msg = "Sorry, your valid email is required to subscribe to our newsletter";
                error_operation(msg);
                return false;
            } 
            var form_name = "ad_subscription_form";
            var field_name = "ad_subscribe_email";
            var formData = new FormData(this);
            formData.append("action", "subscribe");
            SaveAdSubscription(formData, form_name, field_name);
        });
    });

</script>


