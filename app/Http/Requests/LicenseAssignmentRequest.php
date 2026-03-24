<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicenseAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'license_id' => 'required|exists:software_licenses,id',
            'employee_id' => 'required|exists:employees,id',
            'assigned_date' => 'nullable|date',
        ];
    }
}
