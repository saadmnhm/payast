<x-default-layout>
    @section('title', $piece->name)

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.cataloge.pieces.show', $piece) }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <div class="card mb-5 mb-xl-8">
                <div class="card-body">
                    <div class="d-flex flex-center flex-column py-5">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            <img src="{{ $piece->image_url }}" alt="{{ $piece->name }}" />
                        </div>

                        <h3 class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">
                            {{ $piece->name }}
                        </h3>

                        <div class="mb-9">
                            <div class="badge badge-lg badge-light-primary d-inline">
                                {{ $piece->reference }}
                            </div>
                        </div>

                        @if($piece->brand)
                            <div class="mb-6">
                                @if($piece->brand_image_url)
                                    <img src="{{ $piece->brand_image_url }}" alt="{{ $piece->brand_name }}" style="max-height: 50px;" />
                                @else
                                    <span class="text-gray-600">{{ $piece->brand_name }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="fw-bold mb-3">
                            Prix: <span class="text-primary fs-2">{{ $piece->formatted_price }}</span>
                        </div>

                        @if($piece->stock > 0)
                            <span class="badge badge-light-success fs-7 fw-bold">En stock: {{ $piece->stock }}</span>
                        @else
                            <span class="badge badge-light-danger fs-7 fw-bold">Rupture de stock</span>
                        @endif
                    </div>

                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_piece_details" role="button">
                            Détails
                            {!! getIcon('down', 'fs-3 rotate-180') !!}
                        </div>
                    </div>

                    <div id="kt_piece_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <div class="fw-bold mt-5">Catégorie</div>
                            <div class="text-gray-600">
                                @if($piece->category)
                                    <a href="{{ route('apps.cataloge.categories.show', $piece->category) }}">
                                        {{ $piece->category->full_path }}
                                    </a>
                                @else
                                    Non classé
                                @endif
                            </div>

                            <div class="fw-bold mt-5">Statut</div>
                            <div class="text-gray-600">
                                @if($piece->is_active)
                                    <span class="badge badge-light-success">Actif</span>
                                @else
                                    <span class="badge badge-light-danger">Inactif</span>
                                @endif
                            </div>

                            <div class="fw-bold mt-5">Date de création</div>
                            <div class="text-gray-600">{{ $piece->created_at->format('d/m/Y à H:i') }}</div>

                            <div class="fw-bold mt-5">Dernière modification</div>
                            <div class="text-gray-600">{{ $piece->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-lg-row-fluid ms-lg-15">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <div class="card-title">
                        <h3>Description</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.cataloge.pieces.edit', $piece) }}" class="btn btn-sm btn-light-primary">
                            {!! getIcon('pencil', 'fs-3') !!}
                            Modifier
                        </a>
                    </div>
                </div>

                <div class="card-body p-9">
                    @if($piece->description)
                        <p class="text-gray-800 fs-6">{{ $piece->description }}</p>
                    @else
                        <p class="text-muted fst-italic">Aucune description disponible</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3>Informations techniques</h3>
                    </div>
                </div>

                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Référence</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $piece->reference }}</span>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Prix</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $piece->formatted_price }}</span>
                        </div>
                    </div>

                    @if($piece->brand)
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Marque</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">{{ $piece->brand_name }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Stock disponible</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $piece->stock }} unités</span>
                        </div>
                    </div>

                    @if($piece->category)
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-semibold text-muted">Catégorie</label>
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">{{ $piece->category->full_path }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-default-layout>
