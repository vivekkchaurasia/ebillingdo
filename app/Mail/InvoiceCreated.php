<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        // Assuming 'emails.invoice' is the correct view path
        return $this->subject('Your Invoice from Devi Offset')
            ->view('emails.invoice')
            ->with([
                'invoice' => $this->invoice,
            ]);
    }

    // Remove or correct the content method if not needed
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',  // Correct the view path here
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
