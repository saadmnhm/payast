<x-default-layout>
    @section('title')
        Trashed Users
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.trashed') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" id="userSearchInput" class="form-control form-control-solid w-250px ps-13" placeholder="Search user"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('user-management.users.index') }}" class="btn btn-primary me-3">
                        Back to Active Users
                    </a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!-- Begin Trashed User Cards -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9 user-cards-container">
                @foreach($trashedUsers as $user)
                <!--begin::Col-->
                <div class="col-md-4 user-card" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}">
                    <!--begin::Card-->
                    <div class="card card-flush h-md-100">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>{{ $user->name }}</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-1">
                            <!--begin::User info-->
                            <div class="d-flex flex-center mb-5">
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    @if($user->profile_photo_path)
                                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"/>
                                    @else
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!--end::User info-->
                            <!--begin::Email-->
                            <div class="fw-bold text-gray-600 mb-5">{{ $user->email }}</div>
                            <!--end::Email-->
                            <!--begin::Delete date-->
                            <div class="d-flex flex-column text-gray-600">
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-danger me-3"></span>
                                    Deleted at: {{ $user->deleted_at->format('Y-m-d H:i') }}
                                </div>
                            </div>
                            <!--end::Delete date-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card footer-->
                        <div class="card-footer flex-wrap pt-0">
                            <form action="{{ route('user-management.users.restore', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-light btn-active-primary my-1 me-2">
                                    Restore User
                                </button>
                            </form>
                        </div>
                        <!--end::Card footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                @endforeach
            </div>
            <!-- End Trashed User Cards -->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
    <script>
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
    </script>
    @endpush
</x-default-layout>