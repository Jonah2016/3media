    <footer class="footer_section noselect">
        <div class="container">
            <div class="footer_cta pt-5 pb-5">
                <div class="row flex justify-content-center">
                    <div class="col-lg-4 col-md-4 mb-4">
                        <div class="single_cta">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="cta_text">
                                <h4>Find us</h4>
                                <span>No 12 Afunya Street, Abelenpke, Accra</span><br>
                                <span>GPS: GA-092-5841</span>
                            </div>
                            <div class="single_cta pt-3">
                                <i class="fas fa-phone"></i>
                                <div class="cta_text">
                                    <h4>Call us</h4>
                                    <span>0302791949</span>
                                </div>
                            </div>
                            <div class="single_cta pt-3">
                                <i class="far fa-envelope-open"></i>
                                <div class="cta_text">
                                    <h4>Mail us</h4>
                                    <span>shout@3media.tv</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-3 text-center">
                        <div class="cta_text">
                            <h4>FACEBOOK TIMELINE</h4>                            
                            <!-- <div class="fb-page social_media_feed" data-href="https://web.facebook.com/3musicnetworks" data-tabs="timeline" data-width="" data-height="560px" data-small-header="true" data-adapt-container-width="false" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://web.facebook.com/3musicnetworks" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/3musicnetworks">3 MUSIC</a></blockquote></div> -->
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-3 text-center">
                        <div class="cta_text">
                            <h4>TWITTER FEED</h4>
                            <div class="social_media_feed">
                                <!-- <h4><a class="twitter-timeline" href="https://twitter.com/3musicnetworks?ref_src=twsrc%5Etfw">Tweets by 3musicnetworks</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></h4> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_content pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-5">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="<?php echo BASE_PATH; ?>"><img height="100%" width="100px" src="<?php echo ASSETS_PATH."/img/logo_sk_white.png"; ?>" class="img-fluid" alt="logo"></a>
                            </div>
                            <div class="footer_text">
                                <p>An innovative media broadcast company focusing on music, entertainment and lifestyle content to entertain and inform our TG.  Our content is broadcast mainly on TV, Online and radio. </p>
                            </div>
                            <div class="footer_social_icon">
                                <span>Follow us</span>
                                <a target="__blank" href="https://web.facebook.com/3musicnetworks"><i class="fab fa-facebook-f facebook_bg"></i></a>
                                <a target="__blank" href="https://twitter.com/3musicnetworks"><i class="fab fa-twitter twitter_bg"></i></a>
                                <a target="__blank" href="https://www.instagram.com/3musicnetworks/"><i class="fab fa-instagram instagram_bg"></i></a>
                                <a target="__blank" href="https://www.tiktok.com/@3music.tv?lang=en"><i class="fab fa-tiktok google_bg"></i></a>
                                <a target="__blank" href="https://www.youtube.com/3MUSICNetworks/"><i class="fab fa-youtube google_bg"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                        <div class="footer_widget">
                            <div class="footer_widget_heading">
                                <h3>Useful Links</h3>
                            </div>
                            <ul>
                                <li><a href="<?php echo BASE_PATH; ?>">Home</a></li>
                                <li><a href="<?php echo SECTION_PATH; ?>about/">About</a></li>
                                <li><a href="<?php echo SECTION_PATH; ?>award/">3music Awards</a></li> 
                                <li><a href="#">Security Policy</a></li>
                                <li><a href="#">Privacy & Terms</a></li>
                                <li><a href="<?php echo SECTION_PATH; ?>contact/">Contact us</a></li> 
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                        <div class="footer_widget">
                            <div class="footer_widget_heading">
                                <h3>Subscribe</h3>
                            </div>
                            <div class="footer_text mb-25">
                                <p>Don’t miss to subscribe to our new feeds, kindly fill the form below.</p>
                            </div>
                            <div class="subscribe_form">
                                <form class="form subscription_form_footer" method="post" novalidate enctype="multipart/form-data">
                                    <input type="email" maxlength="80" name="subscribe_email" class="subscribe_email_footer" placeholder="Email Address">
                                    <button type="submit"><i class="fab fa-telegram-plane"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright_area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright_text">
                            <p>Copyright &copy; 2018, All Right Reserved <a href="https://3music.tv">3Music Networks Limited</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer_menu">
                            <ul>
                                <li><a href="<?php echo BASE_PATH; ?>">Home</a></li>
                                <li><a href="#">Terms</a></li>
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">Policy</a></li>
                                <li><a href="<?php echo SECTION_PATH; ?>contact/">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Add Subscription when subscription_form is submitted
        function SaveFooterSubscription(formData, form_name, field_name) {
            // Save the details by requesting to the server using ajax 
            var subscribe_email = $("."+field_name).val(); 
            if (subscribe_email != "") {
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
        // save Subscription when subscription_form_footer is submitted
        $(document).on("submit", ".subscription_form_footer", function(event) {
            event.preventDefault(); 
            var subscribe_email = $(".subscribe_email_footer").val();  
            if (subscribe_email == "") {
                var msg = "Sorry, your valid email is required to subscribe to our newsletter";
                error_operation(msg);
                return false;
            } 
            var form_name = "subscription_form_footer";
            var field_name = "subscribe_email_footer";
            var formData = new FormData(this);
            formData.append("action", "subscribe");
            SaveFooterSubscription(formData, form_name, field_name);
        });
    </script>