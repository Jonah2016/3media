<?php

require('../core/Auth.php');
require_once(BACKEND_ROOT_PATH . 'classes/GeneralSettings.cl.php');
require_once(BACKEND_ROOT_PATH . 'controllers/GeneralSettings.ctrl.php');

if (isset($_POST['action']) && htmlspecialchars($_POST['action'], ENT_QUOTES) == "get_general_settings") {
    $general_settings = new GeneralSettingsController(null);
    $result = $general_settings->getGeneralSettings();

    echo json_encode($result);
    exit();
}
