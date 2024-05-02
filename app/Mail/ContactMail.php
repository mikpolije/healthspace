<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

   
public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Mail',
        );
    }
public function content(): Content
    {
        return new Content(
            view: 'email.contact',
        );
    }
public function attachments(): array
    {
        return [];
    }
public function build()
    {
        return $this->view('email')
                    ->subject('A new Mail')
                    ->from('system@yoursite.com','System')
                    ->with('data',$this->data);
    }  
}