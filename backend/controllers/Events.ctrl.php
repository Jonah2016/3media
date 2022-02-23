<?php

class EventController extends Event
{
    protected $error;
    protected $eve_hashed;
    protected $pay_hash_key;

    public function __construct($data)
    {
        $this->eve_hashed   = $data['eve_hashed'] ?? null;
        $this->pay_hash_key = $data['pay_hash_key'] ?? null;
    }

    public function getEvent()
    {
        if ($this->validateGetSingle() !== null) {
            $msg = $this->validateGetSingle();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->read($this->eve_hashed);
            return $reponse;
            exit();
        }
    }

    public function getAllEvents()
    {
        $reponse = $this->readAll();
        return $reponse;
        exit();
    }

    public function getEventTickets()
    {
        if ($this->validateEventTickets() !== null) {
            $msg = $this->validateEventTickets();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->readEventTickets($this->eve_hashed);
            return $reponse;
            exit();
        }
    }


    public function getTicketPayment()
    {
        if ($this->validateTicketPayment() !== null) {
            $msg = $this->validateTicketPayment();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->readTicketPayments($this->pay_hash_key);
            return $reponse;
            exit();
        }
    }


    private function validateGetSingle()
    {
        if ($this->eve_hashed == "") {
            $this->error = "Cannot retrieve data for this event.";
        }
        return $this->error;
    }

    private function validateEventTickets()
    {
        if ($this->eve_hashed == "") {
            $this->error = "Cannot retrieve tickets data for this event.";
        }
        return $this->error;
    }

    private function validateTicketPayment()
    {
        if ($this->pay_hash_key == "") {
            $this->error = "Invalid request we cannot retrieve tickets data for this QR code.";
        }
        return $this->error;
    }


}
