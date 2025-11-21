<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    {!! getIcon('down', 'fs-5 m-0') !!}
</a>

<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    <div class="menu-item px-3">
        <a href="{{ route('apps.cataloge.pieces.show', $piece) }}" class="menu-link px-3">
            Voir
        </a>
    </div>

    <div class="menu-item px-3">
        <a href="{{ route('apps.cataloge.pieces.edit', $piece) }}" class="menu-link px-3">
            Modifier
        </a>
    </div>

    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#delete_piece_{{ $piece->id }}">
            Supprimer
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_piece_{{ $piece->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer <strong>{{ $piece->name }}</strong> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('apps.cataloge.pieces.destroy', $piece) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
