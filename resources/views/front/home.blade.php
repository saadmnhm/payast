@extends('front.layout')

@section('content')

        <div class="title-page">
            <h1>Le meilleur choix de pièces auto en ligne au Maroc</h1>
        </div>
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            
            <p>RECHERCHEZ PAR MODÈLE DE VÉHICULE</p>
            <form class="search-form" onsubmit="searchVehicle(event)">
                <select id="brand" onchange="loadModels()">
                    <option value="">CONSTRUCTEUR</option>
                    <option value="renault">Renault</option>
                    <option value="peugeot">Peugeot</option>
                    <option value="volkswagen">Volkswagen</option>
                    <option value="hyundai">Hyundai</option>
                    <option value="kia">Kia</option>
                </select>
                <select id="model" onchange="loadVersions()">
                    <option value="">MODÈLE</option>
                </select>
                <select id="version">
                    <option value="">VERSION</option>
                </select>
                <button type="submit">
                    <i class="fas fa-search"></i> RECHERCHER
                </button>
            </form>
            
        </div>
    </section>

    <section class="slides">

        <div class="container p-0 mt-4 slides-container">
            <div class="controls">
                <button id="prevButton"><i class="ri-arrow-left-s-line"></i></button>
                <button id="nextButton"><i class="ri-arrow-right-s-line"></i></button>
            </div>
            <div class="slides-inner">
                <div class="slide">
                    <img src="{{asset('assets/site/image/test-slider.png')}}" alt="">
                </div>
                <div class="slide">2</div>
                <div class="slide">3</div>
                <div class="slide">4</div>
                <div class="slide">5</div>
            </div>
      </div>
    </section>

        <!-- Brands -->
    <section class="brands" id="brands">
        <div class="container">
            <h2>TROUVER LA PIÈCE PAR CONSTRUCTEUR</h2>
            <div class="brand-logos">
                <div class="owl-carousel">
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('chery')">Chery</div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('hyundai')"><img src="{{ asset('assets/site/image/hyundai.png')}}" alt=""></div>

                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('renault')">Renault</div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('kia')"><img src="{{ asset('assets/site/image/kia.svg')}}" alt=""></div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('peugeot')"><img src="{{ asset('assets/site/image/peugeot.png')}}" alt=""></div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('suzuki')">Suzuki</div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('volkswagen')">VW</div>
                    </div>

                </div>
                
            </div>
        </div>
    </section>




    



    <!-- Services -->
    <section class="services" id="services">
        <div class="container">
            <h2>PIASSAT À VOTRE SERVICE</h2>
                <!-- Gallery -->
            <div class="container">
                <div class="gallery animate-in">
                    <div class="gallery-item">
                        <img src="{{ asset('assets/site/image/depot.jpg') }}" alt="Shop">
                        <div class="gallery-overlay">
                            <h3>Visitez nos magasins</h3>
                            <p>Découvrez notre gamme complète</p>
                        </div>
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('assets/site/image/diag.png') }}" alt="Shops">
                        <div class="gallery-overlay">
                            <h3>Nos révision</h3>
                            <p>Demandez une révision de votre véhicule</p>
                        </div>
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('assets/site/image/slide3.png') }}" alt="Service">
                        <div class="gallery-overlay">
                            <h3>Services professionnels</h3>
                            <p>Installation et conseils d'experts</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="service-cards">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-shopping-bag"></i></div>
                    <h3>Achetez des pièces neuves en ligne</h3>
                    <p>Profitez d'un large choix de pièces automobiles de qualité avec livraison rapide partout au Maroc</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-tools"></i></div>
                    <h3>Installez vos pièces au garage</h3>
                    <p>Service professionnel d'installation par nos mécaniciens experts dans nos ateliers partenaires</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-user-tie"></i></div>
                    <h3>Accédez au compte Pro</h3>
                    <p>Tarifs spéciaux pour professionnels, garagistes et revendeurs avec avantages exclusifs</p>
                </div>
            </div> -->
        </div>
    </section>

    <!-- Categories -->
    <section class="categories" id="categories">
        <div class="container">
            <div class="title-group">
                <h2>TOP CATÉGORIES</h2>
                <p style="margin-bottom: 40px; color: #666;">Toutes les pièces dont vous avez besoin</p>
            </div>

            <div class="category-grid">
                <div class="category-item" onclick="filterCategory('batterie')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/batterie.png')}}" alt=""></div>
                    <h3>BATTERIE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('filtre')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/filteraair.jpg')}}" alt=""></div>
                    <h3>FILTRE À AIR</h3>
                </div>
                <div class="category-item" onclick="filterCategory('frein')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/plaquettesfreins.png')}}" alt=""></div>
                    <h3>PLAQUETTES DE FREIN</h3>
                </div>
                <div class="category-item" onclick="filterCategory('carburant')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/filtercarburant.png')}}" alt=""></div>
                    <h3>FILTRE À CARBURANT</h3>
                </div>
                <div class="category-item" onclick="filterCategory('parebrise')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/parbrise.jpg')}}" alt=""></div>
                    <h3>PARE-BRISE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('liquide')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/nettoyage-lavage.png')}}" alt=""></div>
                    <h3>NETTOYAGE / LIQUIDE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('huile')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/huile.jpg')}}" alt=""></div>
                    <h3>HUILE / VIDANGE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('Kit de distribution')">
                    <div class="category-icon"><img src="{{ asset('assets/site/image/kit-distribution.jpg')}}" alt=""></div>
                    <h3>KIT DE DISTRIBUTION</h3>
                </div>
            </div>
        </div>
    </section>



        <section class="brands" id="brands">
        <div class="container">
            <h2>NOS MARQUES PARTENAIRES</h2>
            <div class="brand-logos">
                <div class="owl-carousel2 owl-carousel">
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('bosch')">
                        <img src="{{ asset('assets/site/image/bosch.png') }}" alt="Bosch">
                        </div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('valeo')">
                        <img src="{{ asset('assets/site/image/valeo.png') }}" alt="Valeo">
                        </div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('brembo')">
                        <img src="{{ asset('assets/site/image/brembo.png') }}" alt="Brembo">
                        </div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('ngk')">
                        <img src="{{ asset('assets/site/image/ngk.png') }}" alt="NGK">
                        </div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('michelin')">
                        <img src="{{ asset('assets/site/image/michelin.png') }}" alt="Michelin">
                        </div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('total')">
                        <img src="{{ asset('assets/site/image/total.png') }}" alt="Total">
                        </div>
                    </div>
                    <div class="item">
                        <div class="brand-logo" onclick="filterByBrand('castrol')">
                        <img src="{{ asset('assets/site/image/castrol.png') }}" alt="Castrol">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="products" id="products">
        <div class="container">
            <h2>LES MEILLEURES VENTES</h2>
            <p style="text-align: center; margin-bottom: 40px; color: #666;">Découvrez nos produits les plus populaires</p>
            <div class="product-grid" id="productGrid">
                <div class="product-card">
                    <span class="product-badge">EN PROMOTION</span>
                    <img class="product-image" src="{{ asset('assets/site/image/totalquartz.png') }}" alt="Huile Moteur">
                    <h3>Huile moteur Total Quartz Ineo MC3 5W30 5l</h3>
                    <p class="price">499.00 MAD</p>
                    <button class="add-to-cart" onclick="addToCart('Huile Moteur', 499)">
                        <i class="fas fa-cart-plus"></i> Ajouter
                    </button>
                </div>
                <div class="product-card">
                    <span class="product-badge">EN PROMOTION</span>
                    <img class="product-image" src="{{ asset('assets/site/image/batterie-varta.jpg') }}" alt="Batterie Varta">
                    <h3>Batterie Varta E13 - L3 - 70Ah</h3>
                    <p class="price">1799.00 MAD</p>
                    <button class="add-to-cart" onclick="addToCart('Batterie Varta E13 - L3 - 70Ah', 1799)">
                        <i class="fas fa-cart-plus"></i> Ajouter
                    </button>
                </div>
                <div class="product-card">
                    <span class="product-badge">EN PROMOTION</span>
                    <img class="product-image" src="{{ asset('assets/site/image/filtrair2.png') }}" alt="Filtre à huile">
                    <h3>Filtre à huile COF100122S</h3>
                    <p class="price">179.00 MAD</p>
                    <button class="add-to-cart" onclick="addToCart('Filtre à huile COF100122S', 179)">
                        <i class="fas fa-cart-plus"></i> Ajouter
                    </button>
                </div>
                <div class="product-card promo-card">
                    <h3>CONSULTEZ NOS PRODUITS EN PROMOTION</h3>
                    <div class="promo-discount">-60%</div>
                    <p>Sur une sélection de produits</p>
                    <button class="promo-btn" onclick="showPromo()">VOIR LES PROMOS</button>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <h2>Restez Informé de Nos Offres</h2>
            <p>Inscrivez-vous à notre newsletter et recevez nos meilleures promotions</p>
            <form class="newsletter-form" onsubmit="subscribeNewsletter(event)">
                <input type="email" placeholder="Votre adresse email" required>
                <button type="submit">
                    <i class="fas fa-paper-plane"></i> S'inscrire
                </button>
            </form>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // Slider Functionality
var slideDelay = 1.5;
var slideDuration = 0.3;

var slides = document.querySelectorAll(".slide");
var prevButton = document.querySelector("#prevButton");
var nextButton = document.querySelector("#nextButton");

for (var i = 0; i < slides.length; i++) {
  TweenLite.set(slides[i], {
    backgroundColor: Math.random() * 0xffffff,
    xPercent: i * 100
  });
}

var wrap = wrapPartial(-100, (slides.length - 1) * 100);
var timer = TweenLite.delayedCall(slideDelay, autoPlay);
var animation = null;

prevButton.addEventListener("click", function() {
  animateSlides(100);
});

nextButton.addEventListener("click", function() {
  animateSlides(-100);
});

function animateSlides(delta) {
    
  animation = TweenMax.to(slides, slideDuration, {
    xPercent: function(i, target) {      
      return (Math.round(target._gsTransform.xPercent / 100) * 100) + delta;
    },
    modifiers: {
      xPercent: wrap
    },
    onComplete: restartTimer
  });  
}

function autoPlay() {  
  if (!animation) {
    animateSlides(-100);
  }
}

function restartTimer() {  
  if (animation === this) {
    animation = null;
    timer.restart(true);
  }
}

function wrapPartial(min, max) {  
  var r = max - min;  
  return function(value) {
    var v = value - min;
    return ((r + v % r) % r) + min;
  }
}

</script>
@endsection


    