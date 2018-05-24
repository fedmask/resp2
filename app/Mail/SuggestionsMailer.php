<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Input;

class SuggestionsMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Identifica il nome dell'utente che sta
     * inviando il suggerimento.
     *
     * @var Name
     */
    public $name;

    /**
     * Identifica la mail dell'utente che sta
     * inviando il suggerimento.
     *
     * @var Mail
     */
    public $mail;

    /**
     * Identifica il messaggio dell'utente che sta
     * inviando il suggerimento.
     *
     * @var Messaggio
     */
    public $bodyMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->name = Input::get('nome');
        $this->mail = Input::get('mail');
        $this->bodyMessage = Input::get('contentMail');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Input::get('mail'))
                    ->view('mail.suggestions')
                    ->subject('Nuovo Suggerimento')
                    ->with(['mail' =>  $this->mail,
                            'name' => $this->name,
                            'bodyMessage' => $this->bodyMessage]);
    }
}
