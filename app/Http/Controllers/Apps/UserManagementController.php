<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('roles')
            ->where('id', '!=', Auth::id())  
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.apps.users.list', compact('users'));
    }

    /**
     * Display trashed users.
     */
    public function trashed()
    {
        $trashedUsers = User::onlyTrashed()->with('roles')->get();
        return view('admin.apps.users.trashed', compact('trashedUsers'));
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();
            
            return redirect()->route('apps.users.index')
                ->with('success', 'Utilisateur restauré avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la restauration: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone.regex' => 'Format de téléphone invalide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role_id.required' => 'Veuillez sélectionner un rôle.',
            'role_id.exists' => 'Le rôle sélectionné n\'existe pas.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.mimes' => 'Formats acceptés: jpeg, png, jpg.',
            'avatar.max' => 'La taille de l\'image ne doit pas dépasser 2Mo.',
        ]);
        
        try {
            DB::beginTransaction();
            
            $userData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id'],
                'is_active' => true,
            ];
            
            if ($request->hasFile('avatar')) {
                $userData['profile_photo_path'] = $this->uploadAvatar($request->file('avatar'));
            }
            
            $user = User::create($userData);
            
            DB::commit();
            
            return redirect()->route('apps.users.index')
                ->with('success', 'Utilisateur créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.apps.users.show', compact('user'));
    }

    /**
     * Update user details.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            'password' => 'nullable|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        try {
            DB::beginTransaction();
            
            $userData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'role_id' => $validated['role_id'],
            ];
            
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            
            if ($request->hasFile('avatar')) {
                if ($user->profile_photo_path) {
                    $this->deleteAvatar($user->profile_photo_path);
                }
                $userData['profile_photo_path'] = $this->uploadAvatar($request->file('avatar'));
            }
            
            $user->update($userData);
            
            DB::commit();
            
            return redirect()->route('apps.users.show', $user)
                ->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    /**
     * Update specific user field (AJAX).
     */
    public function updateField(Request $request, User $user)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        
        $allowedFields = ['first_name', 'last_name', 'email', 'phone'];
        
        if (!in_array($field, $allowedFields)) {
            return response()->json(['error' => 'Champ non autorisé'], 403);
        }
        
        try {
            $rules = [
                'email' => 'required|email|unique:users,email,' . $user->id,
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
            ];
            
            $request->validate(['value' => $rules[$field] ?? 'required']);
            
            $user->$field = $value;
            
            if (in_array($field, ['first_name', 'last_name'])) {
                $user->name = $user->first_name . ' ' . $user->last_name;
            }
            
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Information mise à jour avec succès',
                'new_value' => $value,
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'password' => 'required|min:8|confirmed',
            ], [
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            ]);
            
            $user->password = Hash::make($validated['password']);
            $user->save();
            
            return redirect()->back()
                ->with('success', 'Mot de passe mis à jour avec succès.');
                
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    /**
     * Update user avatar.
     */
    public function updateAvatar(Request $request, User $user)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'avatar.required' => 'Veuillez sélectionner une image.',
                'avatar.image' => 'Le fichier doit être une image.',
                'avatar.mimes' => 'Formats acceptés: jpeg, png, jpg.',
                'avatar.max' => 'La taille maximale est de 2MB.',
            ]);
            
            if ($user->profile_photo_path) {
                $this->deleteAvatar($user->profile_photo_path);
            }
            
            $avatarPath = $this->uploadAvatar($request->file('avatar'));
            
            $user->profile_photo_path = $avatarPath;
            $user->save();
            
            return redirect()->back()
                ->with('success', 'Photo de profil mise à jour avec succès.');
                
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Avatar upload error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors du téléchargement: ' . $e->getMessage());
        }
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'role_id' => 'required|exists:roles,id',
            ], [
                'role_id.required' => 'Veuillez sélectionner un rôle.',
                'role_id.exists' => 'Le rôle sélectionné n\'existe pas.',
            ]);
            
            $user->role_id = $validated['role_id'];
            $user->save();
            
            return redirect()->back()
                ->with('success', 'Rôle mis à jour avec succès.');
                
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        try {
            if ($user->id === Auth::id()) {
                return redirect()->back()
                    ->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
            }
            
            $user->is_active = !$user->is_active;
            $user->save();
            
            $status = $user->is_active ? 'activé' : 'désactivé';
            
            return redirect()->back()
                ->with('success', "L'utilisateur a été {$status} avec succès.");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete user.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->id === Auth::id()) {
                return redirect()->back()
                    ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            }
            
            $user->delete();
            
            return redirect()->route('apps.users.index')
                ->with('success', 'Utilisateur supprimé avec succès.');
                
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->handleDatabaseError($e, route('apps.users.index'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Upload avatar file.
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    protected function uploadAvatar($file)
    {
        $uploadPath = public_path('uploads/avatars');
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);
        
        return 'avatars/' . $filename;
    }

    /**
     * Delete avatar file.
     * 
     * @param string $path
     * @return void
     */
    protected function deleteAvatar($path)
    {
        $fullPath = public_path('uploads/' . $path);
        if (file_exists($fullPath) && !str_contains($path, 'http')) {
            @unlink($fullPath);
        }
    }

    /**
     * Handle database errors with friendly messages.
     * 
     * @param \Exception $e
     * @param string $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleDatabaseError(\Exception $e, $redirect)
    {
        if ($e instanceof \Illuminate\Database\QueryException) {
            $errorCode = $e->errorInfo[1] ?? null;
            
            if ($errorCode == 1062) {
                preg_match("/Duplicate entry '(.+)' for key '(.+)'/", $e->getMessage(), $matches);
                $value = $matches[1] ?? 'une valeur';
                $field = str_replace(['users_', '_unique'], '', $matches[2] ?? 'ce champ');
                
                $fieldLabels = [
                    'email' => 'adresse e-mail',
                    'phone' => 'numéro de téléphone',
                    'username' => 'nom d\'utilisateur'
                ];
                
                $fieldLabel = $fieldLabels[$field] ?? $field;
                $message = "L'$fieldLabel \"$value\" est déjà utilisé(e) par un autre utilisateur.";
                
                return redirect()->to($redirect)->with('error', $message);
            }
            
            if ($errorCode == 1451) {
                return redirect()->to($redirect)->with('error', 
                    'Impossible de supprimer cet utilisateur car il est lié à d\'autres enregistrements.');
            }
        }
        
        return redirect()->to($redirect)->with('error', 'Une erreur est survenue: ' . $e->getMessage());
    }
}
