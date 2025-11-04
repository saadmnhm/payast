<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'desc')->get();
        return view('admin.apps.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.apps.brand.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('brands', 'public');
            $data['image'] = $path;
        }

        Brand::create($data);

        return redirect()->route('apps.brand.index')->with('success', 'Marque créée avec succès.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.apps.brand.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;


        if ($request->hasFile('image')) {
            // Delete old image
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
            $data['image'] = $request->file('image')->store('brands', 'public');
        }

        $brand->update($data);

        return redirect()->route('apps.brand.index')->with('success', 'Marque mise à jour avec succès.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
        
        $brand->delete();

        return redirect()->route('apps.brand.index')->with('success', 'Marque supprimée avec succès.');
    }

    public function toggleStatus(Brand $brand)
    {
        $brand->update(['is_active' => !$brand->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $brand->is_active
        ]);
    }
}