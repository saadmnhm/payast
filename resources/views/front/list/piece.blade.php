@extends('front.layout')

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
        <div class="col-md-3">
            <div class="filter-par">
                <h5 class="m-0">Filtrer par</h5>
            </div>
            <div class="list-filter">
                <div class="btn-prix">
                    <button class=" btn-filter" id="btn-filter">prix</button>
                    <div class="dropdown-filter">
                        <div class="filter-option">Option 1</div>
                        <div class="filter-option">Option 2</div>
                        <div class="filter-option">Option 3</div>
                    </div>
                </div>
                 <div class="btn-prix">
                    <button class=" btn-filter" id="btn-filter">prix</button>
                    <div class="dropdown-filter">
                        <div class="filter-option">Option 1</div>
                        <div class="filter-option">Option 2</div>
                        <div class="filter-option">Option 3</div>
                    </div>
                </div>
                <div class="btn-prix">
                    <button class=" btn-filter" id="btn-filter">prix</button>
                    <div class="dropdown-filter">
                        <div class="filter-option">Option 1</div>
                        <div class="filter-option">Option 2</div>
                        <div class="filter-option">Option 3</div>
                    </div>
                </div>
                <div class="btn-prix">
                    <button class=" btn-filter" id="btn-filter">prix</button>
                    <div class="dropdown-filter">
                        <div class="filter-option">Option 1</div>
                        <div class="filter-option">Option 2</div>
                        <div class="filter-option">Option 3</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="row">
                @forelse($pieces ?? [] as $piece)
                    <div class="cards-list p-3 col-md-4">
                        <div class="card-details">
                            <div class="brands">
                                @if($piece->brand_id && $piece->brand && $piece->brand->image)
                                    <img src="{{ asset('storage/'.$piece->brand->image) }}" alt="{{ $piece->brand->label }}">
                                @endif
                            </div>
                        </div>
                        <div class="article-image">
                            @if($piece->image)
                                <img src="{{ asset('storage/'.$piece->image) }}" alt="{{ $piece->name }}">
                            @else
                                <img src="{{ asset('assets/site/image/placeholder.png') }}" alt="{{ $piece->name }}">
                            @endif
                        </div>
                        <div class="product-name">
                            <h4>{{ $piece->name }}</h4>
                            <p>Reference: <span>{{ $piece->reference }}</span></p>
                        </div>
                        <div class="footer-card">
                            <div class="price">{{ number_format($piece->price, 2) }} DH</div>
                            <button onclick="addToCart('{{ $piece->name }}','{{ $piece->image ? asset('storage/'.$piece->image) : asset('assets/site/image/placeholder.png') }}', {{ $piece->price }})" class="add-to-list-cart">
                                <i class="fas fa-shopping-cart me-1"></i> ajouter au panier
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Aucun article trouvé pour cette catégorie.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>


@endsection