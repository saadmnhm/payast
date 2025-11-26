@extends('front.layout')

@section('title_front', $piece->name . ' ' . $piece->reference)

@section('description_front', $piece->description)

@section('content')

<div class="container product-detail-page my-5">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('front.list') }}">Pièces</a></li>
            @if($piece->category)
                <li class="breadcrumb-item"><a href="{{ route('front.list') }}?catalog[]={{ $piece->category_id }}">{{ $piece->category->title }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $piece->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            <div class="product-image-container">
                @if($piece->activePromotion)
                    <span class="product-detail-badge">-{{ $piece->activePromotion->discount_percentage }}%</span>
                @endif
                <div class="main-product-image">
                    @if($piece->image)
                        <img src="{{ asset('uploads/'.$piece->image) }}" alt="{{ $piece->name }}" class="img-fluid rounded">
                    @else
                        <img src="{{ asset('assets/site/image/placeholder.png') }}" alt="{{ $piece->name }}" class="img-fluid rounded">
                    @endif
                </div>
                @if($piece->brand && $piece->brand->image)
                    <div class="brand-logo-detail mt-3">
                        <img src="{{ asset('uploads/'.$piece->brand->image) }}" alt="{{ $piece->brand->label }}">
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <div class="product-info">
                <h1 class="product-title mt-3">{{ $piece->name }}</h1>
                
                <div class="product-meta mb-3">
                    <span class="badge mt-2 bg-secondary">Réf: {{ $piece->reference }}</span>
                    @if($piece->brand)
                        <span class="badge mt-2 bg-dark">{{ $piece->brand->label }}</span>
                    @endif
                    @if($piece->category)
                        <span class="badge mt-2 bg-info">{{ $piece->category->title }}</span>
                    @endif
                </div>

                <!-- Price -->
                <div class="product-price mb-4">
                    @if($piece->activePromotion)
                        <div class="price-section">
                            <span class="old-price">{{ number_format($piece->price, 2) }} DH</span>
                            <span class="current-price text-danger">{{ number_format($piece->activePromotion->price_promo, 2) }} DH</span>
                            <span class="savings-badge">Économisez {{ number_format($piece->price - $piece->activePromotion->price_promo, 2) }} DH</span>
                        </div>
                    @else
                        <span class="current-price">{{ number_format($piece->price, 2) }} DH</span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="stock-status mb-4">
                    @if($piece->stock > 0)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle"></i> En stock ({{ $piece->stock }} unités)
                        </span>
                    @else
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle"></i> Rupture de stock
                        </span>
                    @endif
                </div>

                <!-- Description -->
                @if($piece->description)
                    <div class="product-description mb-4">
                        <h5><i class="fas fa-info-circle"></i> Description</h5>
                        <div class="description-content">
                            {!! nl2br(e($piece->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Product Details Table -->
                <div class="product-specifications mb-4">
                    <h5><i class="fas fa-list"></i> Caractéristiques</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="40%">Référence</th>
                                <td>{{ $piece->reference }}</td>
                            </tr>
                            @if($piece->brand)
                            <tr>
                                <th>Marque</th>
                                <td>{{ $piece->brand->label }}</td>
                            </tr>
                            @endif
                            @if($piece->category)
                            <tr>
                                <th>Catégorie</th>
                                <td>{{ $piece->category->title }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Prix</th>
                                <td>
                                    @if($piece->activePromotion)
                                        <span class="text-decoration-line-through text-muted">{{ number_format($piece->price, 2) }} DH</span>
                                        <span class="text-danger fw-bold">{{ number_format($piece->activePromotion->price_promo, 2) }} DH</span>
                                    @else
                                        <span class="fw-bold">{{ number_format($piece->price, 2) }} DH</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Disponibilité</th>
                                <td>
                                    @if($piece->stock > 0)
                                        <span class="text-success">En stock</span>
                                    @else
                                        <span class="text-danger">Rupture de stock</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Add to Cart -->
                <div class="product-actions">
                    @if($piece->stock > 0)
                        @php
                            $cartPrice = $piece->activePromotion ? $piece->activePromotion->price_promo : $piece->price;
                        @endphp
                        <button onclick="addToCart('{{ $piece->name }}','{{ $piece->image ? asset('uploads/'.$piece->image) : asset('assets/site/image/placeholder.png') }}', {{ $cartPrice }})" 
                                class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-shopping-cart me-2"></i> Ajouter au panier
                        </button>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="fas fa-times me-2"></i> Rupture de stock
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedPieces->count() > 0)
        <div class="related-products mt-5">
            <h3 class="mb-4"><i class="fas fa-th-large"></i> Produits similaires</h3>
            <div class="row">
                @foreach($relatedPieces as $related)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('front.piece.show', $related->id) }}">
                                @if($related->activePromotion)
                                    <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                                        -{{ $related->activePromotion->discount_percentage }}%
                                    </span>
                                @endif
                                <div class="card-img-top-wrapper" style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                    @if($related->image)
                                        <img src="{{ asset('uploads/'.$related->image) }}" alt="{{ $related->name }}" class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    @else
                                        <img src="{{ asset('assets/site/image/placeholder.png') }}" alt="{{ $related->name }}" class="img-fluid">
                                    @endif
                                </div>
                            </a>
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ route('front.piece.show', $related->id) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($related->name, 50) }}
                                    </a>
                                </h6>
                                <p class="small text-muted mb-2">Réf: {{ $related->reference }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    @if($related->activePromotion)
                                        <div>
                                            <small class="text-decoration-line-through text-muted">{{ number_format($related->price, 2) }} DH</small>
                                            <div class="text-danger fw-bold">{{ number_format($related->activePromotion->price_promo, 2) }} DH</div>
                                        </div>
                                    @else
                                        <div class="fw-bold">{{ number_format($related->price, 2) }} DH</div>
                                    @endif
                                    @if($related->stock > 0)
                                        @php
                                            $relatedCartPrice = $related->activePromotion ? $related->activePromotion->price_promo : $related->price;
                                        @endphp
                                        <button onclick="addToCart('{{ $related->name }}','{{ $related->image ? asset('uploads/'.$related->image) : asset('assets/site/image/placeholder.png') }}', {{ $relatedCartPrice }})" 
                                                class="btn btn-sm btn-outline-primary btn_red">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>


.product-image-container {
    position: relative;
}

.product-detail-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #e31e24;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: bold;
    font-size: 18px;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(227, 30, 36, 0.3);
}

.main-product-image {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}

.main-product-image img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}

.brand-logo-detail {
    text-align: center;
    padding: 15px;
    background: white;
    border-radius: 8px;
    border: 1px solid #f8f9fa;
}

.brand-logo-detail img {
    max-width: 150px;
    height: auto;
}

.product-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 15px;
}

.product-meta .badge {
    margin-right: 8px;
    padding: 8px 12px;
    font-size: 14px;
}

.price-section {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.old-price {
    font-size: 1.2rem;
    text-decoration: line-through;
    color: #999;
}

.current-price {
    font-size: 2.5rem;
    font-weight: bold;
    color: #e31e24;
}

.savings-badge {
    background: #28a745;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 14px;
}

.stock-status .badge {
    font-size: 16px;
    padding: 10px 20px;
}

.product-description h5,
.product-specifications h5 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
}

.description-content {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    line-height: 1.8;
    color: #555;
}

.product-specifications table {
    background: white;
}

.product-specifications th {
    background: #f8f9fa;
    font-weight: 600;
}

.product-actions {
    margin-top: 30px;
}

.product-actions .btn-lg {
    padding: 15px;
    font-size: 1.2rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s;
}

.product-actions .btn-primary {
    background: #e31e24;
    border-color: #e31e24;
}

.product-actions .btn-primary:hover {
    background: #c11820;
    border-color: #c11820;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
}

.related-products h3 {
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
    padding-bottom: 15px;
    border-bottom: 3px solid #e31e24;
}

.related-products .card {
    transition: all 0.3s;
    border: none;
}

.related-products .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

.breadcrumb {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 8px;
}

.breadcrumb-item a {
    color: #e31e24;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #666;
}

@media (max-width: 768px) {
    .product-title {
        font-size: 1.5rem;
    }
    
    .current-price {
        font-size: 2rem;
    }
    
    .main-product-image {
        min-height: 300px;
    }
}
</style>

@endsection
