<?php

namespace App\Mail;

use App\Models\HardwareAsset;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WarrantyExpiringMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public HardwareAsset $asset,
        public bool $isExpired = false
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->isExpired 
            ? "Warranty Expired - {$this->asset->asset_tag}"
            : "Warranty Expiring Soon - {$this->asset->asset_tag}";
            
        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.warranty-expiring',
        );
    }
}
