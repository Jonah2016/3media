<?php

class NewsController extends News
{
    protected $error;
    protected $news_id;
    protected $news_hashed;
    protected $news_category;
    protected $already_displayed_ids;
    protected $search_param;
    protected $ncom_parent_hashed;

    public function __construct($data)
    {
        $this->news_id               = $data['news_id'] ?? null;
        $this->news_hashed           = $data['news_hashed'] ?? null;
        $this->news_category         = $data['news_category'] ?? null;
        $this->already_displayed_ids = $data['already_displayed_ids'] ?? null;
        $this->search_param          = $data['search_param'] ?? null;
        $this->ncom_parent_hashed    = $data['ncom_parent_hashed'] ?? null;
    }

    public function getNews()
    {
        if ($this->validateGetSingle() !== null) {
            $msg = $this->validateGetSingle();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->news_hashed);
            return $reponse;
            exit();
        }
    }

    public function getAllFeaturedNews()
    {
        $reponse = $this->readAllFeaturedNews();
        return $reponse;
        exit();
    }

    public function getFeaturedNewsByCategory()
    {
        if ($this->validateFeaturedNewsCategory() !== null) {
            $msg = $this->validateFeaturedNewsCategory();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->readFeaturedNewsByCategory($this->already_displayed_ids, $this->news_category);
            return $reponse;
            exit();
        }
    }

    public function getAllNews()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }

    public function getAllNewsByCategory()
    {
        if ($this->validateNewsCategory() !== null) {
            $msg = $this->validateNewsCategory();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->readAllByCategory($this->already_displayed_ids, $this->news_category);
            return $reponse;
            exit();
        }
    }

    public function getNewsComments()
    {
        if ($this->validateNewsComments() !== null) {
            $msg = $this->validateNewsComments();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->readComments($this->search_param);
            return $reponse;
            exit();
        }
    }

    public function getNewsReplies()
    {
        $reponse = $this->readReplies($this->ncom_parent_hashed);
        return $reponse;
        exit();
    }


    private function validateGetSingle()
    {
        if ($this->news_hashed == "") {
            $this->error = "Cannot retrieve data for this news.";
        }
        return $this->error;
    }

    private function validateNewsCategory()
    {
        if ($this->already_displayed_ids == "" && $this->news_category == "") {
            $this->error = "Cannot retrieve data for this news category. A category or IDs are required.";
        }
        return $this->error;
    }

    private function validateFeaturedNewsCategory()
    {
        if ($this->already_displayed_ids == "" && $this->news_category == "") {
            $this->error = "Cannot retrieve data for this featured news category. A category or IDs are required.";
        }
        return $this->error;
    }

    private function validateNewsComments()
    {
        if ($this->search_param == "") {
            $this->error = "Be the first to comment on this post.";
        }
        return $this->error;
    }

}
