<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Piece extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'reference',
        'description',
        'price',
        'image',
        'category_id',
        'brand_id',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category this piece belongs to
     */
    public function category()
    {
        return $this->belongsTo(PieceCategory::class, 'category_id');
    }

    /**
     * Get the brand this piece belongs to
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Scope for active pieces
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for in-stock pieces
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
