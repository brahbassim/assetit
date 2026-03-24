<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HardwareAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_tag',
        'name',
        'category_id',
        'vendor_id',
        'serial_number',
        'purchase_date',
        'purchase_cost',
        'warranty_expiry',
        'status',
        'assigned_employee_id',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'purchase_cost' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_employee_id');
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class, 'asset_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(AssetDocument::class, 'hardware_asset_id');
    }

    public function isWarrantyExpired(): bool
    {
        return $this->warranty_expiry && $this->warranty_expiry->isPast();
    }

    public function isWarrantyExpiringSoon(int $days = 30): bool
    {
        return $this->warranty_expiry 
            && !$this->warranty_expiry->isPast()
            && $this->warranty_expiry->diffInDays(now()) <= $days;
    }

    public function getWarrantyStatusAttribute(): string
    {
        if (!$this->warranty_expiry) return 'N/A';
        if ($this->isWarrantyExpired()) return 'expired';
        if ($this->isWarrantyExpiringSoon(30)) return 'expiring_soon';
        return 'active';
    }
}
