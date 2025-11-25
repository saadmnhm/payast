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

// ============================================
// CHECKOUT STEPPER FUNCTIONALITY
// ============================================

let currentStep = 1;
const totalSteps = 3;

function initCheckoutStepper() {
    // Load cart items into checkout page
    loadCheckoutCartItems();
    
    // Shipping method change handler
    const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const deliveryCard = document.getElementById('delivery-address-card');
            const deliveryPrice = document.getElementById('delivery-price');
            
            if (this.value === 'delivery') {
                deliveryCard.style.display = 'block';
                if (deliveryPrice) {
                    deliveryPrice.textContent = '30.00 DH';
                }
                updateShippingCost(30);
            } else {
                deliveryCard.style.display = 'none';
                if (deliveryPrice) {
                    deliveryPrice.textContent = 'Gratuit';
                }
                updateShippingCost(0);
            }
            
            // Recalculate summary
            const subtotalEl = document.getElementById('subtotal');
            const subtotal = subtotalEl ? parseFloat(subtotalEl.textContent) || 0 : 0;
            updateCheckoutSummary(subtotal);
            updateFinalSummary();
        });
    });

    // Form submission handler
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            processOrder();
        });
    }
}

function nextStep() {
    if (currentStep < totalSteps) {
        // Validate current step
        if (!validateStep(currentStep)) {
            return;
        }

        // Hide current step
        document.querySelector(`.stepper-step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.stepper-item[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.stepper-item[data-step="${currentStep}"]`).classList.add('completed');
        
        // Show next step
        currentStep++;
        document.querySelector(`.stepper-step[data-step="${currentStep}"]`).classList.add('active');
        document.querySelector(`.stepper-item[data-step="${currentStep}"]`).classList.add('active');
        
        // Update summary for step 2 and 3
        if (currentStep === 2 || currentStep === 3) {
            updateStepSummary(currentStep);
        }
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function prevStep() {
    if (currentStep > 1) {
        // Hide current step
        document.querySelector(`.stepper-step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.stepper-item[data-step="${currentStep}"]`).classList.remove('active');
        
        // Show previous step
        currentStep--;
        document.querySelector(`.stepper-step[data-step="${currentStep}"]`).classList.add('active');
        document.querySelector(`.stepper-item[data-step="${currentStep}"]`).classList.remove('completed');
        document.querySelector(`.stepper-item[data-step="${currentStep}"]`).classList.add('active');
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateStep(step) {
    if (step === 1) {
        // Check if cart is not empty
        const cartItems = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        if (cartItems.length === 0) {
            showNotification('Votre panier est vide');
            return false;
        }
    } else if (step === 2) {
        // Validate contact information
        const requiredFields = ['first_name', 'last_name', 'email', 'phone'];
        for (const field of requiredFields) {
            const input = document.getElementById(field);
            if (!input || !input.value.trim()) {
                if (input) input.focus();
                showNotification(`Veuillez remplir le champ ${input ? input.labels[0].textContent : field}`);
                return false;
            }
        }
        
        // Validate delivery address if delivery selected
        const deliverySelected = document.getElementById('delivery');
        if (deliverySelected && deliverySelected.checked) {
            const deliveryFields = ['address', 'city'];
            for (const field of deliveryFields) {
                const input = document.getElementById(field);
                if (!input || !input.value.trim()) {
                    if (input) input.focus();
                    showNotification(`Veuillez remplir le champ ${input ? input.labels[0].textContent : field}`);
                    return false;
                }
            }
        }
    } else if (step === 3) {
        // Check terms checkbox
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox || !termsCheckbox.checked) {
            showNotification('Veuillez accepter les conditions générales de vente');
            return false;
        }
    }
    return true;
}

function loadCheckoutCartItems() {
    const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
    const tbody = document.getElementById('cart-items-body');
    
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    let subtotal = 0;
    
    cart.forEach((item, index) => {
        const itemTotal = (item.price || 0) * (item.quantity || 1);
        subtotal += itemTotal;
        
        const row = `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="${item.image || '/assets/site/image/default-product.png'}" alt="${item.product}" style="width: 150px;  object-fit: cover;" class="me-3">
                        <div>
                            <div class="product-name">${item.product}</div>
                            <small class="text-muted">Réf: ${item.ref || 'N/A'}</small>
                        </div>
                    </div>
                </td>
                <td>${(item.price || 0).toFixed(2)} DH</td>
                <td>
                    <div class="quantity-control">
                        <button type="button" class="btn btn-sm btn-light" onclick="updateCheckoutQuantity(${index}, -1)">-</button>
                        <span class="mx-2">${item.quantity || 1}</span>
                        <button type="button" class="btn btn-sm btn-light" onclick="updateCheckoutQuantity(${index}, 1)">+</button>
                    </div>
                </td>
                <td>${itemTotal.toFixed(2)} DH</td>
                <td>
                    <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeCheckoutItem(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
    
    updateCheckoutSummary(subtotal);
}

function updateCheckoutQuantity(index, change) {
    const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
    const item = cart[index];
    
    if (item) {
        item.quantity = (item.quantity || 1) + change;
        if (item.quantity <= 0) {
            removeCheckoutItem(index);
            return;
        }
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        loadCheckoutCartItems();
        updateCartCount();
    }
}

function removeCheckoutItem(index) {
    let cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
    cart.splice(index, 1);
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    loadCheckoutCartItems();
    updateCartCount();
}

function updateCheckoutSummary(subtotal) {
    const shippingCostEl = document.getElementById('shipping-cost');
    const shippingCost = shippingCostEl ? parseFloat(shippingCostEl.textContent) || 0 : 0;
    const tax = subtotal * 0.20;
    const total = subtotal + shippingCost + tax;
    
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const totalEl = document.getElementById('total');
    
    if (subtotalEl) subtotalEl.textContent = subtotal.toFixed(2) + ' DH';
    if (taxEl) taxEl.textContent = tax.toFixed(2) + ' DH';
    if (totalEl) totalEl.textContent = total.toFixed(2) + ' DH';
}

function updateStepSummary(step) {
    const subtotalEl = document.getElementById('subtotal');
    const subtotal = subtotalEl ? parseFloat(subtotalEl.textContent) || 0 : 0;
    
    const shippingCostEl = document.getElementById('shipping-cost');
    const shippingCost = shippingCostEl ? parseFloat(shippingCostEl.textContent) || 0 : 0;
    
    const tax = subtotal * 0.20;
    const total = subtotal + shippingCost + tax;
    
    const subtotalStepEl = document.getElementById(`subtotal-step${step}`);
    const shippingStepEl = document.getElementById(`shipping-cost-step${step}`);
    const taxStepEl = document.getElementById(`tax-step${step}`);
    const totalStepEl = document.getElementById(`total-step${step}`);
    
    if (subtotalStepEl) subtotalStepEl.textContent = subtotal.toFixed(2) + ' DH';
    if (shippingStepEl) shippingStepEl.textContent = shippingCost.toFixed(2) + ' DH';
    if (taxStepEl) taxStepEl.textContent = tax.toFixed(2) + ' DH';
    if (totalStepEl) totalStepEl.textContent = total.toFixed(2) + ' DH';
}

function updateShippingCost(cost) {
    const shippingCostEl = document.getElementById('shipping-cost');
    if (shippingCostEl) {
        shippingCostEl.textContent = cost.toFixed(2) + ' DH';
    }
    
    // Update shipping cost for all steps
    ['', '-step2', '-step3'].forEach(suffix => {
        const el = document.getElementById(`shipping-cost${suffix}`);
        if (el) {
            el.textContent = cost.toFixed(2) + ' DH';
        }
    });
}

function calculateShippingCost() {
    // Check if delivery is selected
    const deliveryRadio = document.getElementById('delivery');
    const cost = (deliveryRadio && deliveryRadio.checked) ? 30 : 0;
    
    updateShippingCost(cost);
    
    const subtotalEl = document.getElementById('subtotal');
    const subtotal = subtotalEl ? parseFloat(subtotalEl.textContent) || 0 : 0;
    updateCheckoutSummary(subtotal);
}

function updateFinalSummary() {
    const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
    const finalShippingEl = document.getElementById('final-shipping-method');
    
    if (shippingMethod && finalShippingEl) {
        const methodText = shippingMethod.value === 'pickup' ? 'Retrait en point de vente' : 'Livraison express';
        finalShippingEl.textContent = methodText;
    }
}

function applyCoupon() {
    const codeInput = document.getElementById('coupon_code');
    const messageEl = document.getElementById('coupon-message');
    
    if (!codeInput || !messageEl) return;
    
    const code = codeInput.value;
    
    if (!code) {
        messageEl.innerHTML = '<small class="text-danger">Veuillez entrer un code promo</small>';
        return;
    }
    
    if (code.toUpperCase() === 'PROMO10') {
        messageEl.innerHTML = '<small class="text-success"><i class="fas fa-check-circle"></i> Code appliqué avec succès</small>';
        const discountRow = document.getElementById('discount-row');
        const discountEl = document.getElementById('discount');
        
        if (discountRow) discountRow.style.display = 'flex';
        if (discountEl) discountEl.textContent = '-100.00 DH';
    } else {
        messageEl.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle"></i> Code invalide</small>';
    }
}

function processOrder() {
    const checkoutForm = document.getElementById('checkout-form');
    if (!checkoutForm) return;
    
    const formData = new FormData(checkoutForm);
    
    // Add cart items to form data
    const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
    formData.append('cart_items', JSON.stringify(cart));
    
    // Show loading
    const submitBtn = checkoutForm.querySelector('button[type="submit"]');
    if (!submitBtn) return;
    
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Traitement...';
    
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const headers = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    };
    
    if (csrfToken) {
        headers['X-CSRF-TOKEN'] = csrfToken.content;
    }
    
    fetch('/checkout/process', {
        method: 'POST',
        body: formData,
        headers: headers
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear cart
            localStorage.removeItem(CART_KEY);
            
            // Redirect to success page
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                showNotification('Commande confirmée !', 'success');
                window.location.href = '/';
            }
        } else {
            throw new Error(data.message || 'Erreur lors du traitement de la commande');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Une erreur est survenue', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function continueShopping() {
    window.location.href = '/';
}

// ============================================
// INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    // Initialize cart
    loadCart();
    updateCartCount();
    updateCartTotal();
    
    const cartDropdown = document.getElementById('cartDropdown');
    if (cartDropdown) {
        updateCartDropdown();
    }
    
    // Initialize checkout stepper if on checkout page
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        initCheckoutStepper();
    }
    
    // Animate elements
    const animateElements = document.querySelectorAll('.category-item, .product-card, .service-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });

    // Cart modal click outside to close
    const cartModal = document.getElementById('cartModal');
    if (cartModal) {
        cartModal.addEventListener('click', (e) => {
            if (e.target.id === 'cartModal') {
                closeCart();
            }
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('cartDropdown');
        const trigger = document.querySelector('.cart-trigger');
        
        if (dropdown && !dropdown.contains(e.target) && (!trigger || !trigger.contains(e.target))) {
            closeCartDropdown();
        }
    });
});