<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class SoftwareLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'software_name',
        'vendor_id',
        'license_key',
        'total_seats',
        'purchase_date',
        'expiration_date',
        'cost',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiration_date' => 'date',
        'cost' => 'decimal:2',
        'total_seats' => 'integer',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function licenseAssignments(): HasMany
    {
        return $this->hasMany(LicenseAssignment::class, 'license_id');
    }

    public function assignedSeats(): int
    {
        return $this->licenseAssignments()->whereNull('revoked_date')->count();
    }

    public function availableSeats(): int
    {
        return $this->total_seats - $this->assignedSeats();
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        if (!$this->expiration_date) {
            return false;
        }
        return Carbon::now()->diffInDays($this->expiration_date, false) <= $days 
            && Carbon::now()->diffInDays($this->expiration_date, false) > 0;
    }

    public function isExpired(): bool
    {
        if (!$this->expiration_date) {
            return false;
        }
        return Carbon::now()->gt($this->expiration_date);
    }
}
