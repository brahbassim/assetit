<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HardwareInventoryExport implements FromCollection, WithHeadings
{
    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function collection()
    {
        return $this->assets->map(function ($asset) {
            return [
                'Asset Tag' => $asset->asset_tag,
                'Name' => $asset->name,
                'Category' => $asset->category?->name,
                'Vendor' => $asset->vendor?->name,
                'Serial Number' => $asset->serial_number,
                'Status' => $asset->status,
                'Assigned To' => $asset->assignedEmployee?->full_name,
                'Purchase Date' => $asset->purchase_date?->format('Y-m-d'),
                'Purchase Cost' => $asset->purchase_cost,
                'Warranty Expiry' => $asset->warranty_expiry?->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Asset Tag',
            'Name',
            'Category',
            'Vendor',
            'Serial Number',
            'Status',
            'Assigned To',
            'Purchase Date',
            'Purchase Cost',
            'Warranty Expiry',
        ];
    }
}
