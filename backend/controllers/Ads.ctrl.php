<?php

class AdsController extends Ads
{
    protected $error;
    protected $adverts_id;
    protected $date_now;
    protected $adverts_category;
    protected $adverts_dimension;
    protected $adverts_type;

    public function __construct($data)
    {
        $this->adverts_id        = $data['adverts_id'] ?? null;
        $this->date_now          = $data['date_now'] ?? null;
        $this->adverts_category  = $data['adverts_category'] ?? null;
        $this->adverts_dimension = $data['adverts_dimension'] ?? null;
        $this->adverts_type      = $data['adverts_type'] ?? null;
    }

    public function getAd()
    {
        if ($this->validateGetSingle() !== null) {
            $msg = $this->validateGetSingle();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->adverts_id);
            return $reponse;
            exit();
        }
    }

    public function getAdByParams()
    {
        if ($this->validateAdByParams() !== null) {
            $msg = $this->validateAdByParams();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->readAdByParam($this->date_now, $this->adverts_category, $this->adverts_dimension, $this->adverts_type);
            return $reponse;
            exit();
        }
    }

    public function getAllAds()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }

    private function validateGetSingle()
    {
        if ($this->adverts_id == "") {
            $this->error = "Cannot retrieve data for this advertisement.";
        }
        return $this->error;
    }

    private function validateAdByParams()
    {
        if ($this->date_now == "") {
            $this->error = "Date now parameter is required.";
        }
        if ($this->adverts_category == "") {
            $this->error = "Ad category parameter is required.";
        }
        if ($this->adverts_dimension == "") {
            $this->error = "Ad dimension parameter is required.";
        }
        if ($this->adverts_type == "") {
            $this->error = "Ad type parameter is required.";
        }
        return $this->error;
    }


}
