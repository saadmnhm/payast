<x-default-layout>

@section('title', 'Modifier le Menu')

@section('content')
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Modifier le Menu: {{ $navigationMenu->title }}</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('apps.navigation-menu.update', $navigationMenu) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label required fw-semibold fs-6">Titre</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <input type="text" name="title" class="form-control form-control-solid @error('title') is-invalid @enderror" 
                               placeholder="Ex: Mécanique" value="{{ old('title', $navigationMenu->title) }}" required />
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-semibold fs-6">URL</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <input type="text" name="url" class="form-control form-control-solid @error('url') is-invalid @enderror" 
                               placeholder="Ex: /mecanique ou #" value="{{ old('url', $navigationMenu->url) }}" />
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Laisser vide si c'est un menu déroulant (dropdown) sans lien</div>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-semibold fs-6">Icône</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <input type="text" name="icon" class="form-control form-control-solid @error('icon') is-invalid @enderror" 
                               placeholder="Ex: wrench, gear, home" value="{{ old('icon', $navigationMenu->icon) }}" />
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nom de l'icône Metronic (optionnel)</div>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-semibold fs-6">Menu Parent</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <select name="parent_id" class="form-select form-select-solid @error('parent_id') is-invalid @enderror">
                            <option value="">-- Menu Principal --</option>
                            @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id }}" 
                                    {{ old('parent_id', $navigationMenu->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Sélectionnez un parent pour créer un sous-menu</div>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-semibold fs-6">Ordre</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <input type="number" name="order" class="form-control form-control-solid @error('order') is-invalid @enderror" 
                               placeholder="0" value="{{ old('order', $navigationMenu->order) }}" min="0" />
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Plus le nombre est petit, plus il apparaîtra en premier</div>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-semibold fs-6">Cible du Lien</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <select name="target" class="form-select form-select-solid @error('target') is-invalid @enderror">
                            <option value="_self" {{ old('target', $navigationMenu->target) == '_self' ? 'selected' : '' }}>
                                Même fenêtre (_self)
                            </option>
                            <option value="_blank" {{ old('target', $navigationMenu->target) == '_blank' ? 'selected' : '' }}>
                                Nouvelle fenêtre (_blank)
                            </option>
                        </select>
                        @error('target')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-semibold fs-6"></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" 
                                   {{ old('is_active', $navigationMenu->is_active) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_active">
                                Menu Actif
                            </label>
                        </div>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-3 col-form-label fw-semibold fs-6"></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-9">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="is_dropdown" value="1" id="is_dropdown" 
                                   {{ old('is_dropdown', $navigationMenu->is_dropdown) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_dropdown">
                                Menu Déroulant (Dropdown)
                            </label>
                        </div>
                        <div class="form-text">Cochez si ce menu contient des sous-menus</div>
                    </div>
                    <!--end::Col-->
                </div>

                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('apps.navigation-menu.index') }}" class="btn btn-light btn-active-light-primary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Card body-->
    </div>
</x-default-layout>
