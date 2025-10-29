let cart = [];

const CART_KEY = 'piassat_cart';

function saveCart() {
    try {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    } catch (e) {
        console.warn('Could not save cart to localStorage', e);
    }
}

function loadCart() {
    try {
        const raw = localStorage.getItem(CART_KEY);
        if (raw) {
            cart = JSON.parse(raw) || [];
        } else {
            cart = [];
        }
    } catch (e) {
        console.warn('Could not load cart from localStorage', e);
        cart = [];
    }
}

function formatCurrency(amount) {
    return Number(amount || 0).toFixed(2) + ' MAD';
}

function updateCartTotal() {
    const total = cart.reduce((sum, item) => sum + (Number(item.price) || 0), 0);
    document.querySelectorAll('#cartTotal').forEach(el => el.textContent = formatCurrency(total));
    return total;
}

function updateCartCount() {
    const count = cart.length;
    const total = cart.reduce((sum, item) => sum + (Number(item.price) || 0), 0);
    
    const countEl = document.getElementById('cartCount');
    const headerTotalEl = document.getElementById('cartTotalHeader');
    
    if (countEl) countEl.textContent = count;
    if (headerTotalEl) headerTotalEl.textContent = total.toFixed(2) + 'DH';
    
    updateCartTotal();
}

function addToCart(product, price) {
    cart.push({ product, price: Number(price) || 0 });
    saveCart();
    updateCartCount();
    showNotification('Produit ajouté au panier!');
    updateCartDropdown();
}

function openCart(e) {
    if (e && e.preventDefault) e.preventDefault();
    const modal = document.getElementById('cartModal');
    const itemsDiv = document.getElementById('cartItems');

    if (!itemsDiv) {
        console.warn('cartItems element not found in DOM');
        return;
    }

    if (cart.length === 0) {
        itemsDiv.innerHTML = '<p style="text-align: center; color: #666; padding: 40px 0;">Votre panier est vide</p>';
        document.querySelectorAll('#cartTotal').forEach(el => el.textContent = formatCurrency(0));
    } else {
        let total = 0;
        itemsDiv.innerHTML = cart.map((item, index) => {
            total += Number(item.price) || 0;
            return `
                <div style="display: flex; justify-content: space-between; padding: 15px; border-bottom: 1px solid #eee;">
                    <span>${item.product}</span>
                    <div>
                        <span style="color: #e31e24; font-weight: bold; margin-right: 15px;">${formatCurrency(item.price)}</span>
                        <button onclick="removeFromCart(${index})" style="background: none; border: none; color: #999; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        }).join('');
        document.querySelectorAll('#cartTotal').forEach(el => el.textContent = formatCurrency(total));
    }

    modal.classList.add('active');
}

function closeCart() {
    const modal = document.getElementById('cartModal');
    if (modal) modal.classList.remove('active');
}

function removeFromCart(index) {
    if (index < 0 || index >= cart.length) return;
    cart.splice(index, 1);
    saveCart();
    updateCartCount();
    updateCartDropdown();
    const modal = document.getElementById('cartModal');
    if (modal && modal.classList.contains('active')) {
        openCart({ preventDefault: () => {} });
    }
}

function checkout() {
    if (cart.length === 0) {
        alert('Votre panier est vide!');
        return;
    }
    alert('Fonction de paiement - À implémenter');
    cart = [];
    saveCart();
    updateCartCount();
    updateCartTotal();
    closeCart();
}



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

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function toggleMenu() {
    document.getElementById('navMenu').classList.toggle('active');
}

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
    const animateElements = document.querySelectorAll('.category-item, .product-card, .service-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });

    const cartModal = document.getElementById('cartModal');
    if (cartModal) {
        cartModal.addEventListener('click', (e) => {
            if (e.target.id === 'cartModal') {
                closeCart();
            }
        });
    }

    loadCart();
    
    updateCartCount();
    updateCartTotal();
    
    const cartDropdown = document.getElementById('cartDropdown');
    if (cartDropdown) {
        updateCartDropdown();
    }
});

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
// filter dropdown
document.querySelectorAll('[id=btn-filter]').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = btn.nextElementSibling;

        document.querySelectorAll('[id=btn-filter]').forEach(other => {
            if (other === btn) return;
            other.classList.remove('active');
            const otherDropdown = other.nextElementSibling;
            if (otherDropdown) otherDropdown.classList.remove('show');
        });

        btn.classList.toggle('active');
        if (dropdown) dropdown.classList.toggle('show');
    });
});

// Cart functionality

function toggleCart(e) {
    e.preventDefault();
    e.stopPropagation();
    const dropdown = document.getElementById('cartDropdown');
    dropdown.classList.toggle('active');
    updateCartDropdown();
}

function closeCartDropdown() {
    document.getElementById('cartDropdown').classList.remove('active');
}

function updateCartDropdown() {
    const itemsDiv = document.getElementById('cartItems');
    const totalSpan = document.getElementById('cartTotal');

    if (!itemsDiv || !totalSpan) {
        console.warn('Cart dropdown elements not found');
        return;
    }

    if (cart.length === 0) {
        itemsDiv.innerHTML = '<p class="empty-cart">Votre panier est vide</p>';
        totalSpan.textContent = '0.00 MAD';
    } else {
        let total = 0;
        itemsDiv.innerHTML = cart.map((item, index) => {
            const price = Number(item.price) || 0;
            total += price;
            return `
                <div class="cart-item">
                    <div class="cart-item-details">
                        <div class="cart-item-name">${item.product}</div>
                        <div class="cart-item-price">${price.toFixed(2)} MAD</div>
                    </div>
                    <button class="cart-item-remove" onclick="removeFromCart(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        }).join('');
        totalSpan.textContent = total.toFixed(2) + ' MAD';
    }
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('cartDropdown');
    const trigger = document.querySelector('.cart-trigger');
    
    if (dropdown && !dropdown.contains(e.target) && !trigger.contains(e.target)) {
        closeCartDropdown();
    }
});