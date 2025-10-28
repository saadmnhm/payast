        // Cart functionality
        let cart = [];

        function addToCart(product, price) {
            cart.push({ product, price });
            updateCartCount();
            showNotification('Produit ajouté au panier!');
        }

        function updateCartCount() {
            document.getElementById('cartCount').textContent = cart.length;
        }

        function openCart(e) {
            e.preventDefault();
            const modal = document.getElementById('cartModal');
            const itemsDiv = document.getElementById('cartItems');

            if (cart.length === 0) {
                itemsDiv.innerHTML = '<p style="text-align: center; color: #666; padding: 40px 0;">Votre panier est vide</p>';
                document.getElementById('cartTotal').textContent = '0.00 MAD';
            } else {
                let total = 0;
                itemsDiv.innerHTML = cart.map((item, index) => {
                    total += item.price;
                    return `
                        <div style="display: flex; justify-content: space-between; padding: 15px; border-bottom: 1px solid #eee;">
                            <span>${item.product}</span>
                            <div>
                                <span style="color: #e31e24; font-weight: bold; margin-right: 15px;">${item.price} MAD</span>
                                <button onclick="removeFromCart(${index})" style="background: none; border: none; color: #999; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');
                document.getElementById('cartTotal').textContent = total.toFixed(2) + ' MAD';
            }

            modal.classList.add('active');
        }

        function closeCart() {
            document.getElementById('cartModal').classList.remove('active');
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartCount();
            openCart({ preventDefault: () => {} });
        }

        function checkout() {
            if (cart.length === 0) {
                alert('Votre panier est vide!');
                return;
            }
            alert('Fonction de paiement - À implémenter');
            cart = [];
            updateCartCount();
            closeCart();
        }

        // Search functionality
        function performSearch() {
            const query = document.getElementById('searchInput').value;
            if (query.trim()) {
                showNotification(`Recherche: ${query}`);
            }
        }

        // Vehicle search
        function searchVehicle(e) {
            e.preventDefault();
            const brand = document.getElementById('brand').value;
            const model = document.getElementById('model').value;
            const version = document.getElementById('version').value;

            if (!brand) {
                alert('Veuillez sélectionner un constructeur');
                return;
            }

            showNotification('Recherche de pièces en cours...');
        }

        function loadModels() {
            const model = document.getElementById('model');
            model.innerHTML = '<option value="">MODÈLE</option><option value="model1">Clio</option><option value="model2">Megane</option>';
        }

        function loadVersions() {
            const version = document.getElementById('version');
            version.innerHTML = '<option value="">VERSION</option><option value="v1">1.5 dCi</option><option value="v2">1.6 16V</option>';
        }

        // Filter functions
        function filterByBrand(brand) {
            showNotification(`Filtrage par marque: ${brand}`);
        }

        function filterCategory(category) {
            showNotification(`Catégorie: ${category}`);
        }

        function showPromo() {
            showNotification('Redirection vers les promotions...');
        }

        // Newsletter
        function subscribeNewsletter(e) {
            e.preventDefault();
            const email = e.target.querySelector('input').value;
            showNotification('Merci de votre inscription!');
            e.target.reset();
        }

        // Notification system
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #e31e24;
                color: white;
                padding: 15px 25px;
                border-radius: 8px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.3);
                z-index: 3000;
                animation: slideInLeft 0.3s ease-out;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'fadeInUp 0.3s ease-out reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Scroll functions
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Mobile menu
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }

        // Scroll event listeners
        window.addEventListener('scroll', () => {
            const scrollTop = document.getElementById('scrollTop');
            const header = document.getElementById('header');

            if (window.scrollY > 300) {
                scrollTop.classList.add('visible');
                header.classList.add('scrolled');
            } else {
                scrollTop.classList.remove('visible');
                header.classList.remove('scrolled');
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            // Animate elements on scroll
            const animateElements = document.querySelectorAll('.category-item, .product-card, .service-card');
            animateElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });

            // Close modal on outside click
            document.getElementById('cartModal').addEventListener('click', (e) => {
                if (e.target.id === 'cartModal') {
                    closeCart();
                }
            });
        });


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


// Owl Carousel Initialization
$('.owl-carousel').owlCarousel({
    loop:true,
    dots:false,
    nav:true,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
})
// Owl Carousel Initialization
$('.owl-carousel2').owlCarousel({
    loop:true,
    dots:false,
    nav:true,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
})