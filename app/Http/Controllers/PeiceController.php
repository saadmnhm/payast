<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Piece; 
use App\Models\CatalogCategory;
use App\Models\Brand;

class PeiceController extends Controller
{
    /**
     * Show list of pieces with filters
     */
    public function index(Request $request, $category = null, $subcategory = null)
    {
        $query = Piece::with(['category', 'brand', 'activePromotion'])->where('is_active', true);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('reference', 'LIKE', "%{$search}%")
                  ->orWhereHas('brand', function($brandQuery) use ($search) {
                      $brandQuery->where('label', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('category', function($catQuery) use ($search) {
                      $catQuery->where('title', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Catalog category filter from form
        if ($request->filled('catalog')) {
            $query->whereIn('category_id', $request->catalog);
        }
        // Category from URL (if catalog filter not used)
        elseif ($category) {
            $categoryModel = CatalogCategory::where('slug', $category)->first();
            
            if ($categoryModel) {
                if ($subcategory) {
                    $query->whereHas('category', function($q) use ($subcategory) {
                        $q->where('slug', $subcategory);
                    });
                } else {
                    $categoryIds = [$categoryModel->id];
                    $childrenIds = $categoryModel->children()->pluck('id')->toArray();
                    $categoryIds = array_merge($categoryIds, $childrenIds);
                    $query->whereIn('category_id', $categoryIds);
                }
            }
        }

        if ($request->filled('prix_min')) {
            $query->where('price', '>=', $request->prix_min);
        }
        if ($request->filled('prix_max')) {
            $query->where('price', '<=', $request->prix_max);
        }

        if ($request->filled('brand')) {
            $query->whereIn('brand_id', $request->brand);
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock === 'out') {
                $query->where('stock', '<=', 0);
            }
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $pieces = $query->paginate(12)->withQueryString();

        $brands = Brand::where('is_active', true)
            ->whereHas('pieces')
            ->orderBy('label')
            ->get();

        $priceRange = Piece::where('is_active', true)
            ->selectRaw('MIN(price) as min, MAX(price) as max')
            ->first();

        $catalogs = CatalogCategory::where('is_active', true)
            ->whereNull('parent_id')
            ->where(function($query) {
                // Include categories that have pieces directly
                $query->whereHas('pieces')
                    // OR categories that have children with pieces
                    ->orWhereHas('children', function($q) {
                        $q->where('is_active', true)->whereHas('pieces');
                    });
            })
            ->with(['children' => function($query) {
                $query->where('is_active', true)->whereHas('pieces');
            }])
            ->orderBy('title')
            ->get();

        return view('front.list.piece', compact('pieces', 'category', 'subcategory', 'brands', 'priceRange', 'catalogs'));
    }

    /**
     * Get search suggestions (AJAX)
     */
    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'brands' => [],
                'categories' => [],
                'pieces' => []
            ]);
        }

        $brands = Brand::where('is_active', true)
            ->where('label', 'LIKE', "%{$query}%")
            ->limit(8)
            ->get(['id', 'label', 'image']);

        $categories = CatalogCategory::where('is_active', true)
            ->where('title', 'LIKE', "%{$query}%")
            ->limit(8)
            ->get(['id', 'title']);

        $pieces = Piece::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('reference', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhereHas('brand', function($brandQuery) use ($query) {
                      $brandQuery->where('label', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('category', function($catQuery) use ($query) {
                      $catQuery->where('title', 'LIKE', "%{$query}%");
                  });
            })
            ->with('brand:id,label')
            ->limit(12)
            ->get(['id', 'name', 'reference', 'price', 'image', 'brand_id', 'category_id']);

        return response()->json([
            'brands' => $brands,
            'categories' => $categories,
            'pieces' => $pieces
        ]);
    }

    /**
     * Show single piece detail
     */
    public function show($id)
    {
        $piece = Piece::with(['category', 'brand', 'activePromotion'])
            ->where('is_active', true)
            ->findOrFail($id);

        // Get related pieces (same category, exclude current piece)
        $relatedPieces = Piece::with(['category', 'brand', 'activePromotion'])
            ->where('is_active', true)
            ->where('category_id', $piece->category_id)
            ->where('id', '!=', $piece->id)
            ->limit(4)
            ->get();

        return view('front.list.item', compact('piece', 'relatedPieces'));
    }
}