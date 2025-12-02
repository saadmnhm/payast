<x-default-layout>
    @section('title')
        Gestion des commandes
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.orders.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-order-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher une commande" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-order-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        {!! getIcon('filter', 'fs-2') !!}
                        Filtrer
                    </button>
                    
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Options de filtrage</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5">
                            <div class="mb-10">
                                <label class="form-label fw-semibold">Statut:</label>
                                <select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Sélectionner un statut" data-allow-clear="true" data-kt-order-table-filter="status">
                                    <option></option>
                                    <option value="pending">En attente</option>
                                    <option value="confirmed">Confirmée</option>
                                    <option value="processing">En préparation</option>
                                    <option value="shipped">Expédiée</option>
                                    <option value="delivered">Livrée</option>
                                    <option value="cancelled">Annulée</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-order-table-filter="reset">Réinitialiser</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-order-table-filter="filter">Appliquer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="orders-table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">N° Commande</th>
                            <th class="min-w-150px">Client</th>
                            <th class="min-w-100px text-end">Montant</th>
                            <th class="min-w-125px">Date</th>
                            <th class="min-w-100px text-center">Statut</th>
                            <th class="min-w-100px text-center">Paiement</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                        @forelse($orders as $order)
                            <tr data-status="{{ $order->status }}" data-payment-status="{{ $order->payment_status }}">
                                <td>
                                    <a href="{{ route('apps.orders.show', $order) }}" class="text-gray-800 text-hover-primary">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800">{{ $order->first_name }} {{ $order->last_name }}</span>
                                        <span class="text-muted fs-7">{{ $order->email }}</span>
                                    </div>
                                </td>
                                <td class="text-end">{{ number_format($order->total) }} MAD</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'processing' => 'primary',
                                            'shipped' => 'success',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'En attente',
                                            'confirmed' => 'Confirmée',
                                            'processing' => 'En préparation',
                                            'shipped' => 'Expédiée',
                                            'delivered' => 'Livrée',
                                            'cancelled' => 'Annulée'
                                        ];
                                    @endphp
                                    <span class="badge badge-light-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $paymentColors = ['pending' => 'warning', 'paid' => 'success', 'failed' => 'danger'];
                                        $paymentLabels = ['pending' => 'En attente', 'paid' => 'Payé', 'failed' => 'Échoué'];
                                    @endphp
                                    <span class="badge badge-light-{{ $paymentColors[$order->payment_status] ?? 'secondary' }}">
                                        {{ $paymentLabels[$order->payment_status] ?? $order->payment_status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('apps.orders.show', $order) }}" class="btn btn-sm btn-light btn-active-light-primary">
                                        {!! getIcon('eye', 'fs-5', '', 'i') !!}
                                        Voir
                                    </a>
                                    <button type="button" class="btn btn-sm btn-light btn-active-light-danger" data-kt-action="delete_order" data-kt-order-id="{{ $order->id }}">
                                        {!! getIcon('trash', 'fs-5', '', 'i') !!}
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-10">
                                    Aucune commande disponible
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        
    <script>
    // Refs
    const searchInput = document.querySelector('[data-kt-order-table-filter="search"]');
    const statusSelect = document.querySelector('[data-kt-order-table-filter="status"]');
    const rows = document.querySelectorAll('#orders-table tbody tr');

    function filterRows() {
        const searchText = (searchInput?.value || '').toLowerCase().trim();
        const status = (statusSelect?.value || '').toLowerCase().trim();

        rows.forEach(row => {
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
            const rowText = (row.textContent || '').toLowerCase();

            const matchesStatus = !status || rowStatus === status;
            const matchesSearch = !searchText || rowText.includes(searchText);

            row.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
        });
    }

    // Search
    searchInput?.addEventListener('keyup', function() {
        filterRows();
    });

    // Filter button
    document.querySelector('[data-kt-order-table-filter="filter"]')?.addEventListener('click', function() {
        filterRows();
    });

    // Reset
    document.querySelector('[data-kt-order-table-filter="reset"]')?.addEventListener('click', function() {
        if (statusSelect) statusSelect.value = '';
        if (searchInput) searchInput.value = '';
        rows.forEach(row => row.style.display = '');
    });
        
        // Handle status update forms
        document.querySelectorAll('[id^="kt_modal_update_status_form_"]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const orderId = this.querySelector('button[type="submit"]').getAttribute('data-kt-order-id');
                const submitButton = this.querySelector('button[type="submit"]');
                const status = this.querySelector('select[name="status"]').value;
                
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                
                fetch(`{{ route('apps.orders.update-status', '') }}/${orderId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: status })
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
                })
                .catch(error => {
                    Swal.fire({
                        text: 'Une erreur est survenue',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                })
                .finally(() => {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                });
            });
        });

        // Handle delete actions
        document.addEventListener('click', function(e) {
            if (e.target.closest('[data-kt-action="delete_order"]')) {
                e.preventDefault();
                const orderId = e.target.closest('[data-kt-action="delete_order"]').getAttribute('data-kt-order-id');
                
                Swal.fire({
                    text: 'Êtes-vous sûr de vouloir supprimer cette commande ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler',
                    confirmButtonColor: '#d33',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/orders/${orderId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }
        });
        </script>
    @endpush
</x-default-layout>