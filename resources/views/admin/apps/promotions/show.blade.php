<x-default-layout>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            {{ Breadcrumbs::render('apps.promotions.show', $promotion) }}
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails de la Promotion</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.promotions.edit', $promotion) }}" class="btn btn-sm btn-primary">
                            {!! getIcon('pencil', 'fs-3') !!}
                            Modifier
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-7">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Titre</label>
                            <p class="fw-bold fs-6 text-gray-800">{{ $promotion->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Slug</label>
                            <p class="fw-bold fs-6 text-gray-800">{{ $promotion->slug }}</p>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Prix Promo</label>
                            <p class="fw-bold fs-6 text-success">{{ $promotion->formatted_price }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Ordre</label>
                            <p class="fw-bold fs-6 text-gray-800">{{ $promotion->order }}</p>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Icône</label>
                            <p class="fw-bold fs-6 text-gray-800">
                                @if($promotion->icon)
                                    <i class="{{ $promotion->icon }}"></i> {{ $promotion->icon }}
                                @else
                                    <span class="text-muted">Aucune</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Statut</label>
                            <p>
                                @if($promotion->is_active)
                                    <span class="badge badge-light-success fs-7">Actif</span>
                                @else
                                    <span class="badge badge-light-danger fs-7">Inactif</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mb-7">
                        <label class="fw-bold text-muted">Pièce Associée</label>
                        <p class="fw-bold fs-6">
                            @if($promotion->piece)
                                <a href="{{ route('apps.cataloge.pieces.show', $promotion->piece) }}" class="text-primary">
                                    {{ $promotion->piece->name }} - {{ $promotion->piece->reference }}
                                </a>
                            @else
                                <span class="text-muted">Aucune pièce associée</span>
                            @endif
                        </p>
                    </div>

                    @if($promotion->description)
                        <div class="mb-7">
                            <label class="fw-bold text-muted">Description</label>
                            <p class="fw-semibold fs-6 text-gray-600">{{ $promotion->description }}</p>
                        </div>
                    @endif

                    @if($promotion->image)
                        <div class="mb-7">
                            <label class="fw-bold text-muted">Image</label>
                            <div class="mt-3">
                                <img src="{{ $promotion->image_url }}" alt="{{ $promotion->title }}" 
                                     class="img-fluid rounded" style="max-width: 300px;">
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Créé le</label>
                            <p class="fw-semibold fs-6 text-gray-600">{{ $promotion->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Modifié le</label>
                            <p class="fw-semibold fs-6 text-gray-600">{{ $promotion->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-default-layout>