<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );
?>

<link href="<?php echo ASSETS_PATH; ?>/vendors/summernote-0.8.18/summernote-lite.min.css" rel="stylesheet">

<style>
    .comment_form_container .header {
        font-size: 1.5rem;
    }
    .comment_form_container .terms_txt a{
        font-size: 0.68rem;
    }
</style>

<div class="comment_form_container bg_white p-2" id="commentFormContainer" style="display:none">
    <form class="form commentForm" id="comment_form" method="post" novalidate enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-12 pb-2">
                        <h4 class="fw_800 boder_bottom_dark pb-2 header">Coversation Panel</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 pb-2">
                        <div class="form-group">
                            <label for="vc_content" class="pb-2 pt-2"><h5>Your comment matters. Discussions are strictly moderated for civility and serenity.</h5></label>
                            <input type="text" class="form-control mb-1" placeholder="Your name" maxlength="120" name="vc_name" id="vc_name">
                            <textarea name="vc_content" maxLength="1500" id="vc_content" class="form-control vc_content" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-2 mt-2 d-flex noselect">
                    <div class="col-md-12 mb-1" id="buttons_container">
                        <button type="submit" class="btn btn-md btn-primary btn-block" id="vc_submit_btn" style="display:none;"><i class="bi bi-save2 bi-center"></i> Save</button>
                        <button type="button" class="btn btn-md btn-block btn-danger" id="vc_close_btn"><i class="bi bi-x-square bi-center text-uppercase"></i> Close</button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="col-md-12 boder_top_dark pt-3 terms_txt">
                            <a href="#"> Terms & Conditions </a> | <a href="#"> Privacy </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- summernote -->
<script src="<?php echo ASSETS_PATH; ?>/vendors/summernote-0.8.18/summernote-lite.min.js"></script>
<script>
    $('.vc_content').summernote({
        tabsize: 2,
        height: 210,
        maxHeight: 230,
        spellCheck: true,
        placeholder: 'Leave your comment on this post...',
        toolbar: [],
        callbacks: {
            onKeydown: function (e) { 
                var t = e.currentTarget.innerText; 
                if (t.trim().length >= 1500) {
                    // show buttons
                    detectInput();
                    //delete keys, arrow keys, copy, cut, select all
                    if (e.keyCode != 8 && !(e.keyCode >=37 && e.keyCode <=40) && e.keyCode != 46 && !(e.keyCode == 88 && e.ctrlKey) && !(e.keyCode == 67 && e.ctrlKey) && !(e.keyCode == 65 && e.ctrlKey)) {
                        e.preventDefault(); 
                    }
                } 
            },
            onKeyup: function (e) {
                // show buttons
                detectInput();
                // trim text at maxlength
                var t = e.currentTarget.innerText;
                $('#vc_content').text(1500 - t.trim().length);
            },
            onPaste: function (e) {
                // show buttons
                detectInput();
                // trim text at maxlength
                var t = e.currentTarget.innerText;
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                var maxPaste = bufferText.length;
                if(t.length + bufferText.length > 1500){
                    maxPaste = 1500 - t.length;
                }
                if(maxPaste > 0){
                    document.execCommand('insertText', false, bufferText.substring(0, maxPaste));
                }
                $('#vc_content').text(1500 - t.length);
            }
        
        },
    });

    function detectInput() {
        var get_comm =  $('div.note-editable').html();
        (get_comm != "") ? $("#vc_submit_btn").show() : $("#vc_submit_btn").hide();
    };

    $(document).on('click', '#vc_close_btn', function(event) {
        event.preventDefault();
        $("#commentFormContainer").remove();
        $('.comment_button_container').show();
    });
</script>