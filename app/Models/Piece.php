<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Piece extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'reference',
        'price',
        'category_id',
        'brand_id',
        'image',
        'description',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CatalogCategory::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/media/svg/files/blank-image.svg');
    }

    public function getBrandNameAttribute(): ?string
    {
        if ($this->brand_id && $this->relationLoaded('brand')) {
            return $this->brand?->label;
        }
        return null;
    }

    public function getBrandImageUrlAttribute(): ?string
    {
        if ($this->brand_id && $this->relationLoaded('brand') && $this->brand && $this->brand->image) {
            return asset('storage/' . $this->brand->image);
        }
        return null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' DH';
    }
}