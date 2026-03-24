<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'hardware_asset_id',
        'title',
        'file_path',
        'file_type',
        'file_size',
        'uploaded_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function hardwareAsset(): BelongsTo
    {
        return $this->belongsTo(HardwareAsset::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileIconAttribute(): string
    {
        $extension = strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
        
        return match($extension) {
            'pdf' => 'fa-file-pdf',
            'doc', 'docx' => 'fa-file-word',
            'xls', 'xlsx' => 'fa-file-excel',
            'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image',
            'zip', 'rar' => 'fa-file-archive',
            default => 'fa-file',
        };
    }
}
