<?php

namespace App\Mail;

use App\Models\SoftwareLicense;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LicenseExpiringMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SoftwareLicense $license,
        public int $daysUntilExpiration
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "License Expiring Soon - {$this->license->software_name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.license-expiring',
        );
    }
}
