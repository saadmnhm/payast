<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;

class NavigationMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = NavigationMenu::with('children')
            ->parents()
            ->ordered()
            ->get();
        
        return view('admin.apps.navigation-menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentMenus = NavigationMenu::parents()->active()->ordered()->get();
        return view('admin.apps.navigation-menu.create', compact('parentMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:navigation_menus,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_dropdown' => 'boolean',
            'target' => 'required|in:_self,_blank',
        ]);

        // If no order provided, get the max order + 1
        if (!isset($validated['order'])) {
            $maxOrder = NavigationMenu::where('parent_id', $validated['parent_id'] ?? null)
                ->max('order');
            $validated['order'] = $maxOrder ? $maxOrder + 1 : 0;
        }

        NavigationMenu::create($validated);

        return redirect()->route('apps.navigation-menu.index')
            ->with('success', 'Menu créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(NavigationMenu $navigationMenu)
    {
        $navigationMenu->load('children', 'parent');
        return view('admin.apps.navigation-menu.show', compact('navigationMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NavigationMenu $navigationMenu)
    {
        $parentMenus = NavigationMenu::parents()
            ->where('id', '!=', $navigationMenu->id)
            ->active()
            ->ordered()
            ->get();
        
        return view('admin.apps.navigation-menu.edit', compact('navigationMenu', 'parentMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NavigationMenu $navigationMenu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:navigation_menus,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_dropdown' => 'boolean',
            'target' => 'required|in:_self,_blank',
        ]);

        // Prevent setting itself as parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $navigationMenu->id) {
            return back()->withErrors(['parent_id' => 'Un menu ne peut pas être son propre parent']);
        }

        $navigationMenu->update($validated);

        return redirect()->route('apps.navigation-menu.index')
            ->with('success', 'Menu mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NavigationMenu $navigationMenu)
    {
        $navigationMenu->delete();

        return redirect()->route('apps.navigation-menu.index')
            ->with('success', 'Menu supprimé avec succès');
    }

    /**
     * Toggle menu status (active/inactive)
     */
    public function toggleStatus(NavigationMenu $navigationMenu)
    {
        $navigationMenu->update([
            'is_active' => !$navigationMenu->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $navigationMenu->is_active
        ]);
    }

    /**
     * Update menu order
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            NavigationMenu::where('id', $id)->update(['order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordre mis à jour avec succès'
        ]);
    }
}
