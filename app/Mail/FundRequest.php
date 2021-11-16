<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FundRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request, $transaction;

    public function __construct($request, $transaction)
    {
        $this->request      = $request;
        $this->transaction  = $transaction;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.fund-request-updates')
        ->with([
            'request'       => $this->request,
            'transaction'   => $this->transaction
        ]);
    }
}
