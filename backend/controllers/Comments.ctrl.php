<?php

    class CommentController extends Comment
    {
        protected $error;
        protected $ncom_page_hashed;
        protected $ncom_type;
        protected $ncom_country;
        protected $ncom_post_hashed;
        protected $ncom_parent_hashed;
        protected $ncom_name;
        protected $ncom_content;

        public function __construct($data)
        {
            $this->ncom_page_hashed   = $data['ncom_page_hashed'] ?? null;
            $this->ncom_type          = $data['ncom_type'] ?? null;
            $this->ncom_country       = $data['ncom_country'] ?? null;
            $this->ncom_post_hashed   = $data['ncom_post_hashed'] ?? null;
            $this->ncom_parent_hashed = $data['ncom_parent_hashed'] ?? null;
            $this->ncom_name          = $data['ncom_name'] ?? null;
            $this->ncom_content       = $data['ncom_content'] ?? null;
        }

        public function addComment()
        {
            if ($this->validateAdd() !== null) {
                $msg = $this->validateAdd();
                return ['code'=>404, 'msg'=>$msg];
                exit();
            } else {
                $reponse = $this->write($this->ncom_page_hashed, $this->ncom_type, $this->ncom_country, $this->ncom_post_hashed, $this->ncom_parent_hashed, $this->ncom_name, $this->ncom_content);
                return $reponse;
                exit();
            }
        }

        public function getComment()
        {
            if ($this->validateGet() !== null) {
                $msg = $this->validateGet();
                return ['code'=>404, 'msg'=>$msg];
                exit();
            } else {
                $reponse = $this->read($this->ncom_page_hashed);
                return $reponse;
                exit();
            }
        }

        private function validateAdd()
        {
            if ($this->ncom_name == "") {
                $this->error = "It seems you forgot to input your name.";
            }
            elseif ($this->ncom_content == "") {
                $this->error = "Comment content is required.";
            }

            return $this->error;
        }

        private function validateGet()
        {
            if ($this->ncom_page_hashed == "") {
                $this->error = "Cannot retrieve data for this comment.";
            }
            return $this->error;
        }
    }