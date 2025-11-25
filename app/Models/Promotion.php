<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'piece_id',
        'price_promo',
        'order',
        'icon',
        'image',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_promo' => 'decimal:2',
        'order' => 'integer',
    ];

    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_promo, 2, ',', ' ') . ' MAD';
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->piece && $this->piece->price > 0) {
            $discount = (($this->piece->price - $this->price_promo) / $this->piece->price) * 100;
            return round($discount);
        }
        return 0;
    }
}
