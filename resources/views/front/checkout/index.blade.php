@extends('front.layout')

@section('content')

<div class="container my-4">
    <h1 class="mb-4">Mon Panier</h1>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Cart Items Table -->
            <div class="cart-table-wrapper mb-4">
                <table class="table cart-table">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cart-items-body">
                        <!-- Cart items will be loaded here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Cart Summary -->
            <div class="cart-summary-card">
                <h4 class="summary-title">Résumé de la commande</h4>
                
                <!-- Shipping Method -->
                <div class="shipping-section mb-4">
                    <h5 class="section-title">Méthode de livraison</h5>
                    
                    <div class="shipping-options">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="shipping_method" id="pickup" value="pickup" checked>
                            <label class="form-check-label" for="pickup">
                                <strong>Retrait en point de vente</strong>
                                <span class="text-muted d-block">Gratuit</span>
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="shipping_method" id="delivery" value="delivery">
                            <label class="form-check-label" for="delivery">
                                <strong>Livraison express</strong>
                                <span class="text-muted d-block">À calculer</span>
                            </label>
                        </div>
                    </div>

                    <!-- Shipping Address (shown when delivery is selected) -->
                    <div id="shipping-address" class="shipping-address-form" style="display: none;">
                        <div class="mb-3">
                            <label for="country" class="form-label">Pays</label>
                            <select class="form-select" id="country">
                                <option value="MA" selected>Maroc</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="city" class="form-label">Ville</label>
                            <input type="text" class="form-control" id="city" placeholder="Entrez votre ville">
                        </div>
                        
                        <div class="mb-3">
                            <label for="postcode" class="form-label">Code postal</label>
                            <input type="text" class="form-control" id="postcode" placeholder="Code postal">
                        </div>
                    </div>
                </div>

                <!-- Discount Coupon -->
                <div class="discount-section mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="section-title mb-0">Code promo</h5>
                        <button class="btn btn-link btn-sm p-0" type="button" data-bs-toggle="collapse" data-bs-target="#couponCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    
                    <div class="collapse" id="couponCollapse">
                        <div class="input-group">
                            <input type="text" class="form-control" id="coupon_code" placeholder="Entrez votre code">
                            <button class="btn btn-outline-secondary" type="button" onclick="applyCoupon()">
                                Appliquer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Sous-total</span>
                        <span id="subtotal">0.00 DH</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Livraison</span>
                        <span id="shipping-cost">0.00 DH</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Taxe (20%)</span>
                        <span id="tax">0.00 DH</span>
                    </div>
                    
                    <div class="summary-row discount-row" id="discount-row" style="display: none;">
                        <span>Réduction</span>
                        <span class="text-success" id="discount">-0.00 DH</span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-row total-row">
                        <strong>Total TTC</strong>
                        <strong class="text-danger" id="total">0.00 DH</strong>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button class="btn btn-checkout w-100 mt-3" onclick="proceedToCheckout()">
                    <i class="fas fa-lock"></i> Passer la commande
                </button>
                
                <button class="btn btn-outline-secondary w-100 mt-2" onclick="continueShopping()">
                    <i class="fas fa-arrow-left"></i> Continuer mes achats
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>

</style>
@endsection

@section('scripts')
<script>
// Use existing CART_KEY from main script or define it
if (typeof CART_KEY === 'undefined') {
    var CART_KEY = 'piassat_cart';
}


</script>
@endsection




