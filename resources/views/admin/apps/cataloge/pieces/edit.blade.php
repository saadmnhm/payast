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
                                    <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                        <option value="">-- Sélectionner une marque --</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" 
                                                {{ old('brand_id', $piece->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
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

    <!-- Add to Promotion Card -->
    @if($piece->promotions->where('is_active', true)->isEmpty())
    <div class="card mt-6">
        <div class="card-header">
            <h3 class="card-title">Ajouter aux Promotions</h3>
        </div>
        <form action="{{ route('apps.promotions.add-piece', $piece) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        {!! getIcon('information-5', 'fs-2x text-info me-4') !!}
                        <div class="d-flex flex-column">
                            <h5 class="mb-1">Créer une promotion pour cette pièce</h5>
                            <span>Définissez un prix promotionnel pour mettre en avant cette pièce.</span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="form-label required">Prix Promotionnel (DH)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="price_promo" 
                               class="form-control @error('price_promo') is-invalid @enderror" 
                               placeholder="Prix réduit" required>
                        <span class="input-group-text">MAD</span>
                    </div>
                    <div class="form-text">Prix actuel: <strong>{{ number_format($piece->price, 2) }} MAD</strong></div>
                    @error('price_promo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    {!! getIcon('discount', 'fs-2') !!}
                    Ajouter aux Promotions
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="card mt-6">
        <div class="card-header bg-light-success">
            <h3 class="card-title text-success">
                {!! getIcon('check-circle', 'fs-2 text-success me-2') !!}
                Cette pièce est déjà en promotion
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-row-bordered">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Prix Promo</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($piece->promotions->where('is_active', true) as $promotion)
                        <tr>
                            <td>{{ $promotion->title }}</td>
                            <td><span class="badge badge-light-success">{{ $promotion->formatted_price }}</span></td>
                            <td>
                                @if($promotion->is_active)
                                    <span class="badge badge-success">Actif</span>
                                @else
                                    <span class="badge badge-secondary">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('apps.promotions.edit', $promotion) }}" class="btn btn-sm btn-light-primary">
                                    {!! getIcon('pencil', 'fs-5') !!}
                                    Modifier
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

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
    </script>
    @endpush
</x-default-layout>
