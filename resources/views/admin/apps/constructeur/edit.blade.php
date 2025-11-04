<x-default-layout>
    @section('title', 'Modifier la marque')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.constructeur.edit', $constructeur) }}
    @endsection

    <form action="{{ route('apps.constructeur.update', $constructeur) }}" method="POST" enctype="multipart/form-data" id="kt_constructeur_form">
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
                            <div class="image-input-wrapper w-150px h-150px" style="background-image: url('{{ $constructeur->image ? asset('storage/'.$constructeur->image) : image('logos/default.png') }}')"></div>

                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Changer le logo">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                            </label>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Annuler le changement">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Supprimer le logo">
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
                            <label class="required form-label">Nom de la marque</label>
                            <input type="text" name="label" class="form-control mb-2 @error('label') is-invalid @enderror" placeholder="Nom de la marque" value="{{ old('label', $constructeur->label) }}" />
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $constructeur->is_active) ? 'checked' : '' }} />
                                <label class="form-check-label" for="is_active">
                                    Marque active
                                </label>
                            </div>
                        </div>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('apps.constructeur.index') }}" class="btn btn-light me-3">Annuler</a>
                    <form action="{{ route('apps.constructeur.destroy', $constructeur) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce constructeur ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce constructeur ?');">
                            Supprimer le constructeur
                        </button>
                    </form>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Enregistrer les modifications</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-default-layout>