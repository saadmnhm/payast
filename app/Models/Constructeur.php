<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Constructeur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'label',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the image URL attribute.
     */
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

    public function pieces()
    {
        return $this->hasMany(Piece::class);
    }
}
