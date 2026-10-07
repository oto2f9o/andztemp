<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable {
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->subject('You have a new message')->markdown('emails.contact', [
            'name' => $this->data['your_name'],
            'email' => $this->data['your_email'],
            'message' => $this->data['your_message'],
        ]);
    }
}
