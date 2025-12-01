<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function constructeur(): BelongsTo
    {
        return $this->belongsTo(Constructeur::class, 'constructeur_id');
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class, 'piece_id');
    }

    public function activePromotion()
    {
        return $this->hasOne(Promotion::class, 'piece_id')->where('is_active', true);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            if (file_exists(public_path('uploads/' . $this->image))) {
                return asset('uploads/' . $this->image);
            }
        }

        return asset('assets/media/svg/files/blank-image.svg');
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
            if (file_exists(public_path('uploads/' . $this->brand->image))) {
                return asset('uploads/' . $this->brand->image);
            }
        }
        return null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' DH';
    }
}