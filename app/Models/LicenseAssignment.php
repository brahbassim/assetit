<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenseAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['license_id', 'employee_id', 'assigned_date', 'revoked_date'];

    protected $casts = [
        'assigned_date' => 'date',
        'revoked_date' => 'date',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(SoftwareLicense::class, 'license_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function isActive(): bool
    {
        return is_null($this->revoked_date);
    }
}
