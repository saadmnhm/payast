<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;

class NavigationMenuApiController extends Controller
{
    /**
     * Get all active navigation menus with their children
     */
    public function index()
    {
        $menus = NavigationMenu::with('activeChildren')
            ->parents()
            ->active()
            ->ordered()
            ->get()
            ->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'title' => $menu->title,
                    'url' => $menu->url,
                    'icon' => $menu->icon,
                    'order' => $menu->order,
                    'is_dropdown' => $menu->is_dropdown,
                    'target' => $menu->target,
                    'children' => $menu->activeChildren->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'title' => $child->title,
                            'url' => $child->url,
                            'icon' => $child->icon,
                            'order' => $child->order,
                            'target' => $child->target,
                        ];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    /**
     * Get menu by ID with children
     */
    public function show($id)
    {
        $menu = NavigationMenu::with('activeChildren')
            ->active()
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $menu->id,
                'title' => $menu->title,
                'url' => $menu->url,
                'icon' => $menu->icon,
                'order' => $menu->order,
                'is_dropdown' => $menu->is_dropdown,
                'target' => $menu->target,
                'children' => $menu->activeChildren->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'title' => $child->title,
                        'url' => $child->url,
                        'icon' => $child->icon,
                        'order' => $child->order,
                        'target' => $child->target,
                    ];
                }),
            ]
        ]);
    }
}
