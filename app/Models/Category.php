<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'label',
        'alias',
        'slug',
        'image',
        'intro',
        'metatitle',
        'metadescription',
        'keywords',
        'color',
        'user_id',
        'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function getSlugAttribute()
    {
        return $this->alias;
    }
    
    /**
     * Get the blog posts for the category.
     */
    public function blogPosts()
    {
        return $this->belongsToMany(BlogPost::class, 'post_category', 'category_id', 'post_id');
    }
}