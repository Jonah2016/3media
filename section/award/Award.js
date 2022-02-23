$(document).ready(function() {
    //Multple select field 
    $('.selectpicker02').selectpicker();
    
    function search_load_nominees_data(query = '', query_type = '') {
        $.ajax({
            url: "./fetch_nominees.php",
            method: "POST",
            cache: false,
            data: { query: query, query_type: query_type },
            success: function(data) {
                $("#nominees_data").html(data);
            }
        });
    }
    function search_load_winners_data(query = '', query_type = '') {
        $.ajax({
            url: "./fetch_winners.php",
            method: "POST",
            cache: false,
            data: { query: query, query_type: query_type },
            success: function(data) {
                $("#winners_data").html(data);
            }
        });
    }
    function search_load_performers_data(query = '', query_type = '') {
        $.ajax({
            url: "./fetch_performers.php",
            method: "POST",
            cache: false,
            data: { query: query, query_type: query_type },
            success: function(data) {
                $("#performers_data").html(data);
            }
        });
    }


    // On select match option value to hidden input value
    $('#multi_search_nominees_by_year').change(function() {
        $('#hid_search_by_nominees_year').val($('#multi_search_nominees_by_year').val());
        var query = $('#hid_search_by_nominees_year').val();
        var query_type = "by_nomination_year";
        search_load_nominees_data(query, query_type);
    });

    $('#multi_search_winners_by_year').change(function() {
        $('#hid_search_by_winners_year').val($('#multi_search_winners_by_year').val());
        var query = $('#hid_search_by_winners_year').val();
        var query_type = "by_winner_year";
        search_load_winners_data(query, query_type);
    });
    $('#multi_search_winners_by_cat').change(function() {
        $('#hid_search_by_winners_cat').val($('#multi_search_winners_by_cat').val());
        var query = $('#hid_search_by_winners_cat').val();
        var query_type = "by_winner_category";
        search_load_winners_data(query, query_type);
    });
    $('#multi_search_winners_by_art').change(function() {
        $('#hid_search_by_winners_art').val($('#multi_search_winners_by_art').val());
        var query = $('#hid_search_by_winners_art').val();
        var query_type = "by_winner_artiste";
        search_load_winners_data(query, query_type);
    });
    
    $('#multi_search_performers_by_year').change(function() {
        $('#hid_search_by_performers_year').val($('#multi_search_performers_by_year').val());
        var query = $('#hid_search_by_performers_year').val();
        var query_type = "by_performing_year";
        search_load_performers_data(query, query_type);
    });


})