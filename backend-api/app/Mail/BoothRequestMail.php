<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BoothRequestMail extends Mailable
{
    use Queueable, SerializesModels;
        public $boothName;
    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, $boothName)
    {
        //
        $this -> boothName = $boothName;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Exhibition Booth Request of '. $this->boothName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.subscription.bootRequestMail',
            with: [
                'boothName' => $this->boothName,
                'user' => $this->user,
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
