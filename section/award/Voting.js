// Fetch news and hide
$(document).ready(function() {

    load_voting_data();
    function load_voting_data() {
        var action = 'fetch_voting_data';
        $.ajax({
            url: "./fetch_voting.php",
            method: "POST",
            cache: false,
            data: { 'action': action },
            success: function(data) {
                $("#voting_data").html(data);
            }
        });
    }

    $(document).on('click', '.voteCheckmark', function() {
        let inputId   = $(this).data('id');
        let nomineeId = $(this).data('nominee_id');
        let vote      = document.getElementById(inputId).checked;

        if (vote === true) {
            let yesVote = 1;
            $('#votedFor'+nomineeId).val(yesVote);
        } else {
            let noVote = 0;
            $('#votedFor'+nomineeId).val(noVote);
        }
    });


    async function addVote(formData) {
        await Swal.fire({
            title: 'Are you sure, you want to submit your vote?',
            text: "This action is permanent!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../backend/models/voting.mod.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    (data.code == "404") ? error_operation(data.msg) : success_operation(data.msg);
                    if (data.code == "200") {
                        load_voting_data();
                        document.getElementById("votingForm").reset();
                    }
                })
                .catch(err => {
                    error_operation("Vote could not be submitted successfully.")
                })
            }
        })
    }


    $(document).on('submit', '#votingForm', function(event) {
        event.preventDefault();
        let postData = new FormData(this);
        postData.append('action', 'process_voting');
        addVote(postData);
    });
});