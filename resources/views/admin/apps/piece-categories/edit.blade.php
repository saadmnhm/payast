<x-default-layout>
    @section('title')
        Modifier la catégorie: {{ $pieceCategory->name }}
    @endsection

    <form action="{{ route('apps.piece-categories.update', $pieceCategory) }}" method="POST" enctype="multipart/form-data" id="kt_piece_category_form">
        @csrf
        @method('PUT')

        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                <div class="card card-flush">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Image de la catégorie</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <div class="image-input image-input-outline image-input-placeholder mb-3" data-kt-image-input="true"
                             style="background-image: url({{ $pieceCategory->image ? asset('storage/'.$pieceCategory->image) : asset('assets/media/svg/files/blank-image.svg') }})">
                            <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{ $pieceCategory->image ? asset('storage/'.$pieceCategory->image) : '' }})"></div>

                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Changer l'image">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                            </label>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Annuler l'image">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Supprimer l'image">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>

                        <div class="text-muted fs-7">Format accepté: png, jpg, jpeg. Taille max: 2MB</div>
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex-lg-row-fluid ms-lg-10">
                <div class="card card-flush mb-6 mb-xl-9">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Informations générales</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Nom de la catégorie</label>
                            <input type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="Ex: Mécanique, Freinage, etc." value="{{ old('name', $pieceCategory->name) }}" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control mb-2 @error('slug') is-invalid @enderror" placeholder="Généré automatiquement si vide" value="{{ old('slug', $pieceCategory->slug) }}" />
                            <div class="form-text">Laissez vide pour générer automatiquement à partir du nom</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row">
                            <label class="form-label">Catégorie parente</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- Aucune (Catégorie principale) --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $pieceCategory->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Sélectionnez une catégorie parente pour créer une sous-catégorie</div>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Description de la catégorie">{{ old('description', $pieceCategory->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row">
                            <label class="form-label">Ordre d'affichage</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" placeholder="0" value="{{ old('order', $pieceCategory->order) }}" min="0" />
                            <div class="form-text">Ordre d'affichage de la catégorie (0 = premier)</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $pieceCategory->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">
                                    Catégorie active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('apps.piece-categories.index') }}" class="btn btn-light me-3">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Mettre à jour</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-default-layout>
