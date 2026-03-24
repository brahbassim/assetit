<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HardwareAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asset_tag' => 'required|string|max:255|unique:hardware_assets,asset_tag,' . ($this->hardwareAsset?->id ?? 'NULL'),
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:asset_categories,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'serial_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric|min:0',
            'warranty_expiry' => 'nullable|date',
            'status' => 'required|in:available,assigned,maintenance,retired',
            'assigned_employee_id' => 'nullable|exists:employees,id',
            'notes' => 'nullable|string',
        ];
    }
}
