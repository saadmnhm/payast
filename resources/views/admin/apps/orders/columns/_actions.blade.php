<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="{{ route('apps.orders.show', $order) }}" class="menu-link px-3">
            <i class="ki-duotone ki-eye fs-6 me-2"></i>
            Voir détails
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_status_{{ $order->id }}">
            <i class="ki-duotone ki-pencil fs-6 me-2"></i>
            Changer statut
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 text-danger" data-kt-order-id="{{ $order->id }}" data-kt-action="delete_order">
            <i class="ki-duotone ki-trash fs-6 me-2"></i>
            Supprimer
        </a>
    </div>
    <!--end::Menu item-->
</div>
<!--end::Menu-->

<!-- Modal Update Status -->
<div class="modal fade" id="kt_modal_update_status_{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Changer le statut de la commande</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_update_status_form_{{ $order->id }}" class="form">
                    @csrf
                    <div class="mb-5">
                        <label class="required fw-semibold fs-6 mb-2">Nouveau statut</label>
                        <select class="form-select form-select-solid" name="status" data-control="select2" data-dropdown-parent="#kt_modal_update_status_{{ $order->id }}" data-placeholder="Sélectionner un statut">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En préparation</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Expédiée</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" data-kt-order-id="{{ $order->id }}">
                            <span class="indicator-label">Mettre à jour</span>
                            <span class="indicator-progress">Traitement...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>