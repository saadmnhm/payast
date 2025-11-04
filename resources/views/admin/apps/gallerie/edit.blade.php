<x-default-layout>
    @section('title')
        Modifier l'élément de galerie
    @endsection

    @section('breadcrumbs')
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Tableau de bord</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('apps.gallerie.index') }}" class="text-muted text-hover-primary">Galerie</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Modifier</li>
            </ul>
        </div>
    @endsection

    <form id="kt_gallery_form" class="form" action="{{ route('apps.gallerie.update', $gallerie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Informations générales</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Titre</label>
                        <input type="text" name="title" class="form-control mb-2" placeholder="Titre de l'élément" value="{{ old('title', $gallerie->title) }}" />
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-10">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control mb-2" rows="3" placeholder="Description de l'élément">{{ old('description', $gallerie->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Fichier média</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Current Media Display -->
                    <div class="mb-10">
                        <label class="form-label">Médias actuels</label>
                        <div class="current-media-container">
                            @if($gallerie->media->count() > 0)
                                <div class="row g-3" id="current_media_grid">
                                    @foreach($gallerie->orderedMedia as $media)
                                        <div class="col-md-3 col-sm-4 col-6" data-media-id="{{ $media->id }}">
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    @if($media->file_type === 'image')
                                                        <img src="{{ $media->file_url }}" class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;" alt="{{ $media->original_name }}" />
                                                    @else
                                                        <video class="rounded" style="height: 120px; width: 100%; object-fit: cover;" controls preload="metadata">
                                                            <source src="{{ $media->file_url }}" type="{{ $media->mime_type }}">
                                                        </video>
                                                    @endif
                                                    <div class="mt-2">
                                                        <div class="fw-bold text-truncate" title="{{ $media->original_name }}">{{ $media->original_name }}</div>
                                                        <small class="text-muted">{{ $media->file_size_formatted }}</small>
                                                        @if($media->is_compressed)
                                                            <small class="text-success d-block">
                                                                <i class="fas fa-compress-alt"></i> Compressée ({{ $media->compression_ratio }}%)
                                                            </small>
                                                        @endif
                                                        <div class="mt-1">
                                                            <button type="button" class="btn btn-sm btn-outline-danger delete-media-btn"
                                                                    data-media-id="{{ $media->id }}" data-media-name="{{ $media->original_name }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Hidden inputs for deleted media -->
                                <div id="deleted_media_inputs"></div>
                            @else
                                <p class="text-muted">Aucun média</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label">Ajouter de nouveaux fichiers (optionnel)</label>
                        <input type="file" name="files[]" class="form-control mb-2" accept="image/*,video/*" id="gallery_files" multiple />
                        <div class="text-muted fs-7">
                            <i class="fas fa-info-circle"></i> Sélectionnez plusieurs fichiers à ajouter<br>
                            Formats acceptés: JPG, PNG, GIF, SVG (max. 50 MB chacun) | MP4, AVI, MOV, WMV, FLV, WEBM (max. 50 MB chacun)<br>
                            <i class="fas fa-compress-alt text-success"></i> Les images supérieures à 1 MB seront automatiquement compressées
                        </div>
                        @error('files')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('files.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Files Preview -->
                    <div id="files_preview" class="d-none">
                        <label class="form-label">Aperçu des nouveaux fichiers</label>
                        <div id="new_files_container" class="row g-3">
                            <!-- New file previews will be added here dynamically -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('apps.gallerie.index') }}" class="btn btn-light me-5">Annuler</a>
                <button type="submit" id="kt_gallery_submit" class="btn btn-primary">
                    <span class="indicator-label">Mettre à jour</span>
                    <span class="indicator-progress">Veuillez patienter...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        "use strict";

        var KTGalleryEdit = function () {
            var submitButton;
            var form;
            var validator;

            var initValidation = function () {
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'title': {
                                validators: {
                                    notEmpty: {
                                        message: 'Le titre est requis'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',
                                eleValidClass: ''
                            })
                        }
                    }
                );
            }

            var handleSubmit = function () {
                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();

                    if (validator) {
                        validator.validate().then(function (status) {
                            if (status == 'Valid') {
                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                form.submit();
                            } else {
                                Swal.fire({
                                    text: "Veuillez corriger les erreurs dans le formulaire.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, compris!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    }
                });
            }

            var handleFilePreview = function () {
                const fileInput = document.getElementById('gallery_files');
                const previewContainer = document.getElementById('files_preview');
                const previewGrid = document.getElementById('new_files_container');

                fileInput.addEventListener('change', function(e) {
                    const files = Array.from(e.target.files);
                    previewGrid.innerHTML = '';

                    if (files.length > 0) {
                        previewContainer.classList.remove('d-none');

                        files.forEach((file, index) => {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                const previewItem = document.createElement('div');
                                previewItem.className = 'col-md-3 col-sm-4 col-6';

                                let mediaElement = '';
                                let sizeInfo = '';
                                let compressionNote = '';

                                // Show file size
                                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                                sizeInfo = `<small class="text-muted">${sizeInMB} MB</small>`;

                                // Show compression info for large images
                                if (file.type.startsWith('image/') && file.size > 1048576) {
                                    compressionNote = '<small class="text-success"><i class="fas fa-compress-alt"></i> Sera compressée</small>';
                                }

                                if (file.type.startsWith('image/')) {
                                    mediaElement = `
                                        <img src="${e.target.result}" class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;" />
                                    `;
                                } else if (file.type.startsWith('video/')) {
                                    mediaElement = `
                                        <video class="rounded" style="height: 120px; width: 100%; object-fit: cover;" controls preload="metadata">
                                            <source src="${e.target.result}" type="${file.type}">
                                        </video>
                                    `;
                                }

                                previewItem.innerHTML = `
                                    <div class="card">
                                        <div class="card-body p-2">
                                            ${mediaElement}
                                            <div class="mt-2">
                                                <div class="fw-bold text-truncate" title="${file.name}">${file.name}</div>
                                                ${sizeInfo}
                                                ${compressionNote}
                                            </div>
                                        </div>
                                    </div>
                                `;

                                previewGrid.appendChild(previewItem);
                            };

                            reader.readAsDataURL(file);
                        });
                    } else {
                        previewContainer.classList.add('d-none');
                    }
                });
            }

            var handleMediaDeletion = function () {
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-media-btn')) {
                        const btn = e.target.closest('.delete-media-btn');
                        const mediaId = btn.getAttribute('data-media-id');
                        const mediaName = btn.getAttribute('data-media-name');

                        Swal.fire({
                            title: 'Êtes-vous sûr?',
                            text: `Supprimer le fichier "${mediaName}"?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui, supprimer',
                            cancelButtonText: 'Annuler',
                            customClass: {
                                confirmButton: 'btn btn-danger',
                                cancelButton: 'btn btn-secondary'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Add hidden input for deletion
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'delete_media[]';
                                hiddenInput.value = mediaId;
                                document.getElementById('deleted_media_inputs').appendChild(hiddenInput);

                                // Remove media card
                                const mediaCard = document.querySelector(`[data-media-id="${mediaId}"]`);
                                if (mediaCard) {
                                    mediaCard.remove();
                                }
                            }
                        });
                    }
                });
            }

            return {
                init: function () {
                    form = document.querySelector('#kt_gallery_form');
                    submitButton = document.querySelector('#kt_gallery_submit');

                    initValidation();
                    handleSubmit();
                    handleFilePreview();
                    handleMediaDeletion();
                }
            };
        }();

        KTUtil.onDOMContentLoaded(function () {
            KTGalleryEdit.init();
        });
    </script>
    @endpush
</x-default-layout>
