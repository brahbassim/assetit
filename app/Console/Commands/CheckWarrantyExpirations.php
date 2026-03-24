<?php

namespace App\Console\Commands;

use App\Models\HardwareAsset;
use App\Models\User;
use App\Mail\WarrantyExpiringMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckWarrantyExpirations extends Command
{
    protected $signature = 'warranty:check-expiration {--days=30 : Days before expiration to alert} {--send : Send email notifications}';
    protected $description = 'Check for upcoming warranty expirations and send notifications';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        
        $expiringAssets = HardwareAsset::whereNotNull('warranty_expiry')
            ->where('warranty_expiry', '>', now())
            ->where('warranty_expiry', '<=', now()->addDays($days))
            ->with(['category', 'vendor'])
            ->get();

        $expiredAssets = HardwareAsset::whereNotNull('warranty_expiry')
            ->where('warranty_expiry', '<', now())
            ->where('status', '!=', 'retired')
            ->with(['category', 'vendor'])
            ->get();

        if ($expiringAssets->isEmpty() && $expiredAssets->isEmpty()) {
            $this->info('No warranty alerts found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$expiringAssets->count()} warranties expiring soon and {$expiredAssets->count()} expired warranties.");

        if ($expiredAssets->isNotEmpty()) {
            $this->warn('Expired warranties:');
            foreach ($expiredAssets as $asset) {
                $this->warn("- {$asset->asset_tag} - {$asset->name} (expired on {$asset->warranty_expiry->format('Y-m-d')})");
            }
        }

        if ($expiringAssets->isNotEmpty()) {
            $this->warn('Warranties expiring soon:');
            foreach ($expiringAssets as $asset) {
                $this->warn("- {$asset->asset_tag} - {$asset->name} (expires on {$asset->warranty_expiry->format('Y-m-d')})");
            }
        }

        if ($this->option('send')) {
            $this->sendEmailNotifications($expiredAssets, $expiringAssets);
        } else {
            $this->info('Use --send flag to send email notifications');
        }

        return Command::SUCCESS;
    }

    private function sendEmailNotifications($expiredAssets, $expiringAssets): void
    {
        $admins = User::role('Admin')->get();
        
        if ($admins->isEmpty()) {
            $this->warn('No admin users found to send notifications.');
            return;
        }

        foreach ($admins as $admin) {
            foreach ($expiredAssets as $asset) {
                Mail::to($admin->email)->send(new WarrantyExpiringMail($asset, true));
                $this->info("Sent expired warranty email to {$admin->email} for {$asset->asset_tag}");
            }
            foreach ($expiringAssets as $asset) {
                Mail::to($admin->email)->send(new WarrantyExpiringMail($asset, false));
                $this->info("Sent expiring warranty email to {$admin->email} for {$asset->asset_tag}");
            }
        }
    }
}
