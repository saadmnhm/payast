<x-default-layout>
    @section('title', 'Modifier la marque')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.brand.edit', $brand) }}
    @endsection

    {{-- Update form wraps all editable inputs --}}
    <form action="{{ route('apps.brand.update', $brand) }}" method="POST" enctype="multipart/form-data" id="kt_brand_form">
        @csrf
        @method('PUT')

        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                <div class="card card-flush">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Logo de la marque</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <div class="image-input image-input-outline mb-3" data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px" style="background-image: url('{{ $brand->image ? asset('storage/'.$brand->image) : image('logos/default.png') }}')"></div>

                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Changer le logo">
                                {!! getIcon('pencil', 'fs-7') !!}
                                <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                            </label>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Annuler le changement">
                                {!! getIcon('cross', 'fs-2') !!}
                            </span>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Supprimer le logo">
                                {!! getIcon('cross', 'fs-2') !!}
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
                            <label class="required form-label">Nom de la marque</label>
                            <input type="text" name="label" class="form-control mb-2 @error('label') is-invalid @enderror" placeholder="Nom de la marque" value="{{ old('label', $brand->label) }}" />
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $brand->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">
                                    Marque active
                                </label>
                            </div>
                            @error('is_active')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('apps.brand.index') }}" class="btn btn-light me-3">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Enregistrer les modifications</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('apps.brand.destroy', $brand) }}" method="POST" >
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette marque ?')">
            Supprimer la marque
        </button>
    </form>

</x-default-layout>