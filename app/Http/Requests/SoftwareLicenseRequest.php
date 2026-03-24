<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoftwareLicenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'software_name' => 'required|string|max:255',
            'vendor_id' => 'nullable|exists:vendors,id',
            'license_key' => 'nullable|string',
            'total_seats' => 'required|integer|min:1',
            'purchase_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
