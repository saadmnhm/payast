<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'order',
        'image',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CatalogCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(CatalogCategory::class, 'parent_id')->orderBy('order');
    }

    public function pieces(): HasMany
    {
        return $this->hasMany(Piece::class, 'category_id');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            return asset('uploads/' . $this->image);
        }

        return asset('assets/media/svg/files/blank-image.svg');
    }

    public function getFullPathAttribute(): string
    {
        $path = collect([$this->title]);
        $parent = $this->parent;
        
        while ($parent) {
            $path->prepend($parent->title);
            $parent = $parent->parent;
        }
        
        return $path->implode(' > ');
    }
}