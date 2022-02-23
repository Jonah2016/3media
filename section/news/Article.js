$(document).ready(function() {
    // Load modals
    function load_com_modals() { $("#signup_modal").load('../../frontend/components/SignUpModal.php'); }
    function load_com_data() {
        $("#comment_form_container").load('../../frontend/components/CommentForm.php');
        $('.comment_button_container').show();
        const page_id = $('#page_props').data('xpgkey');; 
        // Ajax call
        $.ajax({
            url: "./fetch_comments.php",
            method: "POST",
            cache: false,
            data: { 'action': 'fetch_comments', 'page_id': page_id },
            success: function(data) {
                $("#comments_data").html(data);
                $(".commentForm").attr("id","comment_form");
                $('.comment_button_container').show();

                // Reset prop div
                $("#page_props").replaceWith('<div id="page_props" style="display:none" data-xpgkey="" data-xpkey="" data-xtype="" ></div>'); 
            }
        });
        return false;
    }
    // Initialize functions
    load_com_modals();
    load_com_data();

    // hide and reveal comment form component
    $(document).on('click', '.comment_button_container', function(event) {
        event.preventDefault();
        const cpkey = $(this).data('cpkey');
        const ctype = $(this).data('ctype');
        const cpgkey = $(this).data('cpgkey');
        // Fill prop values
        $('#page_props').attr('data-xpgkey', cpgkey);
        $('#page_props').attr('data-xpkey', cpkey);
        $('#page_props').attr('data-xtype', ctype);
        // Ajax call component
        $.ajax({
            url: "../../frontend/components/CommentForm.php",
            method: "POST",
            cache: false,
            success: function(data) {
                // Add component
                $("#comment_form_container").html(data);
                $("#commentFormContainer").show();
                $('.comment_button_container').hide();
                $(".commentForm").attr("id","comment_form");
                scrollToCommentSection();
            }
        })
    });
    // Ajax call onclick reply button 
    $(document).on('click', '.reply_btn', function(event) {
        event.preventDefault();
        const rpkey = $(this).data('rpkey');
        const rtype = $(this).data('rtype');
        const rpgkey = $(this).data('rpgkey');
        // Fill prop values
        $('#page_props').attr('data-xpgkey', rpgkey);
        $('#page_props').attr('data-xpkey', rpkey);
        $('#page_props').attr('data-xtype', rtype);

        const rpname = $(this).data('rpname');
        const id = $(this).data('id');
        const component = $('#reply_'+id);
        // Ajax call component
        $.ajax({
            url: "../../frontend/components/CommentForm.php",
            method: "POST",
            cache: false,
            success: function(data) {
                // Init remove component
                $("#commentFormContainer").remove();
                // Append component
                $(component).append(data); 
                $("#commentFormContainer").show();
                $(".header").html('Replying to '+rpname);
                $('.comment_button_container').show();
                $(".commentForm").attr("id","reply_form");
            }
        });
        return false;
    });
    // Scroll to comment section
    function scrollToCommentSection() {
        // scroll to comment div
        $('html,body').animate({ 
            scrollTop: $("#commentFormContainer").offset().top}, 
            'slow'
        );
    }
    // Pass id into hidden inputs
    function postComment(formData, vc_name, vc_content, form_id){
        if (vc_content != "" && vc_name != "") {
            $.ajax({
                url: '../../backend/models/comments.mod.php',
                method: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if (data.code == "200") {
                        const msg = data.msg;
                        success_operation(msg);
                        $("#vc_name").val('');
                        $('.vc_content').summernote('code', '');
                        // close and hide comment form
                        $("#commentFormContainer").hide(); 
                        $(".comm_txt").html('Comment');
                        // load comment
                        load_com_data(); 
                    } else {
                        const msg = data.msg
                        error_operation(msg);
                    }
                }
            });
            return false;
        } else {
            const msg = "All fields are mandatory.";
            error_operation(msg);
        }
    }
    // save comment when is submitted
    $(document).on('submit', '.commentForm', function(event) {
        event.preventDefault();
        const form_id = $(this).attr('id');
        const vc_content = $('#vc_content').val()
        const vc_name = $('#vc_name').val()
        const page_key =  $('#page_props').data('xpgkey');
        const parent_key = $('#page_props').data('xpkey');
        const comment_type = $('#page_props').data('xtype'); 
    
        if (vc_name == '') {
            const msg = "It seems you forgot to input your name.";
            error_operation(msg);
            return false;
        }
        if (vc_content == '') {
            const msg = "Comment content is required";
            error_operation(msg);
            return false;
        }

        var formData = new FormData(this);
        formData.append('action', 'post_comment');
        formData.append('vc_page_hashed', page_key);
        formData.append('vc_parent_hashed', parent_key);
        formData.append('vc_type', comment_type);

        postComment(formData, vc_name, vc_content, form_id) 
    });

});