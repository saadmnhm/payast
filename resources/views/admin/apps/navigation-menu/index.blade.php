<x-default-layout>


@section('title', 'Gestion du Menu de Navigation')

    @section('breadcrumbs')
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="" class="text-muted text-hover-primary">Tableau de bord</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Menu de Navigation</li>
            </ul>
        </div>
    @endsection

@section('content')
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Menu de Navigation</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <!-- <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-menu-table-toolbar="base">
                    <a href="{{ route('apps.navigation-menu.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Ajouter un Menu
                    </a>
                </div>
            </div> -->
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="navigation_menu_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Titre</th>
                            <th class="min-w-125px">URL</th>
                            <th class="min-w-100px text-center">Ordre</th>
                            <th class="min-w-100px text-center">Statut</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse($menus as $menu)
                            <tr data-menu-id="{{ $menu->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($menu->icon)
                                            <span class="me-2">{!! getIcon($menu->icon, 'fs-2') !!}</span>
                                        @endif
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 fw-bold">{{ $menu->title }}</span>
                                            @if($menu->is_dropdown)
                                                <span class="badge badge-light-info badge-sm mt-1">Dropdown</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $menu->url ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-light">{{ $menu->order }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                        <input class="form-check-input toggle-status" type="checkbox" 
                                               data-menu-id="{{ $menu->id }}"
                                               {{ $menu->is_active ? 'checked' : '' }} />
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('apps.navigation-menu.edit', $menu) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                        {!! getIcon('pencil', 'fs-5', '', 'i') !!}
                                        Modifier
                                    </a>
                                    <form action="{{ route('apps.navigation-menu.destroy', $menu) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light btn-active-light-danger" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce menu ?')">
                                            {!! getIcon('trash', 'fs-5', '', 'i') !!}
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            @if($menu->children->count() > 0)
                                @foreach($menu->children as $child)
                                    <tr data-menu-id="{{ $child->id }}" class="bg-light-secondary">
                                        <td>
                                            <div class="d-flex align-items-center ps-10">
                                                <span class="me-2">{!! getIcon('arrow-right', 'fs-3') !!}</span>
                                                @if($child->icon)
                                                    <span class="me-2">{!! getIcon($child->icon, 'fs-2') !!}</span>
                                                @endif
                                                <span class="text-gray-800">{{ $child->title }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $child->url ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-light">{{ $child->order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                                <input class="form-check-input toggle-status" type="checkbox" 
                                                       data-menu-id="{{ $child->id }}"
                                                       {{ $child->is_active ? 'checked' : '' }} />
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('apps.navigation-menu.edit', $child) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                                {!! getIcon('pencil', 'fs-5', '', 'i') !!}
                                                Modifier
                                            </a>
                                            <form action="{{ route('apps.navigation-menu.destroy', $child) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light btn-active-light-danger" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sous-menu ?')">
                                                    {!! getIcon('trash', 'fs-5', '', 'i') !!}
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-10">
                                    Aucun menu disponible. Créez votre premier menu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
    <script>
        window.routes = {
            toggleStatus: "{{ route('apps.navigation-menu.toggle-status', ['navigationMenu' => '__MENU_ID__']) }}"
        };
        
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-status').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const menuId = this.dataset.menuId;
                    const isActive = this.checked;
                    
                    const statusUrl = window.routes.toggleStatus.replace('__MENU_ID__', menuId);
                    
                    fetch(statusUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success('Statut mis à jour avec succès');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('Erreur lors de la mise à jour du statut');
                        checkbox.checked = !isActive;
                    });
                });
            });
        });
    </script>
    @endpush
</x-default-layout>
