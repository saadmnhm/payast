@extends('front.layout')

@section('title_front', 'Promotion' . (isset($promo) && $promo->count() ? ' - ' . optional($promo->first()->piece)->name : ''))

@section('content')

<div class="container-fluid list-page">
    <div class="breadcrumbs">
        <a href="{{ route('front.home') }}">Home</a>
        <!-- @if(!empty($category))
            <a href="{{ route('front.list.category', ['category' => $category]) }}">{{ ucfirst($category) }}</a>
        @endif
        @if(!empty($subcategory))
            <span>{{ ucfirst($subcategory) }}</span>
        @endif -->
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="filter-par">
                <h5 class="m-0">Filtrer par</h5>
            </div>
            <div class="list-filter">
                <form id="filterForm" method="GET">
                    <!-- Prix Filter -->
                    <div class="filter-group ">
                        <button type="button" class="btn-filter" data-bs-toggle="collapse" data-bs-target="#prixFilter">
                            Prix
                        </button>
                        <div id="prixFilter" class="collapse">
                            <div class="filter-content p-3">
                                <div class="mb-2">
                                    <label class="form-label small">Prix minimum (DH)</label>
                                    <input type="number" name="prix_min" class="form-control form-control-sm" 
                                        value="{{ request('prix_min') }}" 
                                        min="{{ $priceRange->min ?? 0 }}" 
                                        max="{{ $priceRange->max ?? 10000 }}"
                                        placeholder="{{ number_format($priceRange->min ?? 0, 2) }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Prix maximum (DH)</label>
                                    <input type="number" name="prix_max" class="form-control form-control-sm" 
                                        value="{{ request('prix_max') }}" 
                                        min="{{ $priceRange->min ?? 0 }}" 
                                        max="{{ $priceRange->max ?? 10000 }}"
                                        placeholder="{{ number_format($priceRange->max ?? 10000, 2) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catalog Filter -->
                    <div class="filter-group ">
                        <button type="button" class="btn-filter" data-bs-toggle="collapse" data-bs-target="#catalogFilter">
                            Catégorie
                        </button>
                        <div id="catalogFilter" class="collapse">
                            <div class="filter-content p-3" style="max-height: 250px; overflow-y: auto;">
                                @foreach($catalogs as $catalog)
                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="catalog[]" 
                                                value="{{ $catalog->id }}" id="catalog{{ $catalog->id }}"
                                                {{ in_array($catalog->id, request('catalog', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small fw-bold" for="catalog{{ $catalog->id }}">
                                                {{ $catalog->title }}
                                            </label>
                                        </div>
                                        @if($catalog->children)
                                            <div class="ms-3 mt-1">
                                                @foreach($catalog->children as $child)
                                                    <div class="form-check mb-1">
                                                        <input class="form-check-input" type="checkbox" name="catalog[]" 
                                                            value="{{ $child->id }}" id="catalog{{ $child->id }}"
                                                            {{ in_array($child->id, request('catalog', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="catalog{{ $child->id }}">
                                                            {{ $child->title }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Marque Filter -->
                    <div class="filter-group ">
                        <button type="button" class="btn-filter" data-bs-toggle="collapse" data-bs-target="#marqueFilter">
                            Marque
                        </button>
                        <div id="marqueFilter" class="collapse">
                            <div class="filter-content p-3" style="max-height: 250px; overflow-y: auto;">
                                @foreach($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="brand[]" 
                                            value="{{ $brand->id }}" id="brand{{ $brand->id }}"
                                            {{ in_array($brand->id, request('brand', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="brand{{ $brand->id }}">
                                            {{ $brand->label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Stock Filter -->
                    <div class="filter-group ">
                        <button type="button" class="btn-filter" data-bs-toggle="collapse" data-bs-target="#stockFilter">
                            Disponibilité
                        </button>
                        <div id="stockFilter" class="collapse">
                            <div class="filter-content p-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="stock" value="all" 
                                        id="stockAll" {{ !request('stock') || request('stock') === 'all' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="stockAll">
                                        Tous les produits
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="stock" value="available" 
                                        id="stockAvailable" {{ request('stock') === 'available' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="stockAvailable">
                                        En stock
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="stock" value="out" 
                                        id="stockOut" {{ request('stock') === 'out' ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="stockOut">
                                        Rupture de stock
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="filter-actions p-3 border-top">
                        <button type="submit" class="btn filter-app btn-primary btn-sm w-100 mb-2">
                            <i class="fas fa-filter"></i> Appliquer les filtres
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9 mb-4">
            <!-- Sorting and Results Count -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <strong>{{ $promo->total() }}</strong> promotion(s) active(s)
                </div>
                <div class="d-flex align-items-center">
                    <label class="me-2 mb-0 small">Trier par:</label>
                    <select class="form-select form-select-sm" id="sortSelect" style="width: auto;">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Plus récentes</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nom A-Z</option>
                    </select>
                </div>
            </div>

            <div class="row">
                @forelse($promo ?? [] as $promotion)
                    <div class="cards-list p-3 col-md-4">
                        <a href="{{ route('front.piece.show', $promotion->piece->id) }}" class="text-decoration-none" style="color:#e31e24">
                            <div class="card-details">
                                <span class="product-badge position-static">-{{ $promotion->discount_percentage }}%</span>
                                <div class="brands">
                                    @if($promotion->piece->brand && $promotion->piece->brand->image)
                                        <img src="{{ asset('uploads/'.$promotion->piece->brand->image) }}" alt="{{ $promotion->piece->brand->label }}">
                                    @endif
                                </div>
                            </div>
                            <div class="article-image">
                                @if($promotion->piece && $promotion->piece->image)
                                    <img src="{{ asset('uploads/'.$promotion->piece->image) }}" alt="{{ $promotion->piece->name }}">
                                @else
                                    <img src="{{ asset('assets/site/image/placeholder.png') }}" alt="{{ $promotion->piece->name }}">
                                @endif
                            </div>
                            <div class="product-name">
                                <h4>{{ $promotion->piece->name }}</h4>
                                <p>Reference: <span>{{ $promotion->piece->reference }}</span></p>
                            </div>
                            <div class="footer-card">
                                <div class="price_promo d-block">
                                    <div class="price line-promo m-0">{{ number_format($promotion->piece->price) }} DH</div>
                                    <div class="price price_promo">{{ number_format($promotion->price_promo) }} DH</div>
                                </div>
                                @if($promotion->piece->stock > 0)
                                    <button onclick="addToCart('{{ $promotion->piece->name }}','{{ $promotion->piece->image ? asset('uploads/'.$promotion->piece->image) : asset('assets/site/image/placeholder.png') }}', {{ $promotion->price_promo }})" class="add-to-list-cart">
                                        <i class="fas fa-shopping-cart me-1"></i> ajouter au panier
                                    </button>
                                @else
                                    <button class="add-to-list-cart disabled" disabled>
                                        <i class="fas fa-times-circle me-1"></i> Rupture de stock
                                    </button>
                                @endif
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Aucune promotion active pour le moment.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($promo->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $promo->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('sortSelect').addEventListener('change', function() {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', this.value);
    window.location.href = url.toString();
});

// Auto-submit form on filter change
document.querySelectorAll('#filterForm input[type="checkbox"], #filterForm input[type="radio"]').forEach(input => {
    input.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
@endpush

@endsection