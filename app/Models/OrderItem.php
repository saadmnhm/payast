<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'piece_id',
        'product_name',
        'product_reference',
        'price',
        'quantity',
        'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' DH';
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal, 2) . ' DH';
    }
}