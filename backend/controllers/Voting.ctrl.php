<?php

class VotingController extends Voting
{
    protected $error;
    protected $name1;
    protected $name2;
    protected $name3;
    protected $name4;
    protected $tokenValue;
    protected $SessionExpire;
    protected $allowed_countries;
    protected $ip;
    protected $locationData;
    protected $countryName;
    protected $countryCode;
    protected $countryPhoneCode;
    protected $countryRegion;
    protected $awvs_nominee_id;
    protected $awvs_category_id;
    protected $voted_for;

    public function __construct($data)
    {
        $this->name1             = $data['name1'] ?? null;
        $this->name2             = $data['name2'] ?? null;
        $this->name3             = $data['name3'] ?? null;
        $this->name4             = $data['name4'] ?? null;
        $this->tokenValue        = $data['tokenValue'] ?? null;
        $this->SessionExpire     = $data['SessionExpire'] ?? null;
        $this->allowed_countries = $data['allowed_countries'] ?? null;
        $this->ip                = $data['ip'] ?? null;
        $this->locationData      = $data['locationData'] ?? null;
        $this->countryName       = $data['countryName'] ?? null;
        $this->countryCode       = $data['countryCode'] ?? null;
        $this->countryPhoneCode  = $data['countryPhoneCode'] ?? null;
        $this->countryRegion     = $data['countryRegion'] ?? null;
        $this->awvs_nominee_id   = $data['awvs_nominee_id'] ?? null;
        $this->awvs_category_id  = $data['awvs_category_id'] ?? null;
        $this->voted_for         = $data['voted_for'] ?? null;
    }

    public function processVoting()
    {
        if ($this->validateProcessVote() !== null) {
            $msg = $this->validateProcessVote();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->process($this->name1, $this->name2, $this->name3, $this->name4, $this->tokenValue, $this->SessionExpire, $this->allowed_countries, $this->ip, $this->locationData, $this->countryName, $this->countryCode, $this->countryPhoneCode, $this->countryRegion, $this->awvs_nominee_id, $this->awvs_category_id, $this->voted_for);
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

    private function validateProcessVote()
    {
        if ($this->ip == "") {
            $this->error = "Voting could not be processed due to an unknow error. Please try again later";
            return $this->error;
        }
        if (empty($this->locationData)) {
            $this->error = "Voting could not be processed due to an unknow error. Please try again later";
            return $this->error;
        }
        if (empty($this->countryName)) {
            $this->error = "Voting could not be processed due to an unknow error. Please try again later";
            return $this->error;
        }
        if (empty($this->countryCode)) {
            $this->error = "Voting could not be processed due to an unknow error. Please try again later";
            return $this->error;
        }
        if (empty($this->awvs_nominee_id)) {
            $this->error = "Voting could not be processed due to an unknow error. Please try again later";
            return $this->error;
        }
        if (empty($this->awvs_category_id)) {
            $this->error = "Voting could not be processed due to an unknow error. Please try again later";
            return $this->error;
        }
        if (empty($this->voted_for)) {
            $this->error = "Voting could not be processed due to an unknow error. Please try again later";
            return $this->error;
        }

        // Check duplicates
        $duplicates_array = [];
        $total_categories = count($this->awvs_category_id);
        if($total_categories > 1) {
            for($i=0; $i < $total_categories; $i++)
            {
                $vfor = $this->voted_for[$i];
                if ($vfor == 1) { array_push($duplicates_array, $this->awvs_category_id[$i]); }
            }
        }

        $dup_name_arr = [];
        // Instantiate classes
        $global_class = new GlobalFunctions(null);
        $utils_class  = new UtilsLibrary(null);
        $dup_vote = $global_class->returnDuplicates($duplicates_array);
        if(count($dup_vote) > 0){
            foreach ($dup_vote as $key => $value) {
                $dup_name = $utils_class->getAwardCategoryName($value);
                array_push($dup_name_arr, $dup_name);
            }
        }
        $dup_vals = implode(", ", $dup_name_arr);
        if (!empty($dup_vote)) { $this->error = "You have voted for multiple people in category: [".$dup_vals."]."; }

        return $this->error;
    }
}