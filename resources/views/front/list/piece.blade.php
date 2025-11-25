@extends('front.layout')

@section('title_front', !empty($category) ? ucfirst($category) . ' - Liste des Pièces' : 'Liste des Pièces')


@section('content')

<div class="container-fluid list-page">
    <div class="breadcrumbs">
        <a href="{{ route('front.home') }}">Home</a>
        @if(!empty($category))
            <a href="{{ route('front.list.category', ['category' => $category]) }}">{{ ucfirst($category) }}</a>
        @endif
        @if(!empty($subcategory))
            <span>{{ ucfirst($subcategory) }}</span>
        @endif
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
                                        @if($catalog->children->count() > 0)
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
                    <strong>{{ $pieces->total() }}</strong> produit(s) trouvé(s)
                </div>
            </div>

            <div class="row">
                @forelse($pieces ?? [] as $piece)
                    <div class="cards-list p-3 col-md-4">
                        <a href="{{ route('front.piece.show', $piece->id) }}" class="text-decoration-none" style="color:#e31e24">
                            <div class="card-details">
                                @if($piece->activePromotion)
                                    <span class="product-badge position-static">-{{ $piece->activePromotion->discount_percentage }}%</span>
                                @endif
                                <div class="brands">
                                    @if($piece->brand_id && $piece->brand && $piece->brand->image)
                                        <img src="{{ asset('uploads/'.$piece->brand->image) }}" alt="{{ $piece->brand->label }}">
                                    @endif
                                </div>
                            </div>
                            <div class="article-image">
                                @if($piece->image)
                                    <img src="{{ asset('uploads/'.$piece->image) }}" alt="{{ $piece->name }}">
                                @else
                                    <img src="{{ asset('assets/site/image/placeholder.png') }}" alt="{{ $piece->name }}">
                                @endif
                            </div>
                            <div class="product-name">
                                <h4>{{ $piece->name }}</h4>
                                <p>Reference: <span>{{ $piece->reference }}</span></p>
                            </div>
                        </a>
                        <div class="footer-card">
                            @if($piece->activePromotion)
                                <div class="price_promo d-block">
                                    <div class="price line-promo m-0">{{ number_format($piece->price, 2) }} DH</div>
                                    <div class="price price_promo">{{ number_format($piece->activePromotion->price_promo, 2) }} DH</div>
                                </div>
                            @else
                                <div class="price">{{ number_format($piece->price, 2) }} DH</div>
                            @endif
                            
                            @if($piece->stock > 0)
                                @php
                                    $cartPrice = $piece->activePromotion ? $piece->activePromotion->price_promo : $piece->price;
                                @endphp
                                <button onclick="addToCart('{{ $piece->name }}','{{ $piece->image ? asset('uploads/'.$piece->image) : asset('assets/site/image/placeholder.png') }}', {{ $cartPrice }})" class="add-to-list-cart">
                                    <i class="fas fa-shopping-cart me-1"></i> ajouter au panier
                                </button>
                            @else
                                <button class="add-to-list-cart disabled" disabled>
                                    <i class="fas fa-shopping-cart me-1"></i> Rupture de stock
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Aucun article trouvé avec ces critères de filtrage.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($pieces->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $pieces->links() }}
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

// Auto-submit form on filter change (optional)
document.querySelectorAll('#filterForm input[type="checkbox"], #filterForm input[type="radio"]').forEach(input => {
    input.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
@endpush

@endsection