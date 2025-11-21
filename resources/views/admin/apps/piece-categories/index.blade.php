<x-default-layout>

@section('title', 'Catégories de Pièces')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Catégories de Pièces</h1>
        <a href="{{ route('apps.piece-categories.create') }}" class="btn btn-primary">Ajouter une catégorie</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="alert alert-info">Aucune catégorie trouvée.</div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-300 gy-5">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Nom</th>
                                <th>Slug</th>
                                <th>Sous-catégories</th>
                                <th>Pièces</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($category->image)
                                                <img src="{{ asset('storage/'.$category->image) }}" class="me-3" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @endif
                                            <div>
                                                <a href="{{ route('apps.piece-categories.show', $category) }}" class="text-gray-800 text-hover-primary fw-bold">
                                                    {{ $category->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-info">{{ $category->slug }}</span>
                                    </td>
                                    <td>
                                        @if($category->children->count() > 0)
                                            <span class="badge badge-light-primary">{{ $category->children->count() }}</span>
                                            <div class="small text-muted mt-1">
                                                @foreach($category->children->take(3) as $child)
                                                    <span class="badge badge-sm badge-light me-1">{{ $child->name }}</span>
                                                @endforeach
                                                @if($category->children->count() > 3)
                                                    <span class="badge badge-sm badge-light">+{{ $category->children->count() - 3 }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-light-success">{{ $category->pieces->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input toggle-status" type="checkbox" 
                                                   data-id="{{ $category->id }}" 
                                                   data-url="{{ route('apps.piece-categories.toggle-status', $category) }}"
                                                   {{ $category->is_active ? 'checked' : '' }} />
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('apps.piece-categories.show', $category) }}" class="btn btn-sm btn-light btn-active-light-primary me-2">
                                            Voir
                                        </a>
                                        <a href="{{ route('apps.piece-categories.edit', $category) }}" class="btn btn-sm btn-warning me-2">
                                            Éditer
                                        </a>
                                        <form action="{{ route('apps.piece-categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                                @if($category->children->isNotEmpty())
                                    @foreach($category->children as $child)
                                        <tr class="bg-light">
                                            <td class="ps-10">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-arrow-right fs-5 me-2"></i>
                                                    @if($child->image)
                                                        <img src="{{ asset('storage/'.$child->image) }}" class="me-3" alt="{{ $child->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                    @endif
                                                    <a href="{{ route('apps.piece-categories.show', $child) }}" class="text-gray-700 text-hover-primary">
                                                        {{ $child->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-info">{{ $child->slug }}</span>
                                            </td>
                                            <td>-</td>
                                            <td>
                                                <span class="badge badge-light-success">{{ $child->pieces->count() }}</span>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input toggle-status" type="checkbox" 
                                                           data-id="{{ $child->id }}" 
                                                           data-url="{{ route('apps.piece-categories.toggle-status', $child) }}"
                                                           {{ $child->is_active ? 'checked' : '' }} />
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('apps.piece-categories.show', $child) }}" class="btn btn-sm btn-light btn-active-light-primary me-2">
                                                    Voir
                                                </a>
                                                <a href="{{ route('apps.piece-categories.edit', $child) }}" class="btn btn-sm btn-warning me-2">
                                                    Éditer
                                                </a>
                                                <form action="{{ route('apps.piece-categories.destroy', $child) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
