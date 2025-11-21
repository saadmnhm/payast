<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Piece; 

class PeiceController extends Controller
{
    /**
     * Show list of pieces. If $category or $subcategory provided, filter accordingly.
     * - Parent category: shows pieces from parent AND all its children
     * - Subcategory: shows pieces ONLY from that specific subcategory
     */
    public function index(Request $request, $category = null, $subcategory = null)
    {
        $query = Piece::with(['category', 'brand']);

        if ($category) {
            // Find the category by slug
            $categoryModel = \App\Models\CatalogCategory::where('slug', $category)->first();
            
            if ($categoryModel) {
                if ($subcategory) {
                    // If subcategory is specified, show ONLY pieces from that subcategory
                    $query->whereHas('category', function($q) use ($subcategory) {
                        $q->where('slug', $subcategory);
                    });
                } else {
                    // If only parent category, show pieces from parent AND all its children
                    $categoryIds = [$categoryModel->id];
                    
                    // Get all child category IDs
                    $childrenIds = $categoryModel->children()->pluck('id')->toArray();
                    $categoryIds = array_merge($categoryIds, $childrenIds);
                    
                    $query->whereIn('category_id', $categoryIds);
                }
            }
        }

        $pieces = $query->where('is_active', true)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('front.list.piece', compact('pieces', 'category', 'subcategory'));
    }
}
