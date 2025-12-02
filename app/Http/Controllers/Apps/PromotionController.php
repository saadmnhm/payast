<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('piece')->latest()->paginate(15);
        return view('admin.apps.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $pieces = Piece::where('is_active', true)->orderBy('name')->get();
        return view('admin.apps.promotions.create', compact('pieces'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'piece_id' => 'nullable|exists:pieces,id',
            'price_promo' => 'required|numeric|min:0',
            'order' => 'nullable|integer',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($data['title']);
        $count = 1;
        $originalSlug = $slug;
        while (Promotion::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;
        
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        Promotion::create($data);

        return redirect()->route('apps.promotions.index')->with('success', 'Promotion créée avec succès');
    }

    public function show(Promotion $promotion)
    {
        $promotion->load('piece');
        return view('admin.apps.promotions.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        $pieces = Piece::where('is_active', true)->orderBy('name')->get();
        return view('admin.apps.promotions.edit', compact('promotion', 'pieces'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'piece_id' => 'nullable|exists:pieces,id',
                'price_promo' => 'required|numeric|min:0',
                'order' => 'nullable|integer',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|max:2048',
                'description' => 'nullable|string',
            ]);
            // Generate slug only if title changed
            $newSlug = Str::slug($validated['title']);
            if ($newSlug !== $promotion->slug) {
                // Check if slug exists for other promotions
                $count = 1;
                $originalSlug = $newSlug;
                while (Promotion::where('slug', $newSlug)->where('id', '!=', $promotion->id)->whereNull('deleted_at')->exists()) {
                    $newSlug = $originalSlug . '-' . $count;
                    $count++;
                }
                $validated['slug'] = $newSlug;
            }
            
            // Handle is_active checkbox
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle image upload
            if ($request->hasFile('image')) {
                if ($promotion->image) {
                    Storage::disk('public')->delete($promotion->image);
                }
                $validated['image'] = $request->file('image')->store('promotions', 'public');
            }

            // Update promotion
            $promotion->update($validated);

            return redirect()->route('apps.promotions.index')->with('success', 'Promotion mise à jour avec succès');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Erreur lors de la mise à jour: ' . $e->getMessage()]);
        }
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->image) {
            Storage::disk('public')->delete($promotion->image);
        }

        $promotion->delete();

        return redirect()->route('apps.promotions.index')->with('success', 'Promotion supprimée avec succès');
    }

    public function addPieceToPromotion(Request $request, Piece $piece)
    {
        $data = $request->validate([
            'price_promo' => 'required|numeric|min:0',
        ]);

        Promotion::create([
            'title' => 'Promotion ' . $piece->name,
            'slug' => Str::slug('promo-' . $piece->name),
            'piece_id' => $piece->id,
            'price_promo' => $data['price_promo'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Pièce ajoutée aux promotions');
    }
}
