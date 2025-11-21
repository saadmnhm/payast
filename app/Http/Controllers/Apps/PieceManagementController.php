<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use App\Models\PieceCategory;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PieceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Piece::with(['category', 'brand']);

        // Filter by category if provided
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by brand if provided
        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        $pieces = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = PieceCategory::active()->ordered()->get();
        $brands = Brand::where('is_active', true)->orderBy('label')->get();
        
        return view('admin.apps.pieces.index', compact('pieces', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PieceCategory::active()->ordered()->get();
        $brands = Brand::where('is_active', true)->orderBy('label')->get();
        return view('admin.apps.pieces.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:pieces,reference',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:piece_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pieces', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Piece::create($validated);

        return redirect()->route('apps.pieces.index')
            ->with('success', 'Pièce créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Piece $piece)
    {
        $piece->load(['category', 'brand']);
        return view('admin.apps.pieces.show', compact('piece'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Piece $piece)
    {
        $categories = PieceCategory::active()->ordered()->get();
        $brands = Brand::where('is_active', true)->orderBy('label')->get();
        return view('admin.apps.pieces.edit', compact('piece', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Piece $piece)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:pieces,reference,' . $piece->id,
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:piece_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($piece->image) {
                Storage::disk('public')->delete($piece->image);
            }
            $validated['image'] = $request->file('image')->store('pieces', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $piece->update($validated);

        return redirect()->route('apps.pieces.index')
            ->with('success', 'Pièce mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Piece $piece)
    {
        // Delete image if exists
        if ($piece->image) {
            Storage::disk('public')->delete($piece->image);
        }

        $piece->delete();

        return redirect()->route('apps.pieces.index')
            ->with('success', 'Pièce supprimée avec succès');
    }

    /**
     * Toggle piece status (active/inactive)
     */
    public function toggleStatus(Piece $piece)
    {
        $piece->update([
            'is_active' => !$piece->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $piece->is_active
        ]);
    }
}
