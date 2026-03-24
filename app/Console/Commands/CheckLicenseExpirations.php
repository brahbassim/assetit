<?php

namespace App\Console\Commands;

use App\Helpers\LicenseHelper;
use App\Mail\LicenseExpiringMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckLicenseExpirations extends Command
{
    protected $signature = 'licenses:check-expiration {--days=30 : Days before expiration to alert} {--send : Send email notifications}';
    protected $description = 'Check for expiring licenses and send reminders';

    public function handle(): int
    {
        $this->info('Checking license expirations...');

        $expiring90 = LicenseHelper::expiringIn90Days();
        $expiring30 = LicenseHelper::expiringIn30Days();
        $expiring7 = LicenseHelper::expiringIn7Days();
        $expired = LicenseHelper::expiredLicenses();

        $this->info("Found {$expiring90->count()} licenses expiring in 90 days");
        $this->info("Found {$expiring30->count()} licenses expiring in 30 days");
        $this->info("Found {$expiring7->count()} licenses expiring in 7 days");
        $this->info("Found {$expired->count()} expired licenses");

        if ($this->option('send')) {
            $this->sendEmailNotifications($expired, $expiring7, $expiring30);
        } else {
            $this->info('Use --send flag to send email notifications');
        }

        if ($expired->isNotEmpty()) {
            $this->warn('Expired licenses:');
            foreach ($expired as $license) {
                $this->warn("- {$license->software_name} (expired on {$license->expiration_date->format('Y-m-d')})");
            }
        }

        if ($expiring7->isNotEmpty()) {
            $this->warn('Licenses expiring in 7 days:');
            foreach ($expiring7 as $license) {
                $this->warn("- {$license->software_name} (expires on {$license->expiration_date->format('Y-m-d')})");
            }
        }

        if ($expiring30->isNotEmpty()) {
            $this->warn('Licenses expiring in 30 days:');
            foreach ($expiring30 as $license) {
                $this->warn("- {$license->software_name} (expires on {$license->expiration_date->format('Y-m-d')})");
            }
        }

        if ($expiring90->isNotEmpty()) {
            $this->info('Licenses expiring in 90 days:');
            foreach ($expiring90 as $license) {
                $this->info("- {$license->software_name} (expires on {$license->expiration_date->format('Y-m-d')})");
            }
        }

        $this->info('License expiration check completed.');

        return Command::SUCCESS;
    }

    private function sendEmailNotifications($expired, $expiring7, $expiring30): void
    {
        $admins = User::role('Admin')->get();
        
        if ($admins->isEmpty()) {
            $this->warn('No admin users found to send notifications.');
            return;
        }

        $licensesToNotify = $expired->merge($expiring7)->merge($expiring30);

        foreach ($admins as $admin) {
            foreach ($licensesToNotify as $license) {
                $daysUntil = now()->diffInDays($license->expiration_date, false);
                Mail::to($admin->email)->send(new LicenseExpiringMail($license, $daysUntil));
                $this->info("Sent email to {$admin->email} for {$license->software_name}");
            }
        }
    }
}
