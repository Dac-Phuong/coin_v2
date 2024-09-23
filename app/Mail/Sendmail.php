<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Sendmail extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    public function build()
    {
        return $this->from('nguyendacphuong11@gmail.com')
            ->subject('Test Email')
            ->view('sendMail.index'); 
    }
}
