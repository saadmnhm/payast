<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title',
        'alias',
        'excerpt',
        'content',
        'intro',
        'main_image',
        'banner_image',
        'is_active',
        'is_featured',
        'published_at',
        'view_count',
        'user_id',
        'meta_title',
        'meta_description',
        'keywords', 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the user that owns the blog post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the categories for the blog post.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category', 'post_id', 'category_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Increment the view count
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
        return $this->view_count;
    }
}