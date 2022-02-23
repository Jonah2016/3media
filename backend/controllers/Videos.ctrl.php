<?php

class VideoController extends Video
{
    protected $error;
    protected $vid_id;
    protected $vid_hashed;
    protected $vid_category;
    protected $already_displayed_ids;

    public function __construct($data)
    {
        $this->vid_id                = $data['vid_id'] ?? null;
        $this->vid_hashed            = $data['vid_hashed'] ?? null;
        $this->vid_category          = $data['vid_category'] ?? null;
        $this->already_displayed_ids = $data['already_displayed_ids'] ?? null;
    }

    public function getVideo()
    {
        if ($this->validateGetSingle() !== null) {
            $msg = $this->validateGetSingle();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->vid_hashed);
            return $reponse;
            exit();
        }
    }

    public function getAllVideosByCategory()
    {
        if ($this->validateVideosCategory() !== null) {
            $msg = $this->validateVideosCategory();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->readAllByCategory($this->already_displayed_ids, $this->vid_category);
            return $reponse;
            exit();
        }
    }

    public function getAllVideos()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }

    private function validateGetSingle()
    {
        if ($this->vid_hashed == "") {
            $this->error = "Cannot retrieve data for this video.";
        }
        return $this->error;
    }

    private function validateVideosCategory()
    {
        if ($this->already_displayed_ids == "" && $this->vid_category == "") {
            $this->error = "Cannot retrieve data for this video category. An ID or Category atleast is required.";
        }
        return $this->error;
    }
}
