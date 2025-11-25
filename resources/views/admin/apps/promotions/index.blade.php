<x-default-layout>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            {{ Breadcrumbs::render('apps.promotions.index') }}
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2>Liste des Promotions</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('apps.promotions.create') }}" class="btn btn-sm btn-primary">
                            {!! getIcon('plus', 'fs-2') !!}
                            Nouvelle Promotion
                        </a>
                    </div>
                </div>

                <div class="card-body pt-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="promotions_table">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>Titre</th>
                                    <th>Pièce</th>
                                    <th>Prix Promo</th>
                                    <th>Ordre</th>
                                    <th>Statut</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse($promotions as $promotion)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($promotion->image)
                                                    <div class="symbol symbol-50px me-3">
                                                        <img src="{{ $promotion->image_url }}" alt="{{ $promotion->title }}">
                                                    </div>
                                                @endif
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold">{{ $promotion->title }}</span>
                                                    <span class="text-muted fs-7">{{ $promotion->slug }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($promotion->piece)
                                                <span class="badge badge-light-info">{{ $promotion->piece->name }}</span>
                                            @else
                                                <span class="text-muted">Aucune</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-success fw-bold">{{ $promotion->formatted_price }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light">{{ $promotion->order }}</span>
                                        </td>
                                        <td>
                                            @if($promotion->is_active)
                                                <span class="badge badge-light-success">Actif</span>
                                            @else
                                                <span class="badge badge-light-danger">Inactif</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('apps.promotions.show', $promotion) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                                {!! getIcon('eye', 'fs-5') !!}
                                            </a>
                                            <a href="{{ route('apps.promotions.edit', $promotion) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                                {!! getIcon('pencil', 'fs-5') !!}
                                            </a>
                                            <form action="{{ route('apps.promotions.destroy', $promotion) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light btn-active-light-danger">
                                                    {!! getIcon('trash', 'fs-5') !!}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-10">
                                            <div class="text-muted">Aucune promotion trouvée</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        {{ $promotions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-default-layout>