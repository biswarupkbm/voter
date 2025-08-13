<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;

    // Constructor
    public function __construct($otp, $name)
    {
        $this->otp = $otp;
        $this->name = $name;
    }

    // Build the email
    public function build()
    {
        return $this->subject('Your OTP Verification Code')
                    ->view('emails.send-otp'); // Blade view for email
    }
}