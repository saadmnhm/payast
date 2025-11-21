<x-default-layout>
    @section('title', 'Modifier la catégorie')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.cataloge.categories.edit', $category) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier: {{ $category->title }}</h3>
            <div class="card-toolbar">
                <a href="{{ route('apps.cataloge.categories.index') }}" class="btn btn-sm btn-light">
                    {!! getIcon('arrow-left', 'fs-2') !!}
                    Retour
                </a>
            </div>
        </div>

        <form action="{{ route('apps.cataloge.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-10">
                            <label class="form-label required">Titre de la catégorie</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                value="{{ old('title', $category->title) }}" placeholder="Ex: Mécanique" required>
                            <div class="form-text">Slug actuel: <code>{{ $category->slug }}</code></div>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Catégorie parente</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- Aucune (catégorie principale) --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" 
                                        {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label">Ordre d'affichage</label>
                                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                                        value="{{ old('order', $category->order) }}" placeholder="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                placeholder="Description de la catégorie...">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($category->children->count() > 0)
                            <div class="alert alert-info">
                                <h5 class="alert-heading">Sous-catégories</h5>
                                <p class="mb-0">Cette catégorie contient {{ $category->children->count() }} sous-catégorie(s):</p>
                                <ul class="mb-0 mt-2">
                                    @foreach($category->children as $child)
                                        <li>{{ $child->title }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($category->pieces->count() > 0)
                            <div class="alert alert-success">
                                <h5 class="alert-heading">Pièces</h5>
                                <p class="mb-0">Cette catégorie contient {{ $category->pieces->count() }} pièce(s)</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="mb-10">
                            <label class="form-label">Image de la catégorie</label>
                            <div class="image-input image-input-outline" data-kt-image-input="true" 
                                style="background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}')">
                                <div class="image-input-wrapper w-125px h-125px" id="category-image-preview" 
                                    style="background-image: url('{{ $category->image_url }}')"></div>
                                
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Changer l'image">
                                    {!! getIcon('pencil', 'fs-7') !!}
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" id="category-image-input" />
                                </label>

                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Annuler">
                                    {!! getIcon('cross', 'fs-2') !!}
                                </span>

                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Supprimer">
                                    {!! getIcon('cross', 'fs-2') !!}
                                </span>
                            </div>
                            <div class="form-text">Formats acceptés: png, jpg, jpeg. Max 2MB</div>
                            @if($category->image)
                                <div class="form-text text-muted mt-2">Image actuelle: {{ basename($category->image) }}</div>
                            @endif
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                    id="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="border border-gray-300 border-dashed rounded p-5 bg-light-info">
                                <div class="fs-6 text-gray-700 mb-2">
                                    <strong>Date de création:</strong><br>
                                    {{ $category->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="fs-6 text-gray-700">
                                    <strong>Dernière modification:</strong><br>
                                    {{ $category->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between py-6">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_modal">
                    {!! getIcon('trash', 'fs-2') !!}
                    Supprimer
                </button>
                <div>
                    <a href="{{ route('apps.cataloge.categories.index') }}" class="btn btn-light me-3">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        {!! getIcon('check', 'fs-2') !!}
                        Mettre à jour
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        {!! getIcon('cross', 'fs-1') !!}
                    </div>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong>{{ $category->title }}</strong> ?</p>
                    @if($category->pieces->count() > 0)
                        <div class="alert alert-warning">
                            <strong>Attention:</strong> Cette catégorie contient {{ $category->pieces->count() }} pièce(s). 
                            Vous ne pouvez pas la supprimer avant de supprimer ou déplacer ces pièces.
                        </div>
                    @else
                        <p class="text-danger">Cette action est irréversible.</p>
                        @if($category->children->count() > 0)
                            <p class="text-info">Les sous-catégories seront déplacées au niveau parent.</p>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    @if($category->pieces->count() == 0)
                        <form action="{{ route('apps.cataloge.categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview image before upload
        document.getElementById('category-image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('category-image-preview').style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush
</x-default-layout>
