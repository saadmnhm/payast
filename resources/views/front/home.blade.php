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

    <!-- Gallery -->
    <div class="container">
        <div class="gallery animate-in">
            <div class="gallery-item">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='300'%3E%3Cdefs%3E%3ClinearGradient id='g1' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%23667eea'/%3E%3Cstop offset='100%25' style='stop-color:%23764ba2'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='400' height='300' fill='url(%23g1)'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' fill='white' font-size='24' font-weight='bold'%3EPIASSAT SHOP%3C/text%3E%3C/svg%3E" alt="Shop">
                <div class="gallery-overlay">
                    <h3>Visitez nos magasins</h3>
                    <p>Découvrez notre gamme complète</p>
                </div>
            </div>
            <div class="gallery-item">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='300'%3E%3Crect width='400' height='300' fill='%23e8f4f8'/%3E%3Ctext x='50%25' y='45%25' text-anchor='middle' fill='%231e2847' font-size='28' font-weight='bold'%3EDÉCOUVREZ NOS%3C/text%3E%3Ctext x='50%25' y='60%25' text-anchor='middle' fill='%23e31e24' font-size='32' font-weight='bold'%3EPIASSAT SHOPS%3C/text%3E%3C/svg%3E" alt="Shops">
                <div class="gallery-overlay">
                    <h3>Nos boutiques</h3>
                    <p>Trouvez un magasin près de chez vous</p>
                </div>
            </div>
            <div class="gallery-item">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='300'%3E%3Cdefs%3E%3ClinearGradient id='g2' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%23f093fb'/%3E%3Cstop offset='100%25' style='stop-color:%23f5576c'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='400' height='300' fill='url(%23g2)'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' fill='white' font-size='24' font-weight='bold'%3ESERVICES PRO%3C/text%3E%3C/svg%3E" alt="Service">
                <div class="gallery-overlay">
                    <h3>Services professionnels</h3>
                    <p>Installation et conseils d'experts</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Brands -->
    <section class="brands" id="brands">
        <div class="container">
            <h2>TROUVER LA PIÈCE PAR CONSTRUCTEUR</h2>
            <div class="brand-logos">
                <div class="brand-logo" onclick="filterByBrand('chery')">Chery</div>
                <div class="brand-logo" onclick="filterByBrand('hyundai')">Hyundai</div>
                <div class="brand-logo" onclick="filterByBrand('renault')">Renault</div>
                <div class="brand-logo" onclick="filterByBrand('kia')">KIA</div>
                <div class="brand-logo" onclick="filterByBrand('peugeot')">Peugeot</div>
                <div class="brand-logo" onclick="filterByBrand('suzuki')">Suzuki</div>
                <div class="brand-logo" onclick="filterByBrand('volkswagen')">VW</div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="services" id="services">
        <div class="container">
            <h2>PIASSAT À VOTRE SERVICE</h2>
            <div class="service-cards">
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
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="categories" id="categories">
        <div class="container">
            <h2>TOP CATÉGORIES</h2>
            <p style="margin-bottom: 40px; color: #666;">Toutes les pièces dont vous avez besoin</p>
            <div class="category-grid">
                <div class="category-item" onclick="filterCategory('batterie')">
                    <div class="category-icon"><i class="fas fa-car-battery"></i></div>
                    <h3>BATTERIE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('filtre')">
                    <div class="category-icon"><i class="fas fa-filter"></i></div>
                    <h3>FILTRE À AIR</h3>
                </div>
                <div class="category-item" onclick="filterCategory('frein')">
                    <div class="category-icon"><i class="fas fa-brake-warning"></i></div>
                    <h3>PLAQUETTES DE FREIN</h3>
                </div>
                <div class="category-item" onclick="filterCategory('carburant')">
                    <div class="category-icon"><i class="fas fa-gas-pump"></i></div>
                    <h3>FILTRE À CARBURANT</h3>
                </div>
                <div class="category-item" onclick="filterCategory('parebrise')">
                    <div class="category-icon"><i class="fas fa-window-maximize"></i></div>
                    <h3>PARE-BRISE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('liquide')">
                    <div class="category-icon"><i class="fas fa-tint"></i></div>
                    <h3>NETTOYAGE / LIQUIDE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('huile')">
                    <div class="category-icon"><i class="fas fa-oil-can"></i></div>
                    <h3>HUILE / VIDANGE</h3>
                </div>
                <div class="category-item" onclick="filterCategory('courroie')">
                    <div class="category-icon"><i class="fas fa-ring"></i></div>
                    <h3>COURROIE ACCESSOIRE</h3>
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
                    <img class="product-image" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Crect width='200' height='200' fill='%23f5f5f5'/%3E%3Crect x='60' y='50' width='80' height='100' rx='5' fill='%23333'/%3E%3Ctext x='100' y='170' text-anchor='middle' fill='%23666' font-size='12'%3E10L%3C/text%3E%3C/svg%3E" alt="Huile Moteur">
                    <h3>Huile Moteur Polycraft 10L Série Premium</h3>
                    <p class="price">499.00 MAD</p>
                    <button class="add-to-cart" onclick="addToCart('Huile Moteur', 499)">
                        <i class="fas fa-cart-plus"></i> Ajouter
                    </button>
                </div>
                <div class="product-card">
                    <span class="product-badge">EN PROMOTION</span>
                    <img class="product-image" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Crect width='200' height='200' fill='%23f5f5f5'/%3E%3Crect x='40' y='60' width='120' height='80' rx='5' fill='%23e31e24'/%3E%3Ctext x='100' y='110' text-anchor='middle' fill='white' font-size='16' font-weight='bold'%3EPACK%3C/text%3E%3C/svg%3E" alt="Pack Révision">
                    <h3>Pack Révision Complète pour Garage</h3>
                    <p class="price">1799.00 MAD</p>
                    <button class="add-to-cart" onclick="addToCart('Pack Révision', 1799)">
                        <i class="fas fa-cart-plus"></i> Ajouter
                    </button>
                </div>
                <div class="product-card">
                    <span class="product-badge">EN PROMOTION</span>
                    <img class="product-image" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Crect width='200' height='200' fill='%23f5f5f5'/%3E%3Crect x='70' y='70' width='60' height='80' rx='3' fill='%234a90e2'/%3E%3Ctext x='100' y='170' text-anchor='middle' fill='%23666' font-size='11'%3EADDITIF%3C/text%3E%3C/svg%3E" alt="Additif">
                    <h3>Additif Polycraft Pro Performance</h3>
                    <p class="price">179.00 MAD</p>
                    <button class="add-to-cart" onclick="addToCart('Additif', 179)">
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


    