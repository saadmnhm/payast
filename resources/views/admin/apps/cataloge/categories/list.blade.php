<x-default-layout>
    @section('title', 'Liste des catégories')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.cataloge.categories.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-category-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher une catégorie" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-category-table-toolbar="base">
                    <a href="{{ route('apps.cataloge.categories.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2') !!}
                        Ajouter une catégorie
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="categories-table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Titre</th>
                            <th class="min-w-125px">Parent</th>
                            <th class="min-w-100px text-center">Ordre</th>
                            <th class="min-w-100px text-center">Statut</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse($categories as $category)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($category->image)
                                            <img src="{{ asset('uploads/' . $category->image) }}" alt="{{ $category->title }}" class="w-50px h-50px rounded me-3">
                                        @endif
                                        <span class="text-gray-800">{{ $category->title }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($category->parent)
                                        <span class="badge badge-light-primary">{{ $category->parent->title }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-light">{{ $category->order ?? 0 }}</span>
                                </td>
                                <td class="text-center">
                                    @if($category->is_active)
                                        <span class="badge badge-light-success">Actif</span>
                                    @else
                                        <span class="badge badge-light-danger">Inactif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('apps.cataloge.categories.show', $category) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                        {!! getIcon('eye', 'fs-5', '', 'i') !!}
                                        Voir
                                    </a>
                                    <a href="{{ route('apps.cataloge.categories.edit', $category) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                        {!! getIcon('pencil', 'fs-5', '', 'i') !!}
                                        Modifier
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-10">
                                    Aucune catégorie disponible
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelector('[data-kt-category-table-filter="search"]')?.addEventListener('keyup', function(e) {
                const searchText = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#categories-table tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchText) ? '' : 'none';
                });
            });
        </script>
    @endpush
</x-default-layout>
