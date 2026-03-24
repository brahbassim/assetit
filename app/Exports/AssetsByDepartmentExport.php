<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsByDepartmentExport implements FromCollection, WithHeadings
{
    protected $departments;

    public function __construct($departments)
    {
        $this->departments = $departments;
    }

    public function collection()
    {
        return $this->departments->map(function ($department) {
            $employeeCount = $department->employees->count();
            $assetCount = $department->employees->sum(fn($e) => $e->hardwareAssets->count());
            
            return [
                'Department' => $department->name,
                'Employee Count' => $employeeCount,
                'Asset Count' => $assetCount,
                'Description' => $department->description,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Department',
            'Employee Count',
            'Asset Count',
            'Description',
        ];
    }
}
