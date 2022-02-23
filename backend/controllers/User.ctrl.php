<?php

class SubscriptionController extends Subscription
{
    protected $error;
    protected $subs_ip;
    protected $subscribe_email;

    public function __construct($data)
    {
        $this->subs_ip         = $data['subs_ip'] ?? null;
        $this->subscribe_email = $data['subscribe_email'] ?? null;
    }

    public function processSubscription()
    {
        if ($this->validateProcessSubscription() !== null) {
            $msg = $this->validateProcessSubscription();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->process($this->subs_ip, $this->subscribe_email);
            return $reponse;
            exit();
        }
    }


    private function validateProcessSubscription()
    {
        if ($this->subscribe_email == '' || $this->subscribe_email == null) {
            $this->error = "Sorry, your valid email is required to subscribe to our newsletter";
        }
        elseif ($this->subscribe_email != null && strlen($this->subscribe_email) > 80) {
            $this->error = "Your email is too long. Should be maximum of 80 characters";
        }
        if(!filter_var($this->subscribe_email, FILTER_VALIDATE_EMAIL)) {
            $this->error = "Invalid email format";
        }

        return $this->error;
    }
}


class TicketPaymentController extends TicketPayment
{
    protected $error;
    protected $pay_hash_key;
    protected $pay_fname;
    protected $pay_lname;
    protected $pay_email;
    protected $pay_phone;
    protected $pay_location;
    protected $event_hash;
    protected $ticket_name;

    public function __construct($data)
    {
        $this->pay_hash_key = $data['pay_hash_key'] ?? null;
        $this->pay_fname    = $data['pay_fname'] ?? null;
        $this->pay_lname    = $data['pay_lname'] ?? null;
        $this->pay_email    = $data['pay_email'] ?? null;
        $this->pay_phone    = $data['pay_phone'] ?? null;
        $this->pay_location = $data['pay_location'] ?? null;
        $this->event_hash   = $data['event_hash'] ?? null;
        $this->ticket_name  = $data['ticket_name'] ?? null;
    }

    public function addUserPaymentDetails()
    {
        if ($this->validateProcessSubscription() !== null) {
            $msg = $this->validateProcessSubscription();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->write($this->pay_hash_key, $this->pay_fname, $this->pay_lname, $this->pay_email, $this->pay_phone, $this->pay_location, $this->event_hash, $this->ticket_name);
            return $reponse;
            exit();
        }
    }

    private function validateProcessSubscription()
    {

        if ($this->pay_fname == null && $this->pay_lname == null && $this->pay_email == null && $this->pay_phone == null) {
            $this->error = "All fields are mandatory";
        }
        elseif ($this->pay_fname == null || $this->pay_fname == "") {
            $this->error = "Your first name is required";
        }
        elseif (($this->pay_fname != null && $this->pay_fname != "") && strlen($this->pay_fname) > 30) {
            $this->error = ($this->pay_fname != null && $this->pay_fname != "") && $this->pay_fname > 30;
        }
        elseif ($this->pay_lname == null || $this->pay_lname == "") {
            $this->error = "Your last name is required";
        }
        elseif ($this->pay_lname != null &&  strlen($this->pay_lname) > 30) {
            $this->error = "Your last name is too long. Should be maximum of 30 characters.";
        }
        elseif ($this->pay_email == "" || $this->pay_email == null) {
            $this->error = "Your valid email is required to proceed to checkout.";
        }
        elseif ($this->pay_email != null &&  strlen($this->pay_email) > 80) {
            $this->error = "Your email is too long. Should be maximum of 80 characters.";
        }
        elseif(!filter_var($this->pay_email, FILTER_VALIDATE_EMAIL)) {
            $this->error = "Invalid email format";
        }
        elseif ($this->pay_phone == null || $this->pay_phone == "") {
            $this->error = "Your active phone number is required.";
        }
        elseif ($this->pay_phone != null &&  strlen($this->pay_phone) > 15) {
            $this->error = "Your phone number is too long. Should be maximum of 15 characters.";
        }
        elseif ($this->event_hash == null || $this->event_hash == "") {
            $this->error = "Something went wrong please reselect the ticket again.";
        }
        elseif ($this->event_hash == null || $this->event_hash == "") {
            $this->error = "Something went wrong please reselect the ticket again.";
        }

        return $this->error;
    }
}