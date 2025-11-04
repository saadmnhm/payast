<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AddUserModal extends Component
{
    use WithFileUploads;

    public $user_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $role;
    public $avatar;
    public $saved_avatar;
    public $password;
    public $edit_mode = false;

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20', 
            'password' => $this->edit_mode ? 'nullable|min:8' : 'required|min:8',
            'role' => 'required',
            'avatar' => 'nullable|image|max:1024',
        ];
    }
    
    protected function messages()
    {
        return [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.regex' => 'Format de téléphone invalide. Utilisez uniquement des chiffres, espaces, +, - ou ().',
            'phone.min' => 'Le numéro de téléphone doit avoir au moins 10 caractères.',
            'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role.required' => 'Veuillez sélectionner un rôle.',
            // 'role.exists' => 'Le rôle sélectionné n\'existe pas.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.max' => 'La taille de l\'image ne doit pas dépasser 1Mo.',
        ];
    }
    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
        'new_user' => 'hydrate',
        'toggle_user_status' => 'toggleUserStatus',
    ];


    public function render()
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

        return view('livewire.user.add-user-modal', compact('roles'));
    }

    
    public function submit()
    {
        try {
            $validatedData = $this->validate();
            
            DB::beginTransaction();
            
            $data = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role_id' => $this->role,
            ];

            // print_r($data);exit;
            
            $data['name'] = $this->first_name . ' ' . $this->last_name;
            if ($this->avatar) {
                try {
                    $originalName = $this->avatar->getClientOriginalName();
                    \Log::info("Uploading file: {$originalName}");
                    
                    $filename = time() . '_' . $originalName;
                    
                    $targetDirectory = public_path('assets/images/avatars');
                    if (!file_exists($targetDirectory)) {
                        \Log::info("Creating directory: {$targetDirectory}");
                        mkdir($targetDirectory, 0777, true);
                        chmod($targetDirectory, 0777); // Ensure permissions are set
                    }
                    
                    \Log::info("Attempting to move file to: {$targetDirectory}/{$filename}");
                    
                    $this->avatar->storeAs('/', $filename, ['disk' => 'public_uploads']);
                    
                    
                    \Log::info("File moved successfully");
                    
                    $data['profile_photo_path'] = 'assets/images/avatars/' . $filename;
                } catch (\Exception $e) {
                    \Log::error('Failed to upload image: ' . $e->getMessage());
                    \Log::error($e->getTraceAsString());
                    session()->flash('error', 'Failed to upload image: ' . $e->getMessage());
                    $data['profile_photo_path'] = null;
                }
            } else {
                $data['profile_photo_path'] = null;
            }
                        
            if ($this->edit_mode) {
                $user = User::findOrFail($this->user_id);
                
                if (!empty($this->password)) {
                    $data['password'] = Hash::make($this->password);
                }
                
                $user->update($data);
                $successMessage = __('User updated successfully');
            } else {
                $data['password'] = Hash::make($this->password);
                $data['is_active'] = true; 
                
                $user = User::create($data);
                $successMessage = __('User created successfully');
            }
            
            // if ($user && $this->role) {
            //     $user->syncRoles([$this->role]);
            // }

            
            DB::commit();
            
            $this->reset(['first_name', 'last_name', 'email', 'phone', 'role', 'password', 'avatar']);
            $this->edit_mode = false;
            $this->user_id = null;
            
            $this->dispatch('success', $successMessage);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            print_r($e->getMessage());exit;
            DB::rollBack();
            $this->dispatch('error', 'Please correct the errors in the form.');
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error', $e->getMessage());
        }
    }

    public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete(); // This will soft delete since you're using SoftDeletes trait
    
    $this->dispatch('success', __('User deleted successfully'));
}

public function updateUser($id)
{
    $this->edit_mode = true;

    $user = User::findOrFail($id);

    $this->user_id = $user->id;
    $this->saved_avatar = $user->profile_photo_url;
    $this->first_name = $user->first_name;
    $this->last_name = $user->last_name;
    $this->email = $user->email;
    $this->phone = $user->phone;
    $this->role = $user->roles?->first()->name ?? '';
    $this->password = '';
    
    // Emit an event to open the modal via JavaScript
    $this->dispatch('open-user-modal');
}


    public function trashed()
    {
        $trashedUsers = User::onlyTrashed()->get();
        return view('admin.apps.users.trashed', compact('trashedUsers'));
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        
        $this->dispatch('success', ['message' => 'User restored successfully']);
    }
    public function toggleUserStatus($id)
    {
    $user = User::findOrFail($id);
    $user->is_active = !$user->is_active;
    $user->save();
    
    $status = $user->is_active ? 'enabled' : 'disabled';
    $this->dispatch('success', __("User {$status} successfully"));
    }
}
