<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_id' => 'required|exists:hardware_assets,id',
            'maintenance_type' => 'required|in:preventive,repair,upgrade,inspection',
            'description' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'maintenance_date' => 'required|date',
            'vendor_id' => 'nullable|exists:vendors,id',
        ];
    }
}
