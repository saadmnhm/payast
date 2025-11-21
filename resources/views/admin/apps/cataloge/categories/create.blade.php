<x-default-layout>
    @section('title', 'Créer une catégorie')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('apps.cataloge.categories.create') }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Créer une nouvelle catégorie</h3>
            <div class="card-toolbar">
                <a href="{{ route('apps.cataloge.categories.index') }}" class="btn btn-sm btn-light">
                    {!! getIcon('arrow-left', 'fs-2') !!}
                    Retour
                </a>
            </div>
        </div>

        <form action="{{ route('apps.cataloge.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-10">
                            <label class="form-label required">Titre de la catégorie</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                value="{{ old('title') }}" placeholder="Ex: Mécanique" required>
                            <div class="form-text">Le slug sera généré automatiquement</div>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Catégorie parente</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- Aucune (catégorie principale) --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Laissez vide pour créer une catégorie principale (ex: Mécanique, Freinage)</div>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label">Ordre d'affichage</label>
                                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                                        value="{{ old('order', 0) }}" placeholder="0">
                                    <div class="form-text">Plus le nombre est petit, plus la catégorie apparaît en premier</div>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                          
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                placeholder="Description de la catégorie...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-10">
                            <label class="form-label">Image de la catégorie</label>
                            <div class="image-input image-input-outline" data-kt-image-input="true" 
                                style="background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}')">
                                <div class="image-input-wrapper w-125px h-125px" id="category-image-preview" 
                                    style="background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}')"></div>
                                
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
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                    id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Créer une entrée dans le menu</label>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="create_nav" value="1" 
                                    id="create_nav" {{ old('create_nav', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_nav">
                                    Ajouter au menu de navigation
                                </label>
                            </div>
                            <div class="form-text mt-2">Crée automatiquement un lien dans le menu de navigation du site</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6">
                <a href="{{ route('apps.cataloge.index') }}" class="btn btn-light me-3">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    {!! getIcon('check', 'fs-2') !!}
                    Créer la catégorie
                </button>
            </div>
        </form>
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
