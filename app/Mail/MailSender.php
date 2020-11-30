<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSender extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct($student)
    {
        //
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail')->with([
                    'verification_code'=> $this->student->verification_code,
                    'username'=> $this->student->username
                    ])->subject('Email Verification')
                      ->from('alumni.mech.jntuacep@gmail.com','alumni mech jntuacep');

    }
}
