<?php

class PaymentController extends Payment
{
    protected $error;
    protected $rid; 
    protected $pay_fname;
    protected $pay_lname;
    protected $pay_email;
    protected $pay_phone;
    protected $pay_location; 
    protected $cart_data;
    // protected $ref;
    // protected $otp;

    public function __construct($data)
    {
        $this->rid          = $data['rid'] ?? null;
        $this->pay_fname    = $data['pay_fname'] ?? null;
        $this->pay_lname    = $data['pay_lname'] ?? null;
        $this->pay_email    = $data['pay_email'] ?? null;
        $this->pay_phone    = $data['pay_phone'] ?? null;
        $this->pay_location = $data['pay_location'] ?? null;
        $this->cart_data    = $data['cart_data'] ?? null;
        // $this->ref          = $data['ref'] ?? null;
        // $this->otp          = $data['otp'] ?? null;
    }

    public function processPayment()
    {
        if ($this->validateProcessPayment() !== null) {
            $msg = $this->validateProcessPayment();
            return ['code'=>404, 'msg'=>$msg];
            exit();
        } else {
            $reponse = $this->process($this->rid, $this->pay_fname, $this->pay_lname, $this->pay_email, $this->pay_phone, $this->pay_location, $this->cart_data);
            return $reponse;
            exit();
        }
    }

    // public function verifyOtp()
    // {
    //     if ($this->validateOTP() !== null) {
    //         $msg = $this->validateOTP();
    //         return ['code'=>404, 'msg'=>$msg];
    //         exit();
    //     } else {
    //         $reponse = $this->verify($this->ref, $this->otp, $this->cart_data);
    //         return $reponse;
    //         exit();
    //     }
    // }

    private function validateProcessPayment()
    {
        if ($this->pay_fname == null && $this->pay_lname == null && $this->pay_email == null && $this->pay_phone == null) {
            $this->error = "All fields are mandatory";
        }
        elseif ($this->pay_fname == null || $this->pay_fname == "") {
            $this->error = "Your first name is required";
        }
        elseif (($this->pay_fname != null) && strlen($this->pay_fname) > 30) {
            $this->error = "Your first name is too long. Should be maximum of 30 characters.";
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
        elseif ($this->pay_phone != null &&  strlen($this->pay_phone) > 10) {
            $this->error = "Your phone number is too long. Should be maximum of 10 characters.";
        }
        elseif ($this->cart_data == null || empty($this->cart_data)) {
            $this->error = "Something went wrong. The system detected 0 items in your cart. Refresh the page or try again.";
        }

        return $this->error;
    }


    // private function validateOTP()
    // {
    //     if ($this->ref == null || $this->ref == "") {
    //         $this->error = "We cannot verify your otp request at the moment. Try again later";
    //     }
    //     elseif ($this->otp == null || $this->otp == "") {
    //         $this->error = "Please enter OTP code you received.";
    //     }

    //     return $this->error;
    // }
}