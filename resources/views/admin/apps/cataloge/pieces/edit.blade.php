<x-default-layout>
    @section('title', 'Modifier la pièce')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.cataloge.pieces.edit', $piece) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier la pièce: {{ $piece->name }}</h3>
            <div class="card-toolbar">
                <a href="{{ route('apps.cataloge.pieces.index') }}" class="btn btn-sm btn-light">
                    {!! getIcon('arrow-left', 'fs-2') !!}
                    Retour
                </a>
            </div>
        </div>

        <form action="{{ route('apps.cataloge.pieces.update', $piece) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-10">
                            <label class="form-label required">Nom de la pièce</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $piece->name) }}" placeholder="Ex: Batterie 12V" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label required">Référence</label>
                                    <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror" 
                                        value="{{ old('reference', $piece->reference) }}" placeholder="Ex: BAT-001" required>
                                    @error('reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label required">Prix (DH)</label>
                                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                                        value="{{ old('price', $piece->price) }}" placeholder="0.00" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label">Catégorie</label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">-- Sélectionner une catégorie --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $piece->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->full_path }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                        value="{{ old('stock', $piece->stock) }}" placeholder="0">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-10">
                                    <label class="form-label">Marque</label>
                                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" 
                                        value="{{ old('brand', $piece->brand) }}" placeholder="Ex: Bosch">
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" 
                                placeholder="Description détaillée de la pièce...">{{ old('description', $piece->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-10">
                            <label class="form-label">Image de la pièce</label>
                            <div class="image-input image-input-outline" data-kt-image-input="true" 
                                style="background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}')">
                                <div class="image-input-wrapper w-125px h-125px" id="piece-image-preview" 
                                    style="background-image: url('{{ $piece->image_url }}')"></div>
                                
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Changer l'image">
                                    {!! getIcon('pencil', 'fs-7') !!}
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" id="piece-image-input" />
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
                            @if($piece->image)
                                <div class="form-text text-muted mt-2">Image actuelle: {{ basename($piece->image) }}</div>
                            @endif
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Logo de la marque</label>
                            <div class="image-input image-input-outline" data-kt-image-input="true" 
                                style="background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}')">
                                <div class="image-input-wrapper w-125px h-125px" id="brand-image-preview" 
                                    style="background-image: url('{{ $piece->brand_image_url ?? asset('assets/media/svg/files/blank-image.svg') }}')"></div>
                                
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Changer le logo">
                                    {!! getIcon('pencil', 'fs-7') !!}
                                    <input type="file" name="brand_image" accept=".png, .jpg, .jpeg" id="brand-image-input" />
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
                            <div class="form-text">Formats acceptés: png, jpg, jpeg. Max 1MB</div>
                            @if($piece->brand_image)
                                <div class="form-text text-muted mt-2">Logo actuel: {{ basename($piece->brand_image) }}</div>
                            @endif
                            @error('brand_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                    id="is_active" {{ old('is_active', $piece->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Actif
                                </label>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="border border-gray-300 border-dashed rounded p-5 bg-light-info">
                                <div class="fs-6 text-gray-700 mb-2">
                                    <strong>Date de création:</strong><br>
                                    {{ $piece->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="fs-6 text-gray-700">
                                    <strong>Dernière modification:</strong><br>
                                    {{ $piece->updated_at->format('d/m/Y H:i') }}
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
                    <a href="{{ route('apps.cataloge.pieces.index') }}" class="btn btn-light me-3">Annuler</a>
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
                    <p>Êtes-vous sûr de vouloir supprimer la pièce <strong>{{ $piece->name }}</strong> ?</p>
                    <p class="text-danger">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('apps.cataloge.pieces.destroy', $piece) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview images before upload
        document.getElementById('piece-image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('piece-image-preview').style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('brand-image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('brand-image-preview').style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush
</x-default-layout>
