<x-default-layout>
    @section('title')
        Ajouter un élément à la galerie
    @endsection

    @section('breadcrumbs')
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('apps.gallerie.index') }}" class="text-muted text-hover-primary">Galerie</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Ajouter</li>
            </ul>
        </div>
    @endsection

    <form id="kt_gallery_form" class="form" action="{{ route('apps.gallerie.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                        <input type="text" name="title" class="form-control mb-2" placeholder="Titre de l'élément" value="{{ old('title') }}" />
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-10">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control mb-2" rows="3" placeholder="Description de l'élément">{{ old('description') }}</textarea>
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
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Fichiers (Images et/ou Vidéos)</label>
                        <input type="file" name="files[]" class="form-control mb-2" accept="image/*,video/*" id="gallery_files" multiple />
                        <div class="text-muted fs-7">
                            <i class="fas fa-info-circle"></i> Formats acceptés: JPG, PNG, GIF, SVG, MP4, AVI, MOV, WMV, FLV, WEBM (max. 50 MB par fichier)
                            <br><i class="fas fa-upload"></i> Sélectionnez plusieurs fichiers à la fois pour les télécharger dans cette galerie
                            <br><i class="fas fa-compress-alt"></i> Les images de plus de 1 MB seront automatiquement compressées
                        </div>
                        @error('files')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('files.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="files_preview" class="d-none">
                        <label class="form-label">Aperçu des fichiers sélectionnés</label>
                        <div id="preview_container" class="row">
                            <!-- Previews will be added here dynamically -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('apps.gallerie.index') }}" id="kt_gallery_cancel" class="btn btn-light me-5">Annuler</a>
            <button type="submit" id="kt_gallery_submit" class="btn btn-primary">
                <span class="indicator-label">Enregistrer</span>
                <span class="indicator-progress">Veuillez patienter...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        "use strict";

        var KTGalleryCreate = function () {
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
                            },
                            'files[]': {
                                validators: {
                                    notEmpty: {
                                        message: 'Au moins un fichier est requis'
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
                            }
                        });
                    }
                });
            }

            var handleFilesPreview = function () {
                const fileInput = document.getElementById('gallery_files');
                const previewContainer = document.getElementById('files_preview');
                const previewContent = document.getElementById('preview_container');

                fileInput.addEventListener('change', function(e) {
                    const files = Array.from(e.target.files);

                    if (files.length > 0) {
                        previewContainer.classList.remove('d-none');
                        previewContent.innerHTML = '';

                        files.forEach((file, index) => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                let mediaElement = '';

                                if (file.type.startsWith('image/')) {
                                    mediaElement = `
                                        <img src="${e.target.result}" class="img-fluid rounded" style="height: 120px; object-fit: cover;" />
                                    `;
                                } else if (file.type.startsWith('video/')) {
                                    mediaElement = `
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 120px;">
                                            <i class="fas fa-video fa-2x text-primary"></i>
                                        </div>
                                    `;
                                }

                                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                                const isLarge = file.size > 1048576; // 1MB

                                const previewCard = document.createElement('div');
                                previewCard.className = 'col-md-3 col-sm-4 col-6 mb-3';
                                previewCard.innerHTML = `
                                    <div class="card h-100">
                                        <div class="card-body p-2 text-center">
                                            ${mediaElement}
                                            <div class="mt-2">
                                                <div class="fw-bold text-truncate small" title="${file.name}" style="font-size: 0.8rem;">${file.name}</div>
                                                <small class="text-muted">${sizeInMB} MB</small>
                                                ${isLarge && file.type.startsWith('image/') ? '<br><small class="text-warning"><i class="fas fa-compress-alt"></i> Sera compressée</small>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                `;

                                previewContent.appendChild(previewCard);
                            };

                            reader.readAsDataURL(file);
                        });

                        // Add summary info
                        const summaryCard = document.createElement('div');
                        summaryCard.className = 'col-12 mb-3';
                        summaryCard.innerHTML = `
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>${files.length}</strong> fichier(s) sélectionné(s)
                                | Total: <strong>${((files.reduce((sum, f) => sum + f.size, 0)) / (1024 * 1024)).toFixed(2)} MB</strong>
                            </div>
                        `;
                        previewContent.insertBefore(summaryCard, previewContent.firstChild);
                    } else {
                        previewContainer.classList.add('d-none');
                    }
                });
            }

            return {
                init: function () {
                    form = document.querySelector('#kt_gallery_form');
                    submitButton = document.querySelector('#kt_gallery_submit');

                    initValidation();
                    handleSubmit();
                    handleFilesPreview();
                }
            };
        }();

        KTUtil.onDOMContentLoaded(function () {
            KTGalleryCreate.init();
        });
    </script>
    @endpush
</x-default-layout>
