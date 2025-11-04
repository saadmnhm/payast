<x-default-layout>
    <!-- Messages de notification -->
    @if(session('success'))
        <div class="alert alert-success mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-5">
            {{ session('error') }}
        </div>
    @endif
    
    @section('title')
        Users
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.users.show', $user) }}
    @endsection

    
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::User Info-->
                    <div class="d-flex flex-center flex-column py-5">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            @if($user->profile_photo_url)
                                <img src="{{ $user->profile_photo_url }}" alt="image"/>
                            @else
                                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $user->name) }}">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <div class="position-absolute bottom-0 end-0">
                                <button type="button" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_avatar">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                            </div>
                        </div>
                        
                        <!--begin::Name-->
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $user->name }}</a>
                        <!--end::Name-->
                        
                        <!--begin::Position-->
                        <div class="mb-9">
                            <div class="badge badge-lg badge-light-primary d-inline ms-10">{{ $user->role->name }}</div>
                            <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-2" 
                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                        <i class="ki-duotone ki-pencil fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                        </div>
                        <form action="{{ route('apps.users.toggle-status', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @if($user->is_active)
                                <button type="submit" class="btn btn-light danger my-1 me-2"
                                        onclick="return confirm('Êtes-vous sûr de vouloir bloquer cet utilisateur? Il ne pourra plus se connecter.')">
                                    Bloquer l'utilisateur
                                </button>
                            @else
                                <button type="submit" class="btn btn-light success my-1 me-2"
                                        onclick="return confirm('Êtes-vous sûr de vouloir débloquer cet utilisateur?')">
                                    Débloquer l'utilisateur
                                </button>
                            @endif
                        </form>
                </div>
                    <!--end::User Info-->
                   
                    <div class="separator"></div>
                    
                    <!--begin::Details content-->
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Email</div>
                            <div class="text-gray-600">
                                <a href="#" class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                            </div>
                            
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Télephone</div>
                            <div class="text-gray-600">
                                <a href="#" class="text-gray-600 text-hover-primary">{{ $user->phone }}</a>
                            </div>
                        </div>
                    </div>
                    <!--end::Details content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->
        
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">Information Personnel</a>
                </li>
                <!--end:::Tab item-->
                
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_security">Mot de passe</a>
                </li>
                <!--end:::Tab item-->
                <li class="nav-item ms-auto">
                    <!--begin::Action menu-->
                    <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions 
                    <i class="ki-duotone ki-down fs-2 me-0"></i></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true" style="">
                        <!--begin::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#kt_modal_confirm_delete">Supprimer</a>
                        </div>
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu-->
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Profile</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        <tr>
                                            <td>Nom</td>
                                            <td>{{ $user->last_name ?? 'Non défini' }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" 
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_lastname">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Prénom</td>
                                            <td>{{ $user->first_name ?? 'Non défini' }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" 
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_firstname">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" 
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Card body-->
                        
                        <!-- Save Button -->
                        
                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->
                
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h2>Profile</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-5">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        <tr>
                                            <td>Mot de passe</td>
                                            <td>******</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->
    
    <!-- Modals pour l'édition des champs -->
    <!-- Modal pour éditer le nom -->
    <div class="modal fade" id="kt_modal_update_lastname" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" action="{{ route('apps.users.update-field', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="field" value="last_name">
                    
                    <div class="modal-header">
                        <h2 class="fw-bold">Modifier le nom</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2">Nom</label>
                            <input class="form-control form-control-solid" placeholder="Entrer le nom" name="value" value="{{ $user->last_name ?? '' }}"/>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour éditer le prénom -->
    <div class="modal fade" id="kt_modal_update_firstname" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" action="{{ route('apps.users.update-field', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="field" value="first_name">
                    
                    <div class="modal-header">
                        <h2 class="fw-bold">Modifier le prénom</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2">Prénom</label>
                            <input class="form-control form-control-solid" placeholder="Entrer le prénom" name="value" value="{{ $user->first_name ?? '' }}"/>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour éditer l'email -->
    <div class="modal fade" id="kt_modal_update_email" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" action="{{ route('apps.users.update-field', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="field" value="email">
                    
                    <div class="modal-header">
                        <h2 class="fw-bold">Modifier l'email</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2">Adresse email</label>
                            <input type="email" class="form-control form-control-solid" placeholder="Entrer l'email" name="value" value="{{ $user->email }}"/>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal pour éditer le mot de passe -->
    <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" action="{{ route('apps.users.update-password', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-header">
                        <h2 class="fw-bold">Modifier le mot de passe</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2">Nouveau mot de passe</label>
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-solid" 
                                       placeholder="Entrer le nouveau mot de passe" name="password" id="password"/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle-y top-50 end-0 me-2" 
                                      id="togglePassword">
                                    <i class="ki-duotone ki-eye fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="fv-row mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2">Confirmer le mot de passe</label>
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-solid" 
                                       placeholder="Confirmer le mot de passe" name="password_confirmation" id="password_confirmation"/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle-y top-50 end-0 me-2" 
                                      id="togglePasswordConfirmation">
                                    <i class="ki-duotone ki-eye fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- delete modal --}}
    <!-- Modal de confirmation de suppression -->
<div class="modal fade" id="kt_modal_confirm_delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Confirmer la suppression</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            
            <div class="modal-body text-center pt-3">
                <i class="ki-duotone ki-warning fs-5x text-warning mb-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <p class="fw-bold text-gray-900 fs-2 mb-0">Êtes-vous sûr de vouloir supprimer cet utilisateur?</p>
                <p class="text-gray-700 fs-5 mb-5">Cette action ne peut pas être annulée.</p>
                
                <form action="{{ route('apps.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="text-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal pour éditer la photo de profil -->
<div class="modal fade" id="kt_modal_update_avatar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form class="form" action="{{ route('apps.users.update-avatar', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="modal-header">
                    <h2 class="fw-bold">Modifier la photo de profil</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="text-center mb-7">
                        <div class="image-input image-input-outline image-input-placeholder mb-4" data-kt-image-input="true">
                            @if($user->profile_photo_url)
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $user->profile_photo_url }})"></div>
                            @else
                                <div class="image-input-wrapper w-125px h-125px"></div>
                            @endif
                            
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>
                            
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            
                            @if($user->profile_photo_url)
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            @endif
                        </div>
                        
                        <div class="form-text">Types de fichiers autorisés: png, jpg, jpeg.</div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal pour modifier le rôle -->
<div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form class="form" action="{{ route('apps.users.update-field', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="field" value="role_id">
                
                <div class="modal-header">
                    <h2 class="fw-bold">Modifier le rôle</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold form-label mb-2">Rôle</label>
                        <select class="form-select form-select-solid" name="value">
                            @foreach(\App\Models\Role::all() as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
{{-- form validation password --}}
<script type="text/javascript">
    // Password visibility toggle and validation
    document.addEventListener('DOMContentLoaded', function() {
        // For password field
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const passwordConfirmation = document.querySelector('#password_confirmation');
        const submitButton = document.querySelector('#kt_modal_update_password button[type="submit"]');
        
        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'fv-plugins-message-container invalid-feedback mt-2';
        errorDiv.innerHTML = '<div data-field="password_confirmation">Les mots de passe ne correspondent pas</div>';
        errorDiv.style.display = 'none';
        
        // Insert error message after password confirmation field
        passwordConfirmation.parentNode.parentNode.appendChild(errorDiv);
        
        // Password visibility toggle functions
        togglePassword.addEventListener('click', function() {
            // Toggle type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle icon
            if (type === 'text') {
                this.innerHTML = `<i class="ki-duotone ki-eye-slash fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>`;
            } else {
                this.innerHTML = `<i class="ki-duotone ki-eye fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>`;
            }
        });
        
        // For password confirmation field
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        
        togglePasswordConfirmation.addEventListener('click', function() {
            // Toggle type attribute
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            
            // Toggle icon
            if (type === 'text') {
                this.innerHTML = `<i class="ki-duotone ki-eye-slash fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>`;
            } else {
                this.innerHTML = `<i class="ki-duotone ki-eye fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>`;
            }
        });
        
        // Password match validation
        function validatePasswordMatch() {
            if (password.value && passwordConfirmation.value) {
                if (password.value !== passwordConfirmation.value) {
                    errorDiv.style.display = 'block';
                    passwordConfirmation.classList.add('is-invalid');
                    submitButton.disabled = true;
                    return false;
                } else {
                    errorDiv.style.display = 'none';
                    passwordConfirmation.classList.remove('is-invalid');
                    submitButton.disabled = false;
                    return true;
                }
            }
            return true;
        }
        
        // Check on input
        password.addEventListener('input', validatePasswordMatch);
        passwordConfirmation.addEventListener('input', validatePasswordMatch);
        
        // Final check on form submission
        document.querySelector('#kt_modal_update_password form').addEventListener('submit', function(e) {
            if (!validatePasswordMatch()) {
                e.preventDefault();
            }
        });
    });
</script>



@endpush
</x-default-layout>