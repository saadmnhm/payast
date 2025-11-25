@extends('front.layout')

@section('title_front', 'Commande confirmée')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h1 class="mb-3">Commande confirmée !</h1>
                    <p class="lead text-muted mb-4">
                        Merci pour votre commande. Nous avons bien reçu votre demande.
                    </p>
                    
                    <div class="alert alert-light border mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 text-start">
                                <strong>Numéro de commande :</strong>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="fs-4 fw-bold  color_e31e24">{{ $order->order_number }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-start mb-4">
                        <h5 class="mb-3">Récapitulatif de votre commande</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th class="text-end">Prix</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td colspan="2">Total TTC</td>
                                        <td class="text-end text-danger fs-4">{{ $order->formatted_total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <p class="text-muted small">
                        Un email de confirmation a été envoyé à <strong>{{ $order->email }}</strong>
                    </p>

                    <div class="d-flex gap-3 justify-content-center mt-4 ">
                        <a href="{{ route('front.home') }}" class="btn bg_e31e24 btn-primary">
                            <i class="fas fa-home me-2"></i> Retour à l'accueil
                        </a>
                        <a href="{{ route('front.list') }}" class="btn btn-outline-primary btn_red_hover border_e31e24">
                            <i class="fas fa-shopping-bag me-2"></i> Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Clear cart after successful order
localStorage.removeItem('piassat_cart');
updateCartCount();
</script>
@endsection