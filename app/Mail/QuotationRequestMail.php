<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $fields;

    public function __construct($data, $fields)
    {
        $this->data = $data;
        $this->fields = $fields;
    }

    public function build()
    {
        return $this->subject('Quotation Request')
                    ->view('emails.quotation-request');
    }
}
