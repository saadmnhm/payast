@extends('front.layout')

@section('content')

<div class="container-fluid list-page">
    <div class="breadcrumbs">
        <a href="#">Home</a> 
        <a href="#">Category</a> 
        <span>Subcategory</span>
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
                <div class="cards-list p-3 col-md-4">
                    <div class="card-details">
                        <div class="brands"><img src="{{asset('assets/site/image/total.png')}}" alt=""></div>
                    </div>
                    <div class="article-image">
                        <img src="{{asset('assets/site/image/huile.jpg')}}" alt="">
                    </div>
                    <div class="product-name">
                        <h4>Huile Moteur</h4>
                        <p>Reference: <span>1115-8</span></p>
                    </div>
                    <div class="footer-card">
                        <div class="price">200 DH</div>
                        <button onclick="addToCart('Huile Moteur', 179)" class="add-to-list-cart"><i class="fas fa-shopping-cart me-1"></i> add to card</button>
                    </div>

                </div>
                <div class="cards-list p-3 col-md-4">
                    <div class="card-details">
                        <div class="brands"><img src="{{asset('assets/site/image/total.png')}}" alt=""></div>
                    </div>
                    <div class="article-image">
                        <img src="{{asset('assets/site/image/huile.jpg')}}" alt="">
                    </div>
                    <div class="product-name">
                        <h4>Huile Moteur</h4>
                        <p>Reference: <span>1115-8</span></p>
                    </div>
                    <div class="footer-card">
                        <div class="price">200 DH</div>
                        <button onclick="addToCart('Huile Moteur', 179)" class="add-to-list-cart"><i class="fas fa-shopping-cart me-1"></i> add to card</button>
                    </div>

                </div>
                <div class="cards-list p-3 col-md-4">
                    <div class="card-details">
                        <div class="brands"><img src="{{asset('assets/site/image/total.png')}}" alt=""></div>
                    </div>
                    <div class="article-image">
                        <img src="{{asset('assets/site/image/huile.jpg')}}" alt="">
                    </div>
                    <div class="product-name">
                        <h4>Huile Moteur</h4>
                        <p>Reference: <span>1115-8</span></p>
                    </div>
                    <div class="footer-card">
                        <div class="price">200 DH</div>
                        <button onclick="addToCart('Huile Moteur', 179)" class="add-to-list-cart"><i class="fas fa-shopping-cart me-1"></i> add to card</button>
                    </div>

                </div>
                <div class="cards-list p-3 col-md-4">
                    <div class="card-details">
                        <div class="brands"><img src="{{asset('assets/site/image/total.png')}}" alt=""></div>
                    </div>
                    <div class="article-image">
                        <img src="{{asset('assets/site/image/huile.jpg')}}" alt="">
                    </div>
                    <div class="product-name">
                        <h4>Huile Moteur</h4>
                        <p>Reference: <span>1115-8</span></p>
                    </div>
                    <div class="footer-card">
                        <div class="price">200 DH</div>
                        <button onclick="addToCart('Huile Moteur', 179)" class="add-to-list-cart"><i class="fas fa-shopping-cart me-1"></i> add to card</button>
                    </div>

                </div>
                <div class="cards-list p-3 col-md-4">
                    <div class="card-details">
                        <div class="brands"><img src="{{asset('assets/site/image/total.png')}}" alt=""></div>
                    </div>
                    <div class="article-image">
                        <img src="{{asset('assets/site/image/huile.jpg')}}" alt="">
                    </div>
                    <div class="product-name">
                        <h4>Huile Moteur</h4>
                        <p>Reference: <span>1115-8</span></p>
                    </div>
                    <div class="footer-card">
                        <div class="price">200 DH</div>
                        <button onclick="addToCart('Huile Moteur', 179)" class="add-to-list-cart"><i class="fas fa-shopping-cart me-1"></i> add to card</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection