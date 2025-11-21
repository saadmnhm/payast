<x-default-layout>

@section('title', 'Gestion des Pièces')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Pièces</h1>
        <a href="{{ route('apps.pieces.create') }}" class="btn btn-primary">Ajouter une pièce</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-5">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filtrer par catégorie</label>
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @foreach($category->children as $child)
                                <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;↳ {{ $child->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filtrer par marque</label>
                    <select name="brand_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes les marques</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    @if(request('category_id') || request('brand_id'))
                        <a href="{{ route('apps.pieces.index') }}" class="btn btn-secondary">Réinitialiser</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($pieces->isEmpty())
        <div class="alert alert-info">Aucune pièce trouvée.</div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-300 gy-5">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Pièce</th>
                                <th>Référence</th>
                                <th>Catégorie</th>
                                <th>Marque</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pieces as $piece)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($piece->image)
                                                <img src="{{ asset('storage/'.$piece->image) }}" class="me-3" alt="{{ $piece->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @endif
                                            <div>
                                                <a href="{{ route('apps.pieces.show', $piece) }}" class="text-gray-800 text-hover-primary fw-bold">
                                                    {{ $piece->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light">{{ $piece->reference }}</span>
                                    </td>
                                    <td>
                                        @if($piece->category)
                                            <a href="{{ route('apps.piece-categories.show', $piece->category) }}" class="text-primary">
                                                {{ $piece->category->name }}
                                            </a>
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
                                    <td>
                                        @if($piece->price)
                                            <span class="fw-bold">{{ number_format($piece->price, 2) }} DH</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $piece->stock > 0 ? 'badge-light-success' : 'badge-light-danger' }}">
                                            {{ $piece->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input toggle-status" type="checkbox" 
                                                   data-id="{{ $piece->id }}" 
                                                   data-url="{{ route('apps.pieces.toggle-status', $piece) }}"
                                                   {{ $piece->is_active ? 'checked' : '' }} />
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('apps.pieces.show', $piece) }}" class="btn btn-sm btn-light btn-active-light-primary me-2">
                                            Voir
                                        </a>
                                        <a href="{{ route('apps.pieces.edit', $piece) }}" class="btn btn-sm btn-warning me-2">
                                            Éditer
                                        </a>
                                        <form action="{{ route('apps.pieces.destroy', $piece) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette pièce ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $pieces->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.toggle-status').change(function() {
            const checkbox = $(this);
            const url = checkbox.data('url');
            
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Statut mis à jour avec succès');
                    }
                },
                error: function() {
                    toastr.error('Erreur lors de la mise à jour du statut');
                    checkbox.prop('checked', !checkbox.is(':checked'));
                }
            });
        });
    });
</script>
@endpush

</x-default-layout>
