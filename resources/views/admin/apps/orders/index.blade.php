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
            {{ $dataTable->table() }}
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        
        <script>
        // Handle status update forms
        document.querySelectorAll('[id^="kt_modal_update_status_form_"]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const orderId = this.querySelector('button[type="submit"]').getAttribute('data-kt-order-id');
                const submitButton = this.querySelector('button[type="submit"]');
                const status = this.querySelector('select[name="status"]').value;
                
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                
                fetch(`/orders/${orderId}/status`, {
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
                            window.LaravelDataTables['orders-table'].ajax.reload();
                            bootstrap.Modal.getInstance(document.getElementById('kt_modal_update_status_' + orderId)).hide();
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
                                    window.LaravelDataTables['orders-table'].ajax.reload();
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