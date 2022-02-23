<?php

/**
 *
 */

class GeneralSettingsController extends GeneralSettings
{
    public function getGeneralSettings()
    {
        $reponse = $this->read();
        return $reponse;
        exit();
    }
}
