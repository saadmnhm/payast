<x-default-layout>
    @section('title', $category->title)

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.cataloge.categories.show', $category) }}
    @endsection

    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <div class="card mb-5 mb-xl-8">
                <div class="card-body">
                    <div class="d-flex flex-center flex-column py-5">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            <img src="{{ $category->image_url }}" alt="{{ $category->title }}" />
                        </div>

                        <h3 class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">
                            {{ $category->title }}
                        </h3>

                        <div class="mb-9">
                            @if($category->is_active)
                                <span class="badge badge-lg badge-light-success">Active</span>
                            @else
                                <span class="badge badge-lg badge-light-danger">Inactive</span>
                            @endif
                        </div>

                        @if($category->icon)
                            <div class="mb-6">
                                {!! getIcon($category->icon, 'fs-2x text-primary') !!}
                            </div>
                        @endif
                    </div>

                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_category_details" role="button">
                            Détails
                            {!! getIcon('down', 'fs-3 rotate-180') !!}
                        </div>
                    </div>

                    <div id="kt_category_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <div class="fw-bold mt-5">Slug</div>
                            <div class="text-gray-600">
                                <code>{{ $category->slug }}</code>
                            </div>

                            @if($category->parent)
                                <div class="fw-bold mt-5">Catégorie parente</div>
                                <div class="text-gray-600">
                                    <a href="{{ route('apps.cataloge.categories.show', $category->parent) }}">
                                        {{ $category->parent->title }}
                                    </a>
                                </div>
                            @else
                                <div class="fw-bold mt-5">Type</div>
                                <div class="text-gray-600">
                                    <span class="badge badge-light-primary">Catégorie principale</span>
                                </div>
                            @endif

                            <div class="fw-bold mt-5">Ordre d'affichage</div>
                            <div class="text-gray-600">{{ $category->order }}</div>

                            <div class="fw-bold mt-5">Sous-catégories</div>
                            <div class="text-gray-600">{{ $category->children->count() }}</div>

                            <div class="fw-bold mt-5">Nombre de pièces</div>
                            <div class="text-gray-600">{{ $category->pieces->count() }}</div>

                            <div class="fw-bold mt-5">Date de création</div>
                            <div class="text-gray-600">{{ $category->created_at->format('d/m/Y à H:i') }}</div>

                            <div class="fw-bold mt-5">Dernière modification</div>
                            <div class="text-gray-600">{{ $category->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>

                    <div class="separator separator-dashed my-5"></div>

                    <div class="d-flex flex-stack">
                        <a href="{{ route('apps.cataloge.categories.edit', $category) }}" class="btn btn-sm btn-light-primary w-100">
                            {!! getIcon('pencil', 'fs-3') !!}
                            Modifier la catégorie
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-lg-row-fluid ms-lg-15">
            @if($category->description)
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Description</h3>
                        </div>
                    </div>

                    <div class="card-body p-9">
                        <p class="text-gray-800 fs-6">{{ $category->description }}</p>
                    </div>
                </div>
            @endif

            @if($category->children->count() > 0)
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Sous-catégories ({{ $category->children->count() }})</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('apps.cataloge.categories.create') }}" class="btn btn-sm btn-light-primary">
                                {!! getIcon('plus', 'fs-3') !!}
                                Ajouter
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-9">
                        <div class="row g-5">
                            @foreach($category->children as $child)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center border border-dashed border-gray-300 rounded p-5">
                                        <div class="symbol symbol-50px me-5">
                                            <img src="{{ $child->image_url }}" alt="{{ $child->title }}" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{{ route('apps.cataloge.categories.show', $child) }}" class="fw-bold text-gray-800 text-hover-primary fs-5">
                                                {{ $child->title }}
                                            </a>
                                            <span class="text-muted d-block fw-semibold">
                                                {{ $child->pieces->count() }} pièce(s)
                                            </span>
                                        </div>
                                        <div>
                                            @if($child->is_active)
                                                <span class="badge badge-light-success">Active</span>
                                            @else
                                                <span class="badge badge-light-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3>Pièces de cette catégorie ({{ $category->pieces->count() }})</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.cataloge.pieces.create') }}" class="btn btn-sm btn-light-success">
                            {!! getIcon('plus', 'fs-3') !!}
                            Ajouter une pièce
                        </a>
                    </div>
                </div>

                <div class="card-body p-9">
                    @if($category->pieces->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th class="min-w-150px">Pièce</th>
                                        <th class="min-w-100px">Référence</th>
                                        <th class="min-w-100px">Prix</th>
                                        <th class="min-w-80px">Stock</th>
                                        <th class="min-w-80px">Statut</th>
                                        <th class="min-w-100px text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->pieces as $piece)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-45px me-3">
                                                        <img src="{{ $piece->image_url }}" alt="{{ $piece->name }}" />
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="{{ route('apps.cataloge.pieces.show', $piece) }}" class="text-dark fw-bold text-hover-primary fs-6">
                                                            {{ $piece->name }}
                                                        </a>
                                                        @if($piece->brand)
                                                            <span class="text-muted fw-semibold d-block fs-7">
                                                                {{ $piece->brand }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">
                                                    {{ $piece->reference }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-bold d-block fs-6">
                                                    {{ $piece->formatted_price }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($piece->stock > 10)
                                                    <span class="badge badge-light-success">{{ $piece->stock }}</span>
                                                @elseif($piece->stock > 0)
                                                    <span class="badge badge-light-warning">{{ $piece->stock }}</span>
                                                @else
                                                    <span class="badge badge-light-danger">{{ $piece->stock }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($piece->is_active)
                                                    <span class="badge badge-light-success">Actif</span>
                                                @else
                                                    <span class="badge badge-light-danger">Inactif</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('apps.cataloge.pieces.show', $piece) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    {!! getIcon('eye', 'fs-3') !!}
                                                </a>
                                                <a href="{{ route('apps.cataloge.pieces.edit', $piece) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                    {!! getIcon('pencil', 'fs-3') !!}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-muted">Aucune pièce dans cette catégorie</p>
                            <a href="{{ route('apps.cataloge.pieces.create') }}" class="btn btn-success">
                                {!! getIcon('plus', 'fs-2') !!}
                                Créer la première pièce
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-default-layout>
