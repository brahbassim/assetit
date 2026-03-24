<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'min_stock'];

    public function hardwareAssets(): HasMany
    {
        return $this->hasMany(HardwareAsset::class, 'category_id');
    }

    public function getAssetCount(): int
    {
        return $this->hardwareAssets()->count();
    }

    public function isLowStock(): bool
    {
        return $this->min_stock > 0 && $this->getAssetCount() < $this->min_stock;
    }
}
