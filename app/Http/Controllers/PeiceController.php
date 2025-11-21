<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Piece;
use App\Models\PieceCategory;

class PeiceController extends Controller
{
    public function index($categorySlug = null)
    {
        $category = null;
        $query = Piece::with(['category', 'brand'])->active();

        // Filter by category if slug is provided
        if ($categorySlug) {
            $category = PieceCategory::where('slug', $categorySlug)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        $pieces = $query->paginate(12);
        $categories = PieceCategory::active()->ordered()->get();

        return view('front.list.piece', compact('pieces', 'categories', 'category'));
    }
}
