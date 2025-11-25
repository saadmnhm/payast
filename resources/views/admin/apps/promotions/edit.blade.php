<x-default-layout>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            {{ Breadcrumbs::render('apps.promotions.edit', $promotion) }}
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form action="{{ route('apps.promotions.update', $promotion) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <div class="card mb-6">
                    <div class="card-header">
                        <h3 class="card-title">Modifier la Promotion</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-6">
                            <div class="col-md-6">
                                <label class="required form-label">Titre</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $promotion->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="required form-label">Prix Promo</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="price_promo" 
                                           class="form-control @error('price_promo') is-invalid @enderror" 
                                           value="{{ old('price_promo', $promotion->price_promo) }}" required>
                                    <span class="input-group-text">MAD</span>
                                </div>
                                @error('price_promo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-6">
                            <div class="col-md-6">
                                <label class="form-label">Ordre</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                                       value="{{ old('order', $promotion->order) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Icône</label>
                                <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" 
                                       value="{{ old('icon', $promotion->icon) }}" placeholder="Ex: fa-tag">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="4">{{ old('description', $promotion->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Sélectionner une Pièce</label>
                            <select name="piece_id" class="form-select @error('piece_id') is-invalid @enderror">
                                <option value="">Aucune pièce sélectionnée</option>
                                @foreach($pieces as $piece)
                                    <option value="{{ $piece->id }}" 
                                        {{ old('piece_id', $promotion->piece_id) == $piece->id ? 'selected' : '' }}>
                                        {{ $piece->name }} - {{ $piece->reference }}
                                    </option>
                                @endforeach
                            </select>
                            @error('piece_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Image</label>
                            <div class="image-input image-input-outline" data-kt-image-input="true" 
                                 style="background-image: url('{{ $promotion->image_url ?? asset('assets/media/svg/files/blank-image.svg') }}')">
                                <div class="image-input-wrapper w-125px h-125px" 
                                     style="background-image: url('{{ $promotion->image_url ?? asset('assets/media/svg/files/blank-image.svg') }}')"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                       data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Changer l'image">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                      data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Annuler">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" 
                                      data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Supprimer">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                            @error('image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch mb-6">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                   {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Actif
                            </label>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('apps.promotions.index') }}" class="btn btn-light me-3">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            {!! getIcon('check', 'fs-3') !!}
                            Mettre à Jour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</x-default-layout>