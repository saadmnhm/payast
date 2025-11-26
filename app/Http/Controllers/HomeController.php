<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Piece;
use App\Models\Brand;
class HomeController extends Controller
{
    public function index()
    {
        return view('front.layout');
    }
    
    public function home()
    {
        return view('front.home');
    }

    // public function promo() {

    //     $promo = Promotion::with('piece')->latest()->get();

    //     return view('front.promotion.promo', compact('promo'));
    // }

    public function promo(Request $request)
    {
        $query = Promotion::with(['piece.brand', 'piece.category'])
            ->where('is_active', true);

        if ($request->filled('prix_min')) {
            $query->where('price_promo', '>=', $request->prix_min);
        }
        if ($request->filled('prix_max')) {
            $query->where('price_promo', '<=', $request->prix_max);
        }

        if ($request->filled('brand')) {
            $query->whereHas('piece', function($q) use ($request) {
                $q->whereIn('brand_id', $request->brand);
            });
        }

        if ($request->filled('catalog')) {
            $query->whereHas('piece', function($q) use ($request) {
                $q->whereIn('category_id', $request->catalog);
            });
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'available') {
                $query->whereHas('piece', function($q) {
                    $q->where('stock', '>', 0);
                });
            } elseif ($request->stock === 'out') {
                $query->whereHas('piece', function($q) {
                    $q->where('stock', '<=', 0);
                });
            }
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_promo', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_promo', 'desc');
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
        }

        $promo = $query->paginate(12)->withQueryString();

        $brands = Brand::where('is_active', true)
            ->whereHas('pieces.promotions', function($q) {
                $q->where('is_active', true);
            })
            ->orderBy('label')
            ->get();

        $priceRange = Promotion::where('is_active', true)
            ->selectRaw('MIN(price_promo) as min, MAX(price_promo) as max')
            ->first();

        $catalogs = \App\Models\CatalogCategory::where('is_active', true)
            ->whereNull('parent_id')
            ->where(function($query) {
                $query->whereHas('pieces.promotions', function($q) {
                    $q->where('is_active', true);
                })
                ->orWhereHas('children', function($q) {
                    $q->where('is_active', true)
                        ->whereHas('pieces.promotions', function($promo) {
                            $promo->where('is_active', true);
                        });
                });
            })
            ->with(['children' => function($query) {
                $query->where('is_active', true)
                    ->whereHas('pieces.promotions', function($q) {
                        $q->where('is_active', true);
                    });
            }])
            ->orderBy('title')
            ->get();

        return view('front.promotion.promo', compact('promo', 'brands', 'priceRange', 'catalogs'));
    }

}