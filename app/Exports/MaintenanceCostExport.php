<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaintenanceCostExport implements FromCollection, WithHeadings
{
    protected $records;
    protected $year;
    protected $totalCost;

    public function __construct($records, $year, $totalCost)
    {
        $this->records = $records;
        $this->year = $year;
        $this->totalCost = $totalCost;
    }

    public function collection()
    {
        return $this->records->map(function ($record) {
            return [
                'Asset' => $record->asset?->name,
                'Asset Tag' => $record->asset?->asset_tag,
                'Maintenance Type' => $record->maintenance_type,
                'Description' => $record->description,
                'Vendor' => $record->vendor?->name,
                'Maintenance Date' => $record->maintenance_date?->format('Y-m-d'),
                'Cost' => $record->cost,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Asset',
            'Asset Tag',
            'Maintenance Type',
            'Description',
            'Vendor',
            'Maintenance Date',
            'Cost',
        ];
    }
}
