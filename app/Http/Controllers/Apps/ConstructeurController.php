<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Constructeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConstructeurController extends Controller
{
    public function index()
    {
        $constructeurs = Constructeur::orderBy('created_at', 'desc')->get();
        return view('admin.apps.constructeur.index', compact('constructeurs'));
    }

    public function create()
    {
        return view('admin.apps.constructeur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('constructeurs', 'public');
            $data['image'] = $path;
        }

        Constructeur::create($data);

        return redirect()->route('apps.constructeur.index')->with('success', 'Constructeur créé avec succès.');
    }

    public function edit(Constructeur $constructeur)
    {
        return view('admin.apps.constructeur.edit', compact('constructeur'));
    }

    public function update(Request $request, Constructeur $constructeur)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($constructeur->image) {
                Storage::disk('public')->delete($constructeur->image);
            }
            $data['image'] = $request->file('image')->store('constructeurs', 'public');
        }

        $constructeur->update($data);

        return redirect()->route('apps.constructeur.index')->with('success', 'Constructeur mis à jour avec succès.');
    }

    public function destroy(Constructeur $constructeur)
    {
        if ($constructeur->image) {
            Storage::disk('public')->delete($constructeur->image);
        }
        
        $constructeur->delete();

        return redirect()->route('apps.constructeur.index')->with('success', 'Constructeur supprimé avec succès.');
    }

    public function toggleStatus(Constructeur $constructeur)
    {
        $constructeur->update(['is_active' => !$constructeur->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $constructeur->is_active
        ]);
    }
}
