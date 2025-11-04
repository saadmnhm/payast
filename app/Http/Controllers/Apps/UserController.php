<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.apps.user-management.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */


    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'password' => 'required|min:8',
            'role_id' => 'required',
            'avatar' => 'nullable|image|max:1024',
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.regex' => 'Format de téléphone invalide.',
            'phone.min' => 'Le numéro de téléphone doit avoir au moins 10 caractères.',
            'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role_id.required' => 'Veuillez sélectionner un rôle.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.max' => 'La taille de l\'image ne doit pas dépasser 1Mo.',
        ]);
        
        try {
            DB::beginTransaction();
            
            $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'role_id']);
            $data['name'] = $request->first_name . ' ' . $request->last_name;
            $data['password'] = Hash::make($request->password);
            $data['is_active'] = true;
            
            if ($request->hasFile('avatar')) {
                try {
                    $originalName = $request->file('avatar')->getClientOriginalName();
                    Log::info("Uploading file: {$originalName}");
                    
                    $filename = time() . '_' . $originalName;
                    
                    $targetDirectory = public_path('assets/images/avatars');
                    if (!file_exists($targetDirectory)) {
                        Log::info("Creating directory: {$targetDirectory}");
                        mkdir($targetDirectory, 0777, true);
                        chmod($targetDirectory, 0777);
                    }
                    
                    $request->file('avatar')->move($targetDirectory, $filename);
                    
                    $data['profile_photo_path'] = 'assets/images/avatars/' . $filename;
                } catch (\Exception $e) {
                    Log::error('Failed to upload image: ' . $e->getMessage());
                    Log::error($e->getTraceAsString());
                    $data['profile_photo_path'] = null;
                }
            }
            
            $user = User::create($data);
            
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.apps.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $roles_description = [
            'administrator' => 'Idéal pour les propriétaires d\'entreprise et les administrateurs de société',
            'developer' => 'Idéal pour les développeurs ou les personnes utilisant principalement l\'API',
            'analyst' => 'Idéal pour les personnes ayant besoin d\'un accès complet aux données analytiques, mais sans modifier les paramètres de l\'entreprise',
            'support' => 'Idéal pour les employés qui remboursent régulièrement des paiements et répondent aux litiges',
            'trial' => 'Idéal pour les personnes qui ont besoin de prévisualiser les données de contenu, mais sans effectuer de modifications',
        ];

        foreach ($roles as $i => $role) {
            $roles[$i]->description = $roles_description[$role->name] ?? '';
        }
        
        return view('admin.apps.user-management.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'password' => 'nullable|min:8',
            'role_id' => 'required',
            'avatar' => 'nullable|image|max:1024',
        ]);
        
        try {
            DB::beginTransaction();
            
            $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'role_id']);
            $data['name'] = $request->first_name . ' ' . $request->last_name;
            
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            
            if ($request->hasFile('avatar')) {
                try {
                    $originalName = $request->file('avatar')->getClientOriginalName();
                    $filename = time() . '_' . $originalName;
                    
                    $targetDirectory = public_path('assets/images/avatars');
                    if (!file_exists($targetDirectory)) {
                        mkdir($targetDirectory, 0777, true);
                    }
                    
                    $request->file('avatar')->move($targetDirectory, $filename);
                    
                    $data['profile_photo_path'] = 'assets/images/avatars/' . $filename;
                } catch (\Exception $e) {
                    Log::error('Failed to upload image: ' . $e->getMessage());
                }
            }
            
            $user->update($data);
            
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage (soft delete).
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
    
    /**
     * Display trashed users.
     */
    public function trashed()
    {
        $trashedUsers = User::onlyTrashed()->get();
        return view('admin.apps.user-management.users.trashed', compact('trashedUsers'));
    }
    
    /**
     * Restore a trashed user.
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        
        return redirect()->route('users.trashed')->with('success', 'User restored successfully');
    }
    
    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        
        $status = $user->is_active ? 'enabled' : 'disabled';
        return back()->with('success', "User {$status} successfully");
    }
}