<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallerie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'sort_order',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function media()
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id');
    }

    public function orderedMedia()
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id')->orderBy('sort_order')->orderBy('created_at');
    }

    public function images()
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id')->where('file_type', 'image');
    }

    public function videos()
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id')->where('file_type', 'video');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getTotalFileSizeAttribute()
    {
        return $this->media->sum('file_size');
    }

    public function getTotalFileSizeFormattedAttribute()
    {
        $bytes = $this->getTotalFileSizeAttribute();

        if (!$bytes) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getMediaCountAttribute()
    {
        return $this->media()->count();
    }

    public function getImageCountAttribute()
    {
        return $this->images()->count();
    }

    public function getVideoCountAttribute()
    {
        return $this->videos()->count();
    }

    // Helper methods
    public function hasMedia()
    {
        return $this->media()->exists();
    }

    public function hasImages()
    {
        return $this->images()->exists();
    }

    public function hasVideos()
    {
        return $this->videos()->exists();
    }
}
