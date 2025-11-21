<x-default-layout>

@section('title', 'Détails de la catégorie: ' . $pieceCategory->name)

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $pieceCategory->name }}</h1>
        <div>
            <a href="{{ route('apps.piece-categories.edit', $pieceCategory) }}" class="btn btn-warning me-2">Éditer</a>
            <a href="{{ route('apps.piece-categories.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <div class="row g-5 g-xl-10">
        <div class="col-xl-4">
            <div class="card card-flush mb-5">
                <div class="card-header">
                    <h3 class="card-title">Informations de la catégorie</h3>
                </div>
                <div class="card-body pt-0">
                    @if($pieceCategory->image)
                        <div class="text-center mb-5">
                            <img src="{{ asset('storage/'.$pieceCategory->image) }}" class="img-fluid rounded" alt="{{ $pieceCategory->name }}" style="max-height: 200px;">
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="fw-bold text-muted">Nom:</label>
                        <div class="fs-5">{{ $pieceCategory->name }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted">Slug:</label>
                        <div class="fs-6">
                            <span class="badge badge-light-info">{{ $pieceCategory->slug }}</span>
                        </div>
                    </div>

                    @if($pieceCategory->description)
                        <div class="mb-4">
                            <label class="fw-bold text-muted">Description:</label>
                            <div class="fs-6">{{ $pieceCategory->description }}</div>
                        </div>
                    @endif

                    @if($pieceCategory->parent)
                        <div class="mb-4">
                            <label class="fw-bold text-muted">Catégorie parente:</label>
                            <div class="fs-6">
                                <a href="{{ route('apps.piece-categories.show', $pieceCategory->parent) }}" class="text-primary">
                                    {{ $pieceCategory->parent->name }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="fw-bold text-muted">Ordre:</label>
                        <div class="fs-6">{{ $pieceCategory->order }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted">Statut:</label>
                        <div>
                            @if($pieceCategory->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted">Créée le:</label>
                        <div class="fs-6">{{ $pieceCategory->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted">Mise à jour le:</label>
                        <div class="fs-6">{{ $pieceCategory->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            @if($pieceCategory->children->isNotEmpty())
                <div class="card card-flush mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Sous-catégories ({{ $pieceCategory->children->count() }})</h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-300 gy-5">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800">
                                        <th>Nom</th>
                                        <th>Slug</th>
                                        <th>Pièces</th>
                                        <th>Statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pieceCategory->children as $child)
                                        <tr>
                                            <td>
                                                <a href="{{ route('apps.piece-categories.show', $child) }}" class="text-gray-800 text-hover-primary fw-bold">
                                                    {{ $child->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-info">{{ $child->slug }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-success">{{ $child->pieces->count() }}</span>
                                            </td>
                                            <td>
                                                @if($child->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('apps.piece-categories.edit', $child) }}" class="btn btn-sm btn-warning">Éditer</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title">Pièces dans cette catégorie ({{ $pieceCategory->pieces->count() }})</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.pieces.create') }}?category_id={{ $pieceCategory->id }}" class="btn btn-sm btn-primary">
                            Ajouter une pièce
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if($pieceCategory->pieces->isEmpty())
                        <div class="alert alert-info">Aucune pièce dans cette catégorie.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-300 gy-5">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800">
                                        <th>Pièce</th>
                                        <th>Référence</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pieceCategory->pieces as $piece)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($piece->image)
                                                        <img src="{{ asset('storage/'.$piece->image) }}" class="me-3" alt="{{ $piece->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    @endif
                                                    <a href="{{ route('apps.pieces.show', $piece) }}" class="text-gray-800 text-hover-primary fw-bold">
                                                        {{ $piece->name }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light">{{ $piece->reference }}</span>
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
                                                @if($piece->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('apps.pieces.edit', $piece) }}" class="btn btn-sm btn-warning">Éditer</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</x-default-layout>
