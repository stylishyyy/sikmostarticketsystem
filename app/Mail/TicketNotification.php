<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $messageBody;

    public function __construct($ticket, $messageBody)
    {
        $this->ticket = $ticket;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this->subject('Obavijest: Kvar #' . $this->ticket->id . ' - ' . $this->ticket->title)
                    ->view('emails.ticket_notification');
    }
}