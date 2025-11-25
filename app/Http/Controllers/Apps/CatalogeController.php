<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\CatalogCategory;
use App\Models\Piece;
use App\Models\NavigationMenu;
use App\DataTables\CatalogCategoriesDataTable;
use App\DataTables\PiecesDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CatalogeController extends Controller
{
    // Dashboard
    public function index()
    {
        $categoriesCount = CatalogCategory::count();
        $piecesCount = Piece::count();
        $mainCategories = CatalogCategory::whereNull('parent_id')->with('children')->orderBy('order')->get();
        
        return view('admin.apps.cataloge.index', compact('categoriesCount', 'piecesCount', 'mainCategories'));
    }

    // ===== CATEGORIES =====
    public function categoriesIndex(CatalogCategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.apps.cataloge.categories.list');
    }

    public function createCategory()
    {
        $parents = CatalogCategory::whereNull('parent_id')->orderBy('order')->get();
        return view('admin.apps.cataloge.categories.create', compact('parents'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:catalog_categories,id',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'create_nav' => 'nullable|boolean',
        ]);

        $slug = Str::slug($data['title']);
        
        $existingCategory = CatalogCategory::withTrashed()->where('slug', $slug)->first();
        
        if ($existingCategory && $existingCategory->trashed()) {
            $existingCategory->forceDelete();
        } elseif ($existingCategory) {
            return back()->withErrors(['title' => 'Une catégorie avec ce nom existe déjà.'])->withInput();
        }
        
        $data['slug'] = $slug;
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'categories/' . $filename;
        }

        $category = CatalogCategory::create($data);

        if ($request->boolean('create_nav')) {
            $parentNav = null;
            if ($category->parent_id) {
                $parentNav = NavigationMenu::where('url', 'like', '%' . $category->parent->slug . '%')->first();
            }

            NavigationMenu::create([
                'title' => $category->title,
                'url' => '/pieces/' . $category->slug,
                'parent_id' => $parentNav?->id,
                'order' => $category->order ?? 0,
                'is_active' => false,
                'is_dropdown' => true,
                'target' => '_self',
            ]);
        }

        return redirect()->route('apps.cataloge.index')->with('success', 'Catégorie créée avec succès');
    }

    public function showCategory(CatalogCategory $category)
    {
        $category->load(['parent', 'children', 'pieces']);
        return view('admin.apps.cataloge.categories.show', compact('category'));
    }

    public function editCategory(CatalogCategory $category)
    {
        $parents = CatalogCategory::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('order')
            ->get();
        
        return view('admin.apps.cataloge.categories.edit', compact('category', 'parents'));
    }

    public function updateCategory(Request $request, CatalogCategory $category)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:catalog_categories,id',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('uploads/' . $category->image))) {
                unlink(public_path('uploads/' . $category->image));
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'categories/' . $filename;
        }

        $category->update($data);

        return redirect()->route('apps.cataloge.categories.index')->with('success', 'Catégorie mise à jour avec succès');
    }

    public function destroyCategory(CatalogCategory $category)
    {
        if ($category->pieces()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie contenant des pièces');
        }

        $category->children()->update(['parent_id' => $category->parent_id]);
        
        if ($category->image && file_exists(public_path('uploads/' . $category->image))) {
            unlink(public_path('uploads/' . $category->image));
        }

        $category->delete();

        return redirect()->route('apps.cataloge.categories.index')->with('success', 'Catégorie supprimée avec succès');
    }

    // ===== PIECES =====
    public function piecesIndex(PiecesDataTable $dataTable)
    {
        return $dataTable->render('admin.apps.cataloge.pieces.list');
    }

    public function createPiece()
    {
        $categories = CatalogCategory::orderBy('title')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('label')->get();
        return view('admin.apps.cataloge.pieces.create', compact('categories', 'brands'));
    }

    public function storePiece(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:pieces,reference',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:catalog_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/pieces'), $filename);
            $data['image'] = 'pieces/' . $filename;
        }

        Piece::create($data);

        return redirect()->route('apps.cataloge.pieces.index')->with('success', 'Pièce créée avec succès');
    }

    public function showPiece(Piece $piece)
    {
        $piece->load('category');
        return view('admin.apps.cataloge.pieces.show', compact('piece'));
    }

    public function editPiece(Piece $piece)
    {
        $piece->load('promotions');
        $categories = CatalogCategory::orderBy('title')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('label')->get();
        return view('admin.apps.cataloge.pieces.edit', compact('piece', 'categories', 'brands'));
    }

    public function updatePiece(Request $request, Piece $piece)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:pieces,reference,' . $piece->id,
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:catalog_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($piece->image && file_exists(public_path('uploads/' . $piece->image))) {
                unlink(public_path('uploads/' . $piece->image));
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/pieces'), $filename);
            $data['image'] = 'pieces/' . $filename;
        }

        $piece->update($data);

        return redirect()->route('apps.cataloge.pieces.index')->with('success', 'Pièce mise à jour avec succès');
    }

    public function destroyPiece(Piece $piece)
    {
        if ($piece->image && file_exists(public_path('uploads/' . $piece->image))) {
            unlink(public_path('uploads/' . $piece->image));
        }
        if ($piece->brand_image && file_exists(public_path('uploads/' . $piece->brand_image))) {
            unlink(public_path('uploads/' . $piece->brand_image));
        }

        $piece->delete();

        return redirect()->route('apps.cataloge.pieces.index')->with('success', 'Pièce supprimée avec succès');
    }
}