<?php

namespace App\Mail;

use App\Newsletter;
use App\Anunturi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendingNewsletters extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($textNewsletter, $userName, $titluEmail)
    {
        $this->textNewsletter = $textNewsletter;
        $this->userName       = $userName;
        $this->titluEmail     = $titluEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        //return $this->view('view.newsletter');
        //return view('backend.contul-meu', compact('user_logat_r'));
        
        return $this->view('emails.newsletter-template')
                    ->subject($this->titluEmail)
                    ->with([
                        'textNewsletter'    => $this->textNewsletter,
                        'userName'          => $this->userName,
                        'titluEmail'        => $this->titluEmail,
                    ]);
        
        //return view('emails.newsletter-template', compact('textNewsletter', 'userName'));
    }
}
