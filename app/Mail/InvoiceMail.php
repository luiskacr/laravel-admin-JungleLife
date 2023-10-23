<?php

namespace App\Mail;

use App\Models\Configuration;
use App\Models\Invoice;
use App\Models\Tour;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;


    protected Invoice $invoice;

    protected Tour $tour;
    protected array $invoiceDetail;

    protected array $client;

    protected Collection $configurations;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice,$invoiceDetail,$client, $tour)
    {
        $this->invoice = $invoice;
        $this->invoiceDetail = $invoiceDetail;
        $this->client = $client;
        $this->configurations = Configuration::all();
        $this->tour = $tour;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->from('noreply@junglelife.com')
            ->subject(__('app.invoice_subject'))
            ->with([
                'invoice'=> $this->invoice,
                'details' => $this->invoiceDetail,
                'client' => $this->client,
                'configurations' => $this->configurations,
                'tour' => $this->tour,
            ]);
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content():Content
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
    public function attachments():array
    {
        return [];
    }
}
