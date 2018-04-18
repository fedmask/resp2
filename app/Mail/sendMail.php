<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paz, $ogg, $testo)
    {
        $this->paz = $paz;
        $this->subject = $ogg;
        $this->body = $testo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->paz)
        ->view('mail.sendmail')
        ->subject($this->subject)
        ->with(['bodyMessage' => $this->body]);
    }
}
