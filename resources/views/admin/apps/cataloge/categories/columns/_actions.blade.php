<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    {!! getIcon('down', 'fs-5 m-0') !!}
</a>

<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    <div class="menu-item px-3">
        <a href="{{ route('apps.cataloge.categories.show', $category) }}" class="menu-link px-3">
            Voir
        </a>
    </div>

    <div class="menu-item px-3">
        <a href="{{ route('apps.cataloge.categories.edit', $category) }}" class="menu-link px-3">
            Modifier
        </a>
    </div>

    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#delete_category_{{ $category->id }}">
            Supprimer
        </a>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_category_{{ $category->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer <strong>{{ $category->title }}</strong> ?</p>
                @if($category->pieces_count > 0)
                    <div class="alert alert-warning">
                        Cette catégorie contient {{ $category->pieces_count }} pièce(s).
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                @if($category->pieces_count == 0)
                    <form action="{{ route('apps.cataloge.categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
