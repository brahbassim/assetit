<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LicenseUtilizationExport implements FromCollection, WithHeadings
{
    protected $licenses;

    public function __construct($licenses)
    {
        $this->licenses = $licenses;
    }

    public function collection()
    {
        return $this->licenses->map(function ($license) {
            return [
                'Software Name' => $license->software_name,
                'Vendor' => $license->vendor?->name,
                'Total Seats' => $license->total_seats,
                'Assigned Seats' => $license->assignedSeats(),
                'Available Seats' => $license->availableSeats(),
                'Utilization %' => $license->total_seats > 0 
                    ? round(($license->assignedSeats() / $license->total_seats) * 100, 2) 
                    : 0,
                'Expiration Date' => $license->expiration_date?->format('Y-m-d'),
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
            'Available Seats',
            'Utilization %',
            'Expiration Date',
            'Cost',
        ];
    }
}
