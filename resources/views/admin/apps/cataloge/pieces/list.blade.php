<x-default-layout>
    @section('title', 'Liste des pièces')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.cataloge.pieces.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-piece-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher une pièce" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-piece-table-toolbar="base">
                    <a href="{{ route('pieces.excel') }}" class="btn btn-success me-3">Export Pieces (Excel)</a>
                    <a href="{{ route('apps.cataloge.pieces.create') }}" class="btn btn-primary">{!! getIcon('plus', 'fs-2') !!} Ajouter une pièce</a>

                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="pieces-table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-200px">Nom</th>
                            <th class="min-w-100px">Référence</th>
                            <th class="min-w-125px">Catégorie</th>
                            <th class="min-w-100px">Marque</th>
                            <th class="min-w-100px text-end">Prix</th>
                            <th class="min-w-100px text-center">Stock</th>
                            <th class="min-w-100px text-center">Statut</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse($pieces as $piece)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($piece->image)
                                            <img src="{{ asset('uploads/' . $piece->image) }}" alt="{{ $piece->name }}" class="w-50px h-50px rounded me-3">
                                        @endif
                                        <span class="text-gray-800">{{ $piece->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $piece->reference ?? '-' }}</td>
                                <td>
                                    @if($piece->category)
                                        <span class="badge badge-light-info">{{ $piece->category->title }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($piece->brand)
                                        {{ $piece->brand->label }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ number_format($piece->price, 2) }} MAD</td>
                                <td class="text-center">
                                    @if($piece->stock > 10)
                                        <span class="badge badge-light-success">{{ $piece->stock }}</span>
                                    @elseif($piece->stock > 0)
                                        <span class="badge badge-light-warning">{{ $piece->stock }}</span>
                                    @else
                                        <span class="badge badge-light-danger">0</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($piece->is_active)
                                        <span class="badge badge-light-success">Actif</span>
                                    @else
                                        <span class="badge badge-light-danger">Inactif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('apps.cataloge.pieces.show', $piece) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                        {!! getIcon('eye', 'fs-5', '', 'i') !!}
                                        Voir
                                    </a>
                                    <a href="{{ route('apps.cataloge.pieces.edit', $piece) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                        {!! getIcon('pencil', 'fs-5', '', 'i') !!}
                                        Modifier
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-10">
                                    Aucune pièce disponible
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
            document.querySelector('[data-kt-piece-table-filter="search"]')?.addEventListener('keyup', function(e) {
                const searchText = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#pieces-table tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchText) ? '' : 'none';
                });
            });
        </script>
    @endpush
</x-default-layout>
