<?php

    require('../core/Auth.php');
    require_once(BACKEND_ROOT_PATH . 'classes/Awards.cl.php');
    require_once(BACKEND_ROOT_PATH . 'controllers/Awards.ctrl.php');


    // ================================= AWARDS - CATEGORIES =======================================

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_award_category") {
        $awc_id           = htmlspecialchars(strip_tags(trim($_POST['awc_id'])), ENT_QUOTES);
        $award_categories = new AwardCategoryController(['awc_id' => $awc_id]);
        $result           = $award_categories->getAwardCategory();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_award_categories") {
        $award_categories = new AwardCategoryController(null);
        $result           = $award_categories->getAllAwardCategories();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_award_category_by_yr") {
        $awc_year = htmlspecialchars(strip_tags(trim($_POST['awc_year'])), ENT_QUOTES);
        $award_categories = new AwardCategoryController([
            'awc_year' => $awc_year
        ]);
        $result = $award_categories->getAllAwardCategoriesByYear();

        echo json_encode($result);
        exit();
    }



    // ================================= AWARDS - NOMINEES =======================================

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_nominee") {
        $awn_id    = htmlspecialchars(strip_tags(trim($_POST['awn_id'])), ENT_QUOTES);
        $nominee = new NomineeController(['awn_id' => $awn_id]);
        $result     = $nominee->getNominee();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_nominees") {
        $nominee = new NomineeController(null);
        $result     = $nominee->getAllNominees();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_nominees_by_cat_yr") {
        $param        = htmlspecialchars(strip_tags(trim($_POST['param'])), ENT_QUOTES);
        $awn_category = htmlspecialchars(strip_tags(trim($_POST['awn_category'])), ENT_QUOTES);
        $query_type   = htmlspecialchars(strip_tags(trim($_POST['query_type'])), ENT_QUOTES);
        $nominee = new NomineeController([
            'param'        => $param,
            'awn_category' => $awp_category,
            'query_type'   => $query_type
        ]);
        $result = $nominee->getAllNomineesByCatYear();

        echo json_encode($result);
        exit();
    }

    // ================================= AWARDS - WINNERS =======================================

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_winner") {
        $awn_id = htmlspecialchars(strip_tags(trim($_POST['awn_id'])), ENT_QUOTES);
        $winner = new WinnerController(['awn_id' => $awn_id]);
        $result = $winner->getWinner();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_winners") {
        $winner = new WinnerController(null);
        $result = $winner->getAllWinners();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_winners_by_cat_yr") {
        $param        = htmlspecialchars(strip_tags(trim($_POST['param'])), ENT_QUOTES);
        $awn_category = htmlspecialchars(strip_tags(trim($_POST['awn_category'])), ENT_QUOTES);
        $query_type   = htmlspecialchars(strip_tags(trim($_POST['query_type'])), ENT_QUOTES);
        $winner = new WinnerController([
            'param'        => $param,
            'awn_category' => $awn_category,
            'query_type'   => $query_type
        ]);
        $result = $winner->getAllWinnersByCatYear();

        echo json_encode($result);
        exit();
    }



    // ================================= AWARDS - PERFORMERS =======================================

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_performer") {
        $s_cat_id  = htmlspecialchars(strip_tags(trim($_POST['s_cat_id'])), ENT_QUOTES);
        $performer = new PerformerController(['s_cat_id' => $s_cat_id]);
        $result    = $performer->getPerformer();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_all_performers") {
        $performer = new PerformerController(null);
        $result    = $performer->getAllPerformers();

        echo json_encode($result);
        exit();
    }

    if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_performers_by_cat_yr") {
        $param        = htmlspecialchars(strip_tags(trim($_POST['param'])), ENT_QUOTES);
        $awn_category = htmlspecialchars(strip_tags(trim($_POST['awp_category'])), ENT_QUOTES);
        $query_type   = htmlspecialchars(strip_tags(trim($_POST['query_type'])), ENT_QUOTES);
        $performer = new PerformerController([
            'param'        => $param,
            'awp_category' => $awp_category,
            'query_type'   => $query_type
        ]);
        $result = $performer->getAllPerformersByCatYear();

        echo json_encode($result);
        exit();
    }

