$(document).ready(function() {

    function load_data() {
        $("#voting_data").load('../../classes/awards_cl/FetchVotingData.php');
    }

    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});