<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

class UpdatePaymentMail extends Mailable
{
    use Queueable, SerializesModels;
 public $user;
    protected $invoice;
    // protected $total;
    /**
     * Create a new message instance.
     */
    // public function __construct($invoice, $total)
    // {
    //     $this->invoice = $invoice;
    //     $this->total = $total;
    // }
  public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("Mostafa@gmail.com" , "invoices system"),
            replyTo:[
                new Address("ahmed@gmail.com" , "Support team ahmed"),
            ],
            cc:[
                new Address("supportTeam@blog.com" , "Support team"),
            ],
            subject: 'Update Payment ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.payment',
            with:
            [
            'user' => $this->user,
            // 'invoice' => $this->invoice,
            // 'total' => $this->total,
        ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
