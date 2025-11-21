<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\PieceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PieceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PieceCategory::with('children', 'parent')
            ->parents()
            ->ordered()
            ->get();
        
        return view('admin.apps.piece-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = PieceCategory::parents()->active()->ordered()->get();
        return view('admin.apps.piece-categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:piece_categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:piece_categories,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('piece-categories', 'public');
        }

        // Set order if not provided
        if (!isset($validated['order'])) {
            $maxOrder = PieceCategory::where('parent_id', $validated['parent_id'] ?? null)->max('order');
            $validated['order'] = $maxOrder ? $maxOrder + 1 : 0;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        PieceCategory::create($validated);

        return redirect()->route('apps.piece-categories.index')
            ->with('success', 'Catégorie créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(PieceCategory $pieceCategory)
    {
        $pieceCategory->load(['children', 'parent', 'pieces']);
        return view('admin.apps.piece-categories.show', compact('pieceCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PieceCategory $pieceCategory)
    {
        $parentCategories = PieceCategory::parents()
            ->where('id', '!=', $pieceCategory->id)
            ->active()
            ->ordered()
            ->get();
        
        return view('admin.apps.piece-categories.edit', compact('pieceCategory', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PieceCategory $pieceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:piece_categories,slug,' . $pieceCategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:piece_categories,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Prevent setting itself as parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $pieceCategory->id) {
            return back()->withErrors(['parent_id' => 'Une catégorie ne peut pas être son propre parent']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($pieceCategory->image) {
                Storage::disk('public')->delete($pieceCategory->image);
            }
            $validated['image'] = $request->file('image')->store('piece-categories', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $pieceCategory->update($validated);

        return redirect()->route('apps.piece-categories.index')
            ->with('success', 'Catégorie mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PieceCategory $pieceCategory)
    {
        // Delete image if exists
        if ($pieceCategory->image) {
            Storage::disk('public')->delete($pieceCategory->image);
        }

        $pieceCategory->delete();

        return redirect()->route('apps.piece-categories.index')
            ->with('success', 'Catégorie supprimée avec succès');
    }

    /**
     * Toggle category status (active/inactive)
     */
    public function toggleStatus(PieceCategory $pieceCategory)
    {
        $pieceCategory->update([
            'is_active' => !$pieceCategory->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $pieceCategory->is_active
        ]);
    }
}
