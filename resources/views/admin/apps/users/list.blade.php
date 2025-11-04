<x-default-layout>
    @section('title')
        Gestion des utilisateurs
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.users.index') }}
    @endsection
    <style>
        /* Show dropdown on hover */
        .action-dropdown:hover .action-dropdown-menu {
            display: block;
            margin-top: 0;
            animation: fadeIn 0.2s ease-in;
        }
        
        /* Animation for dropdown */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Styling for dropdown items */
        .action-dropdown-menu .dropdown-item {
            padding: 0.5rem 1rem;
            transition: background-color 0.2s;
        }
        
        .action-dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        /* Make the button more visible on hover */
        .action-dropdown:hover .btn {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .action-dropdown{
            position: relative;
            top: 16px;
            left: 10px;
        }
        .disable-user{
        position: relative;
        left: 75px;
        bottom: 24px;
        width: 20px;
        height: 20px;
        background: var(--bs-danger);
        border-radius: 45px;
        }
        .enable-user{
        position: relative;
        left: 75px;
        bottom: 24px;
        width: 20px;
        height: 20px;
        background: var(--bs-success);
        color: var(--bs-success) ;
        border-radius: 45px;
        }
        .success{
            background-color: var(--bs-success) !important;
            color: white !important;
        }
        .danger{
            background-color: var(--bs-danger) !important;
            color: white !important ;
        }
        .success:hover{
            color: var(--bs-success) !important ;
        }
        .danger:hover{
            color: var(--bs-danger) !important ;
        }
    </style>
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" id="userSearchInput" class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher utilisateur"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <!-- Add this to your card-toolbar section -->
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end">
                        <div class="me-3">
                        </div>
                        <!-- Existing add user button -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                            {!! getIcon('plus', 'fs-2', '', 'i') !!}
                            Ajouter un utilisateur
                        </button>
                    </div>
                </div>
                <!--end::Toolbar-->

                <!--begin::Modal-->
                <livewire:user.add-user-modal></livewire:user.add-user-modal>
                <!--end::Modal-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!-- Begin User Cards -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-5 g-xl-9 user-cards-container">
                @foreach($users as $user)
                <!--begin::Col-->
                <div class="col-md-3 user-card" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}">
                    <!--begin::Card-->
                    <div class="card card-flush h-md-100 {{ !$user->is_active ? 'border border-danger' : '' }}">
                        
                        <!--begin::Card header-->
                        <div class="card-header justify-content-end align-items-center">
                            <!--begin::Card title-->
                            <div class="action-button">
                                <a href="{{ route('apps.users.show', $user) }}" 
                                   class="btn btn-icon btn-light-primary btn-active-light-primary btn-sm rounded-circle mx-1"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="Consulter">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--begin::Card body-->
                        <div class="card-body pt-1">
                            <!--begin::User info-->
                            <div class="d-flex flex-center mb-5">
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    @if($user->profile_photo_path)
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"/>
                                    <!-- Add after the img tag for debugging -->
                                @else
                                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                                        {{ substr($user->first_name, 0, 1) }}
                                    </div>
                                @endif
                                    <!-- Add status badge -->
                                    <div class="position-absolute top-left-status">
                                        @if($user->is_active)
                                            <div class="badge badge-light-success enable-user">.</div>
                                        @else
                                            <div class="badge badge-light-danger disable-user">.</div>
                                        @endif
                                    </div>
                            <!--end::Status badge-->
                                </div>
                            </div>
                            <!--end::User info-->
                            <div class="info d-flex justify-content-center text-center">
                               <div>
                                 <!--begin::name-->
                                 <!-- Replace in the user card section -->
                                    <div class="fw-bold text-gray-600 mb-5">{{ $user->first_name }} {{ $user->last_name }}</div>
                                 <!--end::name-->
                                 <!--begin::Role-->
                                 <div class="d-flex flex-column text-gray-600">
                                     <div class="badge badge-lg badge-light-primary d-flex align-items-center py-2 justify-content-center">
                                         {{ $user->role ? $user->role->name : 'No role assigned' }}
                                     </div>
                                 </div>
                                 <!--end::Role-->
                               </div>

                            </div>
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card footer-->
                        <div class="card-footer flex-wrap pt-0 d-flex justify-content-center">
                            
                            @if($user->is_active)
                                <button type="button" class="btn btn-light danger my-1 me-2"
                                        onclick="confirmToggleStatus({{ $user->id }}, 'disable')">
                                        Bloquer l'utilisateur
                                </button>
                            @else
                                <button type="button" class="btn btn-light success my-1 me-2"
                                        onclick="confirmToggleStatus({{ $user->id }}, 'enable')">
                                        Débloquer l'utilisateur
                                </button>
                            @endif
                        </div>
<!--end::Card footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                @endforeach

                
            </div>
            <!-- End User Cards -->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
    <script>
        
document.addEventListener('livewire:init', function () {
        Livewire.on('open-user-modal', function () {
            // Open the modal using Bootstrap's modal API
            var modal = new bootstrap.Modal(document.getElementById('kt_modal_add_user'));
            modal.show();
        });
        
        Livewire.on('success', function (message) {
            // Reload page to refresh the list
            setTimeout(() => location.reload(), 1000);
        });
    });

function confirmToggleStatus(userId, action) {
        const message = action === 'disable' 
            ? 'Are you sure you want to disable this user? They will not be able to login.'
            : 'Are you sure you want to enable this user?';
            
        if (confirm(message)) {
            Livewire.dispatch('toggle_user_status', { id: userId });
        }
    }


        // Search functionality
        document.getElementById('userSearchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const userCards = document.querySelectorAll('.user-card');
            
            userCards.forEach(card => {
                const userName = card.getAttribute('data-user-name').toLowerCase();
                const userEmail = card.getAttribute('data-user-email').toLowerCase();
                
                if (userName.includes(searchValue) || userEmail.includes(searchValue)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Delete confirmation
        // Delete confirmation
function confirmDelete(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        Livewire.dispatch('delete_user', { id: userId });
    }
}

// Refresh cards after operations
document.addEventListener('livewire:init', function () {
    Livewire.on('success', function (message) {
       
        // Reload page to refresh the list
        setTimeout(() => location.reload(), 1000);
    });
});

        $('#kt_modal_add_user').on('hidden.bs.modal', function () {
            Livewire.dispatch('new_user');
        });
    </script>
    @endpush
</x-default-layout>