$(document).ready(function() {

    load_dashbboard_data();
    function load_dashbboard_data() {
         $("#dashboard_container").load('../classes/dashboard_cl/FetchDashboardContent.php');
        // load add modal;
    }


    logoutModalCall(); 
    function logoutModalCall()
    {
        $("#signOut").load("../resources/form-modals/other-modals/logout_modal.php");
    }

    // console.clear();
});