@extends('front.layout')

@section('title_front', 'Passe la commande')



@section('content')

<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">Finaliser ma commande</h1>
        <p class="text-muted">Suivez les étapes pour valider votre achat</p>
    </div>

    <!-- Stepper Container -->
    <div class="checkout-stepper-container">
        <!-- Stepper Navigation -->
        <div class="stepper-nav mb-5">
            <div class="stepper-item active" data-step="1">
                <div class="stepper-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stepper-label">
                    <h3 class="stepper-title">Panier</h3>
                    <div class="stepper-desc">Vérifiez vos articles</div>
                </div>
            </div>

            <div class="stepper-line"></div>

            <div class="stepper-item" data-step="2">
                <div class="stepper-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stepper-label">
                    <h3 class="stepper-title">Livraison</h3>
                    <div class="stepper-desc">Informations de livraison</div>
                </div>
            </div>

            <div class="stepper-line"></div>

            <div class="stepper-item" data-step="3">
                <div class="stepper-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stepper-label">
                    <h3 class="stepper-title">Paiement</h3>
                    <div class="stepper-desc">Mode de paiement</div>
                </div>
            </div>
        </div>

        <!-- Stepper Content Form -->
        <form id="checkout-form" class="stepper-content">
            @csrf

            <!-- Step 1: Cart Review -->
            <div class="stepper-step active" data-step="1">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Articles dans votre panier</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table cart-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Article</th>
                                                <th>Prix unitaire</th>
                                                <th>Quantité</th>
                                                <th>Sous-total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-items-body">
                                            <!-- Cart items loaded by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="card position-sticky" style="top: 20px;">
                            <div class="card-header">
                                <h3 class="card-title">Récapitulatif</h3>
                            </div>
                            <div class="card-body">
                                <div class="summary-row">
                                    <span>Sous-total</span>
                                    <span id="subtotal">0.00 DH</span>
                                </div>
                                <div class="summary-row">
                                    <span>Livraison</span>
                                    <span id="shipping-cost">0.00 DH</span>
                                </div>
                                <div class="summary-row">
                                    <span>TVA (20%)</span>
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
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('front.list') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Continuer mes achats
                    </a>
                    <button type="button" class="btn btn-danger" onclick="nextStep()">
                        Suivant <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Shipping Information -->
            <div class="stepper-step" data-step="2">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Méthode de livraison</h3>
                            </div>
                            <div class="card-body">
                                <div class="shipping-options">
                                    <div class="form-check shipping-option-card mb-3">
                                        <input class="form-check-input" type="radio" name="shipping_method" id="pickup" value="pickup" checked>
                                        <label class="form-check-label w-100" for="pickup">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-store text-primary me-2"></i>
                                                    <strong>Retrait en point de vente</strong>
                                                    <span class="d-block text-muted small">Disponible sous 2h</span>
                                                </div>
                                                <span class="badge bg-success">Gratuit</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                <div class="form-check shipping-option-card">
                                    <input class="form-check-input" type="radio" name="shipping_method" id="delivery" value="delivery">
                                    <label class="form-check-label w-100" for="delivery">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-truck text-primary me-2"></i>
                                                <strong>Livraison express</strong>
                                                <span class="d-block text-muted small">Livraison sous 24-48h</span>
                                            </div>
                                            <span id="delivery-price" class="text-primary fw-bold">30.00 DH</span>
                                        </div>
                                    </label>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informations de contact</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label required">Prénom</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label required">Nom</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label required">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label required">Téléphone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="+212 6XX-XXXXXX" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Address (shown when delivery is selected) -->
                        <div class="card mt-4" id="delivery-address-card" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">Adresse de livraison</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="address" class="form-label required">Adresse complète</label>
                                        <textarea class="form-control" id="address" name="address" rows="2" placeholder="Rue, numéro, bâtiment..."></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city" class="form-label required">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Casablanca">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="postcode" class="form-label">Code postal</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode" placeholder="20000">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Pays</label>
                                        <select class="form-select" id="country" name="country">
                                            <option value="MA" selected>Maroc</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card position-sticky" style="top: 20px;">
                            <div class="card-header">
                                <h3 class="card-title">Récapitulatif</h3>
                            </div>
                            <div class="card-body">
                                <div class="summary-row">
                                    <span>Sous-total</span>
                                    <span id="subtotal-step2">0.00 DH</span>
                                </div>
                                <div class="summary-row">
                                    <span>Livraison</span>
                                    <span id="shipping-cost-step2">0.00 DH</span>
                                </div>
                                <div class="summary-row">
                                    <span>TVA (20%)</span>
                                    <span id="tax-step2">0.00 DH</span>
                                </div>
                                <hr>
                                <div class="summary-row total-row">
                                    <strong>Total TTC</strong>
                                    <strong class="text-danger" id="total-step2">0.00 DH</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-light" onclick="prevStep()">
                        <i class="fas fa-arrow-left"></i> Retour
                    </button>
                    <button type="button" class="btn btn-danger" onclick="nextStep()">
                        Suivant <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Payment Method -->
            <div class="stepper-step" data-step="3">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Mode de paiement</h3>
                            </div>
                            <div class="card-body">
                                <div class="payment-options">
                                    <div class="form-check payment-option-card mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" checked>
                                        <label class="form-check-label w-100" for="cash">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                                                <div>
                                                    <strong>Paiement à la livraison</strong>
                                                    <span class="d-block text-muted small">Payez en espèces lors de la réception</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- <div class="form-check payment-option-card mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                                        <label class="form-check-label w-100" for="card">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-credit-card fa-2x text-primary me-3"></i>
                                                <div>
                                                    <strong>Carte bancaire</strong>
                                                    <span class="d-block text-muted small">Paiement sécurisé par carte</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-check payment-option-card">
                                        <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer">
                                        <label class="form-check-label w-100" for="transfer">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-university fa-2x text-info me-3"></i>
                                                <div>
                                                    <strong>Virement bancaire</strong>
                                                    <span class="d-block text-muted small">Paiement par virement</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div> -->
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        J'accepte les <a href="#" class="text-primary">conditions générales de vente</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card position-sticky" style="top: 20px;">
                            <div class="card-header">
                                <h3 class="card-title">Récapitulatif final</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2">Livraison</small>
                                    <div class="fw-bold" id="final-shipping-method">Retrait en point de vente</div>
                                </div>
                                <hr>
                                <div class="summary-row">
                                    <span>Sous-total</span>
                                    <span id="subtotal-step3">0.00 DH</span>
                                </div>
                                <div class="summary-row">
                                    <span>Livraison</span>
                                    <span id="shipping-cost-step3">0.00 DH</span>
                                </div>
                                <div class="summary-row">
                                    <span>TVA (20%)</span>
                                    <span id="tax-step3">0.00 DH</span>
                                </div>
                                <hr>
                                <div class="summary-row total-row">
                                    <strong>Total à payer</strong>
                                    <strong class="text-danger fs-4" id="total-step3">0.00 DH</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-light" onclick="prevStep()">
                        <i class="fas fa-arrow-left"></i> Retour
                    </button>
                    <button type="submit" class="btn btn-success btn-lg"> Confirmer la commande
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>

</style>
@endsection