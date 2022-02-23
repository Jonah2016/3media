<style>
    .horizontal_form_one{
        flex-direction: row;
    }
    .horizontal_subs_no_ads_one {
        min-height: 15rem;
    }
    .horizontal_subs_no_ads_one_container{
        padding: 3.2rem;
    }
    .horizontal_subs_no_ads_one .hor_subs_text {
        color: #fff;
        font-weight: 700;
        align-items: center;
    }

    .horizontal_subs_no_ads_one span {
        color: #f03c3c;
        font-weight: 700;
        font-style: italic;
    }

    .horizontal_subs_no_ads_one .subs_btn{
        background-color: #fe4d55;
        text-align: center;
    }
    .horizontal_subs_no_ads_one .subs_btn:hover{
        background-color: #fe5e66;
    }

    @media screen and (max-width: 768px){
        .horizontal_subs_no_ads_one {
            min-height: 16rem;
        }
        .horizontal_subs_no_ads_one_container{
            padding: 3.6rem 0.5rem;
        }
    }
</style>


<div class="horizontal_subs_no_ads_one">
    <div class="container">
        <div class="row horizontal_subs_no_ads_one_container">
            <div class="col-12 col-lg-6 col-md-6 col-sm-12 mb-2">
                <p class="text-white hor_subs_text mb-0 mb-md-0 mb-sm-2">Sign up for the <span>3Music Newsletter</span> for breaking news, events, and unique stories.</p>
            </div>
            <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                <form class="no_ad_subscription_one_form form-inline" onsubmit="submitSubscription(event)" method="post" novalidate enctype="multipart/form-data">
                    <div class="horizontal_form_one row input-group input-group-lg">
                        <div class="col-12 col-lg-8 col-md-8 col-sm-12 mb-2">
                            <input type="email" maxlength="80" pattern="^[a-zA-Z0-9.-_+]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" name="subscribe_email" class="form-control input-lg no_ad_subscribe_email_one" placeholder="Email Address">
                        </div>
                        <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-2">
                            <button class="btn btn-md btn-light subs_btn btn-block"> Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add Subscription when no_ad_subscription_one_form is submitted
    function SaveNoAdSubscriptionOne(formData, form_name, field_name) {
        // Save the details by requesting to the server using ajax 
        var no_ad_subscribe_email_one = $("."+field_name).val(); 
        if (no_ad_subscribe_email_one != "") {
            $.ajax({
                url: '<?php echo BASE_URL; ?>classes/UserControllers.php',
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
    // save Subscription when no_ad_subscription_one_form is submitted
   function submitSubscription(event) {
        event.preventDefault(); 
        var no_ad_subscribe_email_one = $(".no_ad_subscribe_email_one").val();  
        if (no_ad_subscribe_email_one == "") {
            var msg = "Sorry, your valid email is required to subscribe to our newsletter";
            error_operation(msg);
            return false;
        } 
        var form_name = "no_ad_subscription_one_form";
        var field_name = "no_ad_subscribe_email_one";
        var formData = new FormData(this);
        formData.append("action", "subscribe");
        SaveNoAdSubscriptionOne(formData, form_name, field_name);
    };
</script>