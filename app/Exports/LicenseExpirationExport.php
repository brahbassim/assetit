<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LicenseExpirationExport implements FromCollection, WithHeadings
{
    protected $licenses;
    protected $expired;
    protected $expiringSoon;
    protected $valid;

    public function __construct($licenses, $expired, $expiringSoon, $valid)
    {
        $this->licenses = $licenses;
        $this->expired = $expired;
        $this->expiringSoon = $expiringSoon;
        $this->valid = $valid;
    }

    public function collection()
    {
        return $this->licenses->map(function ($license) {
            $status = $license->isExpired() ? 'Expired' : 
                     ($license->isExpiringSoon(90) ? 'Expiring Soon' : 'Valid');
            
            return [
                'Software Name' => $license->software_name,
                'Vendor' => $license->vendor?->name,
                'Total Seats' => $license->total_seats,
                'Assigned Seats' => $license->assignedSeats(),
                'Expiration Date' => $license->expiration_date?->format('Y-m-d'),
                'Status' => $status,
                'Cost' => $license->cost,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Software Name',
            'Vendor',
            'Total Seats',
            'Assigned Seats',
            'Expiration Date',
            'Status',
            'Cost',
        ];
    }
}
