<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThanksTour extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $thanksMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $thanksMessage)
    {
        $this->name = $name;
        $this->thanksMessage = $thanksMessage;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->from('noreply@junglelife.com')
            ->subject(__('app.approve_mail_title'))
            ->with('greetings', __('app.Hello', ['object' => $this->name]))
            ->with('thanksMessage', $this->thanksMessage);
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content():Content
    {
        return new Content(
            view: 'admin.mail.thanks',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
