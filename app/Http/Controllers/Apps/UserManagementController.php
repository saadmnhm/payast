<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $users = User::with('roles')->get();
    return view('admin.apps.users.list', compact('users'));
    }
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
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        
        return redirect()->route('apps.users.index')
            ->with('success', 'User restored successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin/apps.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateField(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $field = $request->input('field');
        $value = $request->input('value');
        
        // Liste des champs autorisés à être modifiés
        $allowedFields = ['first_name', 'last_name', 'email', 'phone', 'role_id'];
        
        if (!in_array($field, $allowedFields)) {
            return redirect()->back()->with('error', 'Champ non autorisé');
        }
        
        // Validation spécifique selon le champ
        if ($field === 'email') {
            $request->validate([
                'value' => 'required|email|unique:users,email,' . $user->id,
            ]);
        } elseif (in_array($field, ['first_name', 'last_name'])) {
            $request->validate([
                'value' => 'required|string|max:255',
            ]);
        }
        
        // Mise à jour du champ
        $user->$field = $value;
        $user->save();
        

        
        return redirect()->back()->with('success', 'Information mise à jour avec succès');
    }
    public function updatePassword(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        // Valider les données
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        
        // Mettre à jour le mot de passe
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            $user->delete();
            
            return redirect()->route('apps.users.index')
                ->with('success', 'L\'utilisateur a été supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('apps.users.index')
                ->with('error', 'Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage());
        }
    }
    protected function handleDatabaseError(\Exception $e, $redirect)
{
    if ($e instanceof \Illuminate\Database\QueryException) {
        $errorCode = $e->errorInfo[1] ?? null;
        
        // Erreur de duplication (MySQL code 1062)
        if ($errorCode == 1062) {
            preg_match("/Duplicate entry '(.+)' for key '(.+)'/", $e->getMessage(), $matches);
            $value = $matches[1] ?? 'une valeur';
            $field = str_replace(['users_', '_unique'], '', $matches[2] ?? 'ce champ');
            
            // Formater un message d'erreur plus convivial
            $fieldLabels = [
                'email' => 'adresse e-mail',
                'phone' => 'numéro de téléphone',
                'username' => 'nom d\'utilisateur'
            ];
            
            $fieldLabel = $fieldLabels[$field] ?? $field;
            $message = "L'$fieldLabel \"$value\" est déjà utilisé(e) par un autre utilisateur.";
            
            return redirect()->to($redirect)->with('error', $message);
        }
        
        // Erreur de clé étrangère (MySQL code 1451)
        if ($errorCode == 1451) {
            return redirect()->to($redirect)->with('error', 
                'Impossible de supprimer cet élément car il est utilisé par d\'autres enregistrements.');
        }
    }
    
    // Erreur générique
    return redirect()->to($redirect)->with('error', 'Une erreur est survenue: ' . $e->getMessage());
}
    public function updateAvatar(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        try {
            // Create directory if it doesn't exist
            $directory = 'assets/images/avatars';
            $publicPath = public_path($directory);
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            // Delete old image if exists (from public directory)
            if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path))) {
                unlink(public_path($user->profile_photo_path));
            }
            
            // Move and save the new image directly to public folder
            $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move($publicPath, $fileName);
            
            // Set the path in database (without 'public/')
            $user->profile_photo_path = $directory . '/' . $fileName;
            $user->save();
            
            return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la photo: ' . $e->getMessage());
        }
    }
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();
        
        return redirect()->back()->with('success', 'Le rôle a été mis à jour avec succès.');
    }
    public function toggleStatus(User $user)
    {
        try {
            // Toggle the active status
            $user->is_active = !$user->is_active;
            $user->save();
            
            $status = $user->is_active ? 'activé' : 'désactivé';
            return redirect()->back()->with('success', "L'utilisateur a été {$status} avec succès.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Une erreur est survenue: " . $e->getMessage());
        }
    }
}
