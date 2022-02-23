<?php

class AwardCategoryController extends AwardCategory
{
    protected $error;
    protected $awc_id;
    protected $awc_year;

    public function __construct($data)
    {
        $this->awc_id   = $data['awc_id'] ?? null;
        $this->awc_year = $data['awc_year'] ?? null;
    }

    public function getAwardCategory()
    {
        if ($this->validateGet() !== null) {
            $msg = $this->validateGet();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->awc_id);
            return $reponse;
            exit();
        }
    }

    public function getAllAwardCategories()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }

    public function getAllAwardCategoriesByYear()
    {
        $reponse = $this->readAllByYear($this->awc_year);
        return $reponse;
        exit();
    }

    private function validateGet()
    {
        if ($this->awc_id == "") {
            $this->error = "Cannot retrieve data for this award category.";
        }
        return $this->error;
    }
}

class NomineeController extends AwardNominee
{
    protected $error;
    protected $awn_id;
    protected $param;
    protected $awn_category;
    protected $query_type;

    public function __construct($data)
    {
        $this->awn_id       = $data['awn_id'] ?? null;
        $this->param        = $data['param'] ?? null;
        $this->awn_category = $data['awn_category'] ?? null;
        $this->query_type   = $data['query_type'] ?? null;
    }

    public function getNominee()
    {
        if ($this->validateGet() !== null) {
            $msg = $this->validateGet();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->awn_id);
            return $reponse;
            exit();
        }
    }

    public function getAllNomineesByCatYear()
    {
        $reponse = $this->readAllByCatYear($this->param, $this->awn_category, $this->query_type);
        return $reponse;
        exit();
    }

    public function getAllNominees()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }

    private function validateGet()
    {
        if ($this->awn_id == "") {
            $this->error = "Cannot retrieve data for this nominee.";
        }
        return $this->error;
    }
}

class WinnerController extends AwardWinner
{
    protected $error;
    protected $awn_id;
    protected $param;
    protected $awn_category;
    protected $query_type;

    public function __construct($data)
    {
        $this->awn_id       = $data['awn_id'] ?? null;
        $this->param        = $data['param'] ?? null;
        $this->awn_category = $data['awn_category'] ?? null;
        $this->query_type   = $data['query_type'] ?? null;
    }

    public function getWinner()
    {
        if ($this->validateGet() !== null) {
            $msg = $this->validateGet();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->awn_id);
            return $reponse;
            exit();
        }
    }

    public function getAllWinnersByCatYear()
    {
        $reponse = $this->readAllByCatYear($this->param, $this->awn_category, $this->query_type);
        return $reponse;
        exit();
    }

    public function getAllWinners()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }
    
    private function validateGet()
    {
        if ($this->awn_id == "") {
            $this->error = "Cannot retrieve data for this winner.";
        }
        return $this->error;
    }
}

class PerformerController extends AwardPerformer
{
    protected $error;
    protected $awp_id;
    protected $param;
    protected $awp_category;
    protected $query_type;

    public function __construct($data)
    {
        $this->awp_id       = $data['awp_id'] ?? null;
        $this->param        = $data['param'] ?? null;
        $this->awp_category = $data['awp_category'] ?? null;
        $this->query_type   = $data['query_type'] ?? null;
    }

    public function getPerformer()
    {
        if ($this->validateGet() !== null) {
            $msg = $this->validateGet();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->awp_id);
            return $reponse;
            exit();
        }
    }

    public function getAllPerformersByCatYear()
    {
        $reponse = $this->readAllByCatYear($this->param, $this->awp_category, $this->query_type);
        return $reponse;
        exit();
    }

    public function getAllPerformers()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }

    private function validateGet()
    {
        if ($this->awp_id == "") {
            $this->error = "Cannot retrieve data for this peformer.";
        }
        return $this->error;
    }
}


