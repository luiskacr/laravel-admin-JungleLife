<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;


    protected Invoice $invoice;
    protected array $invoiceDetail;

    protected array $client;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice,$invoiceDetail,$client)
    {
        $this->invoice = $invoice;
        $this->invoiceDetail = $invoiceDetail;
        $this->client = $client;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@junglelife.com')
            ->subject(__('app.invoice_subject'))
            ->with([
                'invoice'=> $this->invoice,
                'details' => $this->invoiceDetail,
                'client' => $this->client
            ]);
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'admin.mail.invoice',
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
