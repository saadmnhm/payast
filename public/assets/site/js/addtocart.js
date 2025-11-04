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

function addToCart(product, image, price) {
    cart.push({ product, image, price: Number(price) || 0 });
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
        showNotification('Votre panier est vide!');
        return;
    }
    
    window.location.href = '/checkout/cart';
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


function loadCartItems() {
    const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
    const tbody = document.getElementById('cart-items-body');
    
    if (cart.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3 d-block"></i>
                    <p class="text-muted">Votre panier est vide</p>
                    <a href="/" class="btn btn-primary mt-3">Continuer vos achats</a>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = cart.map((item, index) => `
        <tr>
            <td data-label="Article">
                <div class="d-flex align-items-center gap-3">
                    <div style="min-width: 60px;">
                        <img src="${item.image || '/assets/site/image/default-product.png'}" alt="${item.product}" class="cart-item-image">
                    </div>
                    <div>
                        <a href="#" class="cart-item-name">${item.product}</a>
                        <small class="text-muted d-block">Réf: ${item.ref || 'N/A'}</small>
                    </div>
                </div>
            </td>
            <td data-label="Prix"><strong>${Number(item.price || 0).toFixed(2)} DH</strong></td>
            <td data-label="Quantité">
                <input type="number" class="qty-input" value="${item.quantity || 1}" min="1" max="99"
                       onchange="updateQuantity(${index}, this.value)">
            </td>
            <td data-label="Sous-total"><strong class="text-danger">${(Number(item.price || 0) * (item.quantity || 1)).toFixed(2)} DH</strong></td>
            <td>
                <button class="btn-remove" onclick="removeItem(${index})" title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
    
    calculateTotals();
}

function updateQuantity(index, quantity) {
    const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
    const qty = parseInt(quantity) || 1;
    
    if (cart[index]) {
        cart[index].quantity = qty;
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        loadCartItems();
        
        if (typeof updateCartCount === 'function') {
            updateCartCount();
        }
    }
}

function removeItem(index) {
    if (!confirm('Voulez-vous vraiment supprimer cet article ?')) {
        return;
    }
    
    const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
    cart.splice(index, 1);
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    loadCartItems();
    
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }
    
    showNotification('Article retiré du panier');
}

function calculateTotals() {
    const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
    const subtotal = cart.reduce((sum, item) => sum + (Number(item.price || 0) * (item.quantity || 1)), 0);
    const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
    const shipping = shippingMethod && shippingMethod.value === 'delivery' ? 30 : 0;
    const tax = subtotal * 0.20;
    const discount = 0;
    const total = subtotal + shipping + tax - discount;
    
    document.getElementById('subtotal').textContent = subtotal.toFixed(2) + ' DH';
    document.getElementById('shipping-cost').textContent = shipping.toFixed(2) + ' DH';
    document.getElementById('tax').textContent = tax.toFixed(2) + ' DH';
    document.getElementById('total').textContent = total.toFixed(2) + ' DH';
}

function applyCoupon() {
    const code = document.getElementById('coupon_code').value.trim();
    
    if (!code) {
        showNotification('Veuillez entrer un code promo');
        return;
    }
    
    showNotification('Code promo appliqué avec succès!');
    document.getElementById('discount-row').style.display = 'flex';
    document.getElementById('discount').textContent = '-50.00 DH';
    calculateTotals();
}

function proceedToCheckout() {
    const cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
    
    if (cart.length === 0) {
        showNotification('Votre panier est vide!');
        return;
    }
    
    const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
    if (!shippingMethod) {
        showNotification('Veuillez sélectionner une méthode de livraison');
        return;
    }
    
    if (shippingMethod.value === 'delivery') {
        const city = document.getElementById('city').value.trim();
        const postcode = document.getElementById('postcode').value.trim();
        
        if (!city || !postcode) {
            showNotification('Veuillez remplir l\'adresse de livraison');
            return;
        }
    }
    
    showNotification('Redirection vers le paiement...');
    
    setTimeout(() => {
        alert('Paiement - À implémenter');
    }, 1000);
}

function continueShopping() {
    window.location.href = '/';
}

function showNotification(message) {
    if (typeof window.showNotification === 'function') {
        window.showNotification(message);
        return;
    }
    
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
        animation: slideIn 0.3s ease-out;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    loadCartItems();
    
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const addressForm = document.getElementById('shipping-address');
            if (this.value === 'delivery') {
                addressForm.style.display = 'block';
            } else {
                addressForm.style.display = 'none';
            }
            calculateTotals();
        });
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
    const footer = document.querySelector('.cart-dropdown-footer');
  
    if (!itemsDiv || !totalSpan) {
        console.warn('Cart dropdown elements not found');
        return;
    }

    if (cart.length === 0) {
        itemsDiv.innerHTML = '<p class="empty-cart">Votre panier est vide</p>';
        footer.style.display = 'none';
        totalSpan.textContent = '0.00 MAD';
    } else {
        let total = 0;
        footer.style.display = 'block';
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