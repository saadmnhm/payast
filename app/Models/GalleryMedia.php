<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryMedia extends Model
{
    protected $fillable = [
        'gallery_id',
        'file_path',
        'file_name',
        'original_name',
        'file_type',
        'mime_type',
        'file_size',
        'original_size',
        'sort_order',
        'is_compressed'
    ];

    protected $casts = [
        'is_compressed' => 'boolean',
        'file_size' => 'integer',
        'original_size' => 'integer',
        'sort_order' => 'integer'
    ];

    /**
     * Get the gallery that owns the media
     */
    public function gallery()
    {
        return $this->belongsTo(Gallerie::class, 'gallery_id');
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get formatted file size
     */
    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return 'Unknown';

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Get compression ratio if compressed
     */
    public function getCompressionRatioAttribute(): ?float
    {
        if (!$this->is_compressed || !$this->original_size || !$this->file_size) {
            return null;
        }

        return round((1 - ($this->file_size / $this->original_size)) * 100, 1);
    }

    /**
     * Check if media is an image
     */
    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if media is a video
     */
    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    /**
     * Scope for images only
     */
    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    /**
     * Scope for videos only
     */
    public function scopeVideos($query)
    {
        return $query->where('file_type', 'video');
    }

    /**
     * Scope for ordered media
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
