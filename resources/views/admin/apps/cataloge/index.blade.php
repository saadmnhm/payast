<x-default-layout>
    @section('title', 'Catalogue')

    @section('breadcrumbs')
    @endsection

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-6">
            <div class="card card-flush h-md-100">
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Catégories</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Gérer les catégories de pièces</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.cataloge.categories.create') }}" class="btn btn-sm btn-light-primary">
                            {!! getIcon('plus', 'fs-2') !!}
                            Nouvelle catégorie
                        </a>
                    </div>
                </div>
                <div class="card-body pt-6">
                    <div class="d-flex flex-center flex-column py-5">
                        <div class="fs-1 fw-bold text-gray-800 mb-2">{{ $categoriesCount }}</div>
                        <div class="fs-6 text-muted">Catégories au total</div>
                    </div>
                    <div class="separator separator-dashed my-5"></div>
                    <a href="{{ route('apps.cataloge.categories.index') }}" class="btn btn-light-primary w-100">
                        Voir toutes les catégories
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-flush h-md-100">
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Pièces</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Gérer les pièces de rechange</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.cataloge.pieces.create') }}" class="btn btn-sm btn-light-success">
                            {!! getIcon('plus', 'fs-2') !!}
                            Nouvelle pièce
                        </a>
                    </div>
                </div>
                <div class="card-body pt-6">
                    <div class="d-flex flex-center flex-column py-5">
                        <div class="fs-1 fw-bold text-gray-800 mb-2">{{ $piecesCount }}</div>
                        <div class="fs-6 text-muted">Pièces au total</div>
                    </div>
                    <div class="separator separator-dashed my-5"></div>
                    <a href="{{ route('apps.cataloge.pieces.index') }}" class="btn btn-light-success w-100">
                        Voir toutes les pièces
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catégories principales</h3>
        </div>
        <div class="card-body">
            @forelse($mainCategories as $category)
                <div class="d-flex align-items-center border rounded p-5 mb-5">
                    <div class="symbol symbol-50px me-5">
                        <img src="{{ $category->image_url }}" alt="{{ $category->title }}">
                    </div>
                    <div class="flex-grow-1">
                        <a href="{{ route('apps.cataloge.categories.show', $category) }}" class="fw-bold text-gray-800 text-hover-primary fs-5">
                            {{ $category->title }}
                        </a>
                        <span class="text-muted d-block fw-semibold">
                            {{ $category->children->count() }} sous-catégories · {{ $category->pieces->count() }} pièces
                        </span>
                    </div>
                    <a href="{{ route('apps.cataloge.categories.edit', $category) }}" class="btn btn-sm btn-light-primary">
                        Modifier
                    </a>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-muted">Aucune catégorie créée</p>
                    <a href="{{ route('apps.cataloge.categories.create') }}" class="btn btn-primary">
                        Créer la première catégorie
                    </a>
                </div>
            @endforelse
        </div>
    </div>

</x-default-layout>