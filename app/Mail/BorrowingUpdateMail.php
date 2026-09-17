<?php

namespace App\Mail;

use App\Models\Borrowing;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class BorrowingUpdateMail extends Mailable
{
    public function __construct(public Borrowing $borrowing, public string $event) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'MMACI Library: '.match ($this->event) {
            'approved' => 'Your borrowing request is approved',
            'rejected' => 'Update on your borrowing request',
            'due' => 'Your book is due today',
            'overdue' => 'Your book is overdue',
        });
    }

    public function content(): Content
    {
        return new Content(view: 'emails.borrowing-update');
    }
}
