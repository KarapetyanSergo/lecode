<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->markdown('emails.forgot_password')
        ->with('token', $this->token);;
    }
}
