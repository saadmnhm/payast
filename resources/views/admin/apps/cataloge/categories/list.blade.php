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
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
</x-default-layout>
