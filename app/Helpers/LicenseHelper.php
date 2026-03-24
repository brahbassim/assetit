<?php

namespace App\Helpers;

use App\Models\SoftwareLicense;
use Carbon\Carbon;

class LicenseHelper
{
    public static function expiringLicenses(int $days = 30)
    {
        return SoftwareLicense::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [Carbon::now(), Carbon::now()->addDays($days)])
            ->where('expiration_date', '>=', Carbon::now())
            ->get();
    }

    public static function expiringIn90Days()
    {
        return self::expiringLicenses(90);
    }

    public static function expiringIn30Days()
    {
        return self::expiringLicenses(30);
    }

    public static function expiringIn7Days()
    {
        return self::expiringLicenses(7);
    }

    public static function expiredLicenses()
    {
        return SoftwareLicense::whereNotNull('expiration_date')
            ->where('expiration_date', '<', Carbon::now())
            ->get();
    }

    public static function getExpirationStatus(SoftwareLicense $license): string
    {
        if (!$license->expiration_date) {
            return 'perpetual';
        }

        if ($license->isExpired()) {
            return 'expired';
        }

        if ($license->isExpiringSoon(7)) {
            return 'critical';
        }

        if ($license->isExpiringSoon(30)) {
            return 'warning';
        }

        if ($license->isExpiringSoon(90)) {
            return 'notice';
        }

        return 'valid';
    }
}
