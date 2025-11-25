<x-default-layout>
    @section('title')
        Commande #{{ $order->order_number }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.orders.show', $order) }}
    @endsection

    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        {{-- Order Details --}}
        <div class="card card-flush flex-row-fluid">
            <div class="card-header">
                <div class="card-title">
                    <h2>Commande #{{ $order->order_number }}</h2>
                </div>
                <div class="card-toolbar">
                    <span class="badge badge-light-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                        <thead>
                            <tr class="border-bottom fs-6 fw-bold text-muted">
                                <th class="min-w-175px pb-2">Produit</th>
                                <th class="min-w-70px text-end pb-2">Qté</th>
                                <th class="min-w-80px text-end pb-2">Prix unitaire</th>
                                <th class="min-w-100px text-end pb-2">Total</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->piece && $item->piece->image)
                                            <img src="{{ asset('uploads/'.$item->piece->image) }}" class="w-50px ms-n1 me-3" alt="">
                                        @endif
                                        <div class="ms-5">
                                            <div class="fw-bold">{{ $item->product_name }}</div>
                                            <div class="fs-7 text-muted">Réf: {{ $item->product_reference }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">{{ $item->formatted_price }}</td>
                                <td class="text-end">{{ $item->formatted_subtotal }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-end">Sous-total</td>
                                <td class="text-end">{{ number_format($order->subtotal, 2) }} DH</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Livraison</td>
                                <td class="text-end">{{ number_format($order->shipping_cost, 2) }} DH</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">TVA (20%)</td>
                                <td class="text-end">{{ number_format($order->tax, 2) }} DH</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="fs-3 text-dark fw-bold text-end">Total</td>
                                <td class="text-dark fs-3 fw-bolder text-end">{{ $order->formatted_total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Customer & Delivery Info --}}
        <div class="flex-lg-row-auto w-100 w-xl-400px">
            <div class="card card-flush mb-6">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Client</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-5">
                        <div class="fw-bold text-gray-600 mb-2">Nom complet</div>
                        <div class="fw-bold">{{ $order->first_name }} {{ $order->last_name }}</div>
                    </div>
                    <div class="mb-5">
                        <div class="fw-bold text-gray-600 mb-2">Email</div>
                        <div class="fw-bold">{{ $order->email }}</div>
                    </div>
                    <div class="mb-5">
                        <div class="fw-bold text-gray-600 mb-2">Téléphone</div>
                        <div class="fw-bold">{{ $order->phone }}</div>
                    </div>
                </div>
            </div>

            @if($order->shipping_method === 'delivery')
            <div class="card card-flush mb-6">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Adresse de livraison</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="fw-bold">{{ $order->address }}</div>
                    <div class="fw-bold">{{ $order->city }}, {{ $order->postcode }}</div>
                </div>
            </div>
            @endif

            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Actions</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <select class="form-select mb-3" id="order-status" data-order-id="{{ $order->id }}">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En préparation</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Expédiée</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    <button type="button" class="btn btn-primary w-100" id="update-status-btn">
                        Mettre à jour le statut
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.getElementById('update-status-btn').addEventListener('click', function() {
        const orderId = document.getElementById('order-status').dataset.orderId;
        const status = document.getElementById('order-status').value;
        
        fetch(`/orders/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e31e24'
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
    </script>
    @endpush
</x-default-layout>