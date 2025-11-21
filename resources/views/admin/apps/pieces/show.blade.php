<x-default-layout>

@section('title', 'Détails de la pièce: ' . $piece->name)

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $piece->name }}</h1>
        <div>
            <a href="{{ route('apps.pieces.edit', $piece) }}" class="btn btn-warning me-2">Éditer</a>
            <a href="{{ route('apps.pieces.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    <div class="row g-5">
        <div class="col-xl-5">
            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title">Image de la pièce</h3>
                </div>
                <div class="card-body text-center">
                    @if($piece->image)
                        <img src="{{ asset('storage/'.$piece->image) }}" class="img-fluid rounded" alt="{{ $piece->name }}" style="max-height: 400px;">
                    @else
                        <div class="bg-light p-5 rounded">
                            <p class="text-muted">Aucune image disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="card card-flush">
                <div class="card-header">
                    <h3 class="card-title">Informations de la pièce</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Nom:</label>
                            <div class="fs-5">{{ $piece->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Référence:</label>
                            <div class="fs-5">
                                <span class="badge badge-light-primary">{{ $piece->reference }}</span>
                            </div>
                        </div>
                    </div>

                    @if($piece->description)
                        <div class="mb-4">
                            <label class="fw-bold text-muted">Description:</label>
                            <div class="fs-6">{{ $piece->description }}</div>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Catégorie:</label>
                            <div class="fs-6">
                                @if($piece->category)
                                    <a href="{{ route('apps.piece-categories.show', $piece->category) }}" class="text-primary">
                                        {{ $piece->category->name }}
                                    </a>
                                @else
                                    <span class="text-muted">Non définie</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Marque:</label>
                            <div class="fs-6">
                                @if($piece->brand)
                                    {{ $piece->brand->label }}
                                @else
                                    <span class="text-muted">Non définie</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="fw-bold text-muted">Prix:</label>
                            <div class="fs-4 fw-bold text-primary">
                                @if($piece->price)
                                    {{ number_format($piece->price, 2) }} DH
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold text-muted">Stock:</label>
                            <div class="fs-4">
                                <span class="badge {{ $piece->stock > 0 ? 'badge-success' : 'badge-danger' }} fs-5">
                                    {{ $piece->stock }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold text-muted">Statut:</label>
                            <div>
                                @if($piece->is_active)
                                    <span class="badge badge-success fs-6">Active</span>
                                @else
                                    <span class="badge badge-danger fs-6">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="separator my-4"></div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted small">Créée le:</label>
                            <div class="fs-6">{{ $piece->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold text-muted small">Mise à jour le:</label>
                            <div class="fs-6">{{ $piece->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-default-layout>
