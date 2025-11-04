<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavigationMenu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'url',
        'icon',
        'parent_id',
        'order',
        'is_active',
        'is_dropdown',
        'target',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_dropdown' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the parent menu item
     */
    public function parent()
    {
        return $this->belongsTo(NavigationMenu::class, 'parent_id');
    }

    /**
     * Get the children menu items
     */
    public function children()
    {
        return $this->hasMany(NavigationMenu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get active children
     */
    public function activeChildren()
    {
        return $this->hasMany(NavigationMenu::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Scope to get only active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only parent menus (no parent_id)
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get menus ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public static function getActiveMenus()
    {
        return self::with('activeChildren')
            ->parents()
            ->active()
            ->ordered()
            ->get();
    }
}