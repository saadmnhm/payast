<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piassat - Pièces Auto en Ligne au Maroc</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/site/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container desktop-menu">
            <div class="top-bar-content">
                <div>
                    <i class="fas fa-phone"></i> +212 5XX-XXXXXX
                    <i class="fas fa-envelope" style="margin-left: 20px;"></i> contact@piassat.ma
                </div>
                <div>
                    <a href="#"><i class="fas fa-map-marker-alt"></i> Nos Magasins</a>
                    <a href="#"><i class="fas fa-truck"></i> Suivi Commande</a>
                </div>
            </div>
        </div>
        <div class="container-fluid mobile-menu">
            <div class="top-bar-content">
                <a href="">Contact</a>
                <a href="" class="border-topbar">Piassaty Service</a>
                <a href="">Compte Pro</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header-main desktop-menu" id="header">
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">logo mohamad</a>
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher des pièces auto...">
                    <button onclick="performSearch()"><i class="fas fa-search"></i></button>
                </div>
                <div class="header-icons">
                    <a href="" class="header-icon">
                        <i class="fas fa-heart"></i> Favoris
                    </a>
                    <a href="#" class="header-icon">
                        <i class="fas fa-user"></i> Compte
                    </a>
                    <a href="#" class="header-icon" onclick="openCart(event)">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge" id="cartCount">0</span>
                        <p class="m-0">Panier : <span class="" style="color: #e31e24;">0.00DH</span></p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="navbar mt-3 navbar-expand-lg p-0 desktop-menu">

            <div class="container h-100 gap-3 ">
                <div class="col-md-3  h-100 d-flex align-items-center justify-content-center">
                    <div class="nav-links dropdown drop-categories">
                        <ul class="nav-links ps-0">
                            <li><a class=" dropdown-toggle" href="#">
                                    <i class="fas fa-bars"></i>
                                    Catégories
                                </a>
                            
                                <ul class="drop-menu">
                                    <li><a href="#">Drop menu 1</a></li>
                                    <li><a href="#">Drop menu 2</a></li>
                                    <li><a href="#">Drop menu 3</a></li>
                                    <li><a href="#">Drop menu 4</a></li>
                                </ul>
                            </li>
                        </ul>

                            
                        
                    </div>
                    <div class="promo-link">
                        <a href="" >% PROMOTIONS</a>
                    </div>
                                        
                </div>
                <div class="collapse h-100 navbar-collapse" id="navbarNav">
                    <div class="wrapper mb-0 mt-0">
                        <ul class="nav-links">
                        <li>
                            <a
                            href="{{ route('front.list') }}"
                            class="desktop-item"
                            >Mécanique</a
                            >
                            
                            <div class="mega-box">
                            <div class="content">
                                <div class="row">
                                    <ul class="mega-links">
                                        <li><a href="#">Personal Email</a></li>
                                        <li><a href="#">Business Email</a></li>
                                        <li><a href="#">Mobile Email</a></li>
                                        <li><a href="#">Web Marketing</a></li>
                                    </ul>
                                </div>
                            </div>
                            </div>
                        </li>
                        <li>
                            <a
                            href="#"
                            class="desktop-item"
                            >Filtration</a
                            >
                            
                            <div class="mega-box">
                            <div class="content">
                                <div class="row">
                                    sssssssssssssssssssss
                                </div>
                            </div>
                            </div>
                        </li>
                        <li>
                            <a
                            href="#"
                            class="desktop-item"
                            >Freinage</a
                            >
                            
                            <div class="mega-box">
                            <div class="content">
                                <div class="row">
                                    sssssssssssssssssssss
                                </div>
                            </div>
                            </div>
                        </li>
                        <li>
                            <a
                            href="#"
                            class="desktop-item"
                            >Lubrifiants</a
                            >
                            
                            <div class="mega-box">
                            <div class="content">
                                <div class="row">
                                    sssssssssssssssssssss
                                </div>
                            </div>
                            </div>
                        </li>
                        <li>
                            <a
                            href="#"
                            class="desktop-item"
                            >Batteries</a
                            >
                            
                            <div class="mega-box">
                            <div class="content">
                                <div class="row">
                                    sssssssssssssssssssss
                                </div>
                            </div>
                            </div>
                        </li>
                        
                        <li>
                            <a
                            href="#"
                            class="desktop-item"
                            >Entretien</a
                            >
                            
                            <div class="mega-box">
                            <div class="content">
                                <div class="row">
                                    sssssssssssssssssssss
                                </div>
                            </div>
                            </div>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

    </header>
    <header class="header-main mobile-menu" id="header">
        <div class="container">
            <div class="header-content">

                    <a class="canvas-btn-mobile " data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <i class="fa fa-bars"></i>
                    </a>
                        <a href="#" class="logo">PIASSAT</a>
                    <div class="header-icons">
                        <a href="#" class="header-icon">
                            <i class="fas fa-user"></i> 
                        </a>
                </div>
            </div>
            <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher des pièces auto...">
                    <button onclick="performSearch()"><i class="fas fa-search"></i></button>
                </div>
        </div>
    </header>


    <!-- mobile sidebar -->

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
            Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
            </div>
            <div class="dropdown mt-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Dropdown button
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
            </div>
        </div>
    </div>
<!-- mobile sidebar -->

    @yield('content')

    <!-- Footer -->

    <div class="footer-top pb-5">
        <div class="container">
            <div class="services-footer">
                <div class="title-group mb-5 has-border">
                    <h2>NOS ENGAGEMENTS</h2>
                </div>
                <div class="row service-wrapper">
                    <div class="col-sm">
                        <div class="service-item">
                            <div class="image-service">
                                <picture>
                                    <source type="image/webp" srcset="https://piassaty.ma/media/wysiwyg/authentic.webp" loading="lazy" alt="Icon" width="100" height="100">
                                    <img src="https://piassaty.ma/media/wysiwyg/authentic.png" loading="lazy" alt="Icon" width="100" height="100">
                                </picture>
                            </div>
                            <div class="info-service">
                                <h3>Marques en exclusivité</h3>
                                <p>Pièces exclusives, neuves et au meilleur prix</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="service-item">
                            <div class="image-service">
                                <picture>
                                    <source type="image/webp" srcset="https://piassaty.ma/media/wysiwyg/customer-service.webp" loading="lazy" alt="Icon" width="100" height="100">
                                    <img src="https://piassaty.ma/media/wysiwyg/customer-service.png" loading="lazy" alt="Icon" width="100" height="100">
                                </picture>
                            </div>
                            <div class="info-service">
                                <h3>Conseil d'experts</h3>
                                <p>Service client disponible du lundi au samedi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="service-item">
                            <div class="image-service">
                                <picture>
                                    <source type="image/webp" srcset="https://piassaty.ma/media/wysiwyg/delivery.webp" loading="lazy" alt="icon" width="100" height="100">
                                    <img src="https://piassaty.ma/media/wysiwyg/delivery.png" loading="lazy" alt="icon" width="100" height="100">
                                </picture>
                            </div>
                            <div class="info-service">
                                <h3>Livraison express</h3>
                                <p>Livraison à domicile ou retrait en magasin</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="service-item">
                            <div class="image-service">
                                <picture>
                                    <source type="image/webp" srcset="https://piassaty.ma/media/wysiwyg/super-deals.webp" loading="lazy" alt="icon" width="100" height="100">
                                    <img src="https://piassaty.ma/media/wysiwyg/super-deals.png" loading="lazy" alt="icon" width="100" height="100">
                                </picture>
                            </div>
                            <div class="info-service">
                                <h3>Remises inédites</h3>
                                <p>Sur une large sélection de pièces et accessoires</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="service-item">
                            <div class="image-service">
                                <picture>
                                    <source type="image/webp" srcset="https://piassaty.ma/media/wysiwyg/money-back.webp" loading="lazy" alt="icon" width="100" height="100">
                                    <img src="https://piassaty.ma/media/wysiwyg/money-back.png" loading="lazy" alt="icon" width="100" height="100">
                                </picture>
                            </div>
                            <div class="info-service">
                                <h3>Satisfait ou remboursé</h3>
                                <p>Garantie de retour pendant 30 jours</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="service-item">
                            <div class="image-service">
                                <picture>
                                    <source type="image/webp" srcset="https://piassaty.ma/media/wysiwyg/secure-payment.webp" loading="lazy" alt="icon" width="100" height="100">
                                    <img src="https://piassaty.ma/media/wysiwyg/secure-payment.png" loading="lazy" alt="icon" width="100" height="100">
                                </picture>
                            </div>
                                <div class="info-service">
                                <h3>Paiement sécurisé</h3>
                            <p>Informations de transaction protégées lors de l'achat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="contact">
        <div class="container">
            <div class="footer-content row">
                <div class="footer-section col-md-3">
                    <h3>À PROPOS DE PIASSAT</h3>
                    <p style="color: rgba(255,255,255,0.8); line-height: 1.6;">
                        Leader marocain de la distribution de pièces automobiles. Qualité garantie et service professionnel.
                    </p>
                    <div class="social-links ">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-section col-md-3">
                    <h3>AIDE CLIENT</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Contact</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Livraison</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Retours & Remboursements</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section col-md-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1037.6641149144832!2d-7.5427905300841385!3d33.579669788451476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda7cd003b6851df%3A0x2d8eea33b3b3528b!2sBEST%20ORIGINAL%20PARTS!5e1!3m2!1sfr!2sma!4v1761650349042!5m2!1sfr!2sma" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 mohamad - Tous droits réservés | Développé avec ❤️ au Abdo Agency</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Cart Modal -->
    <div class="modal" id="cartModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeCart()">&times;</button>
            <h2 style="margin-bottom: 20px; color: #1e2847;">Votre Panier</h2>
            <div id="cartItems"></div>
            <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #eee;">
                <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; margin-bottom: 20px;">
                    <span>Total:</span>
                    <span id="cartTotal" style="color: #e31e24;">0.00 MAD</span>
                </div>
                <button style="width: 100%; background: #e31e24; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer;" onclick="checkout()">
                    <i class="fas fa-credit-card"></i> Passer la commande
                </button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/plugins/ModifiersPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script src="{{ asset('assets/site/js/script.js')}}"></script>
</body>
</html>
