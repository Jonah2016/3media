$(document).ready(function() {

    function load_data() {
        $("#tickets_data").load('../../classes/events_cl/FetchPaymentData.php');
    }

    // Call functions
    load_data();
    logoutModalCall();

    function logoutModalCall() {
        $("#signOut").load("../../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});