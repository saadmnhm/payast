<x-default-layout>
    @section('title')
        Gestion de la Galerie
    @endsection

    @section('breadcrumbs')
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="" class="text-muted text-hover-primary">Tableau de bord</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Galerie</li>
            </ul>
        </div>
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-gallery-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..."/>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-gallery-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Filtrer
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Options de filtre</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5" data-kt-gallery-table-filter="form">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Type:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Sélectionner option" data-allow-clear="true" data-kt-gallery-table-filter="type" data-hide-search="true">
                                    <option></option>
                                    <option value="image">Images</option>
                                    <option value="video">Vidéos</option>
                                </select>
                            </div>
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Statut:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Sélectionner option" data-allow-clear="true" data-kt-gallery-table-filter="status" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Actif</option>
                                    <option value="0">Inactif</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-gallery-table-filter="reset">Réinitialiser</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-gallery-table-filter="filter">Appliquer</button>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('apps.gallerie.create') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Ajouter un élément
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body py-4">
            @if($galleries->count() > 0)
                <div class="row g-6 g-xl-9">
                    @foreach($galleries as $gallery)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card card-flush h-xl-100">
                                <div class="card-header pt-5">
                                    <div class="card-title d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $hasImages = $gallery->images->count() > 0;
                                                $hasVideos = $gallery->videos->count() > 0;
                                            @endphp

                                            @if($hasImages && $hasVideos)
                                                <i class="ki-duotone ki-folder-down fs-2 text-info me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @elseif($hasImages)
                                                <i class="ki-duotone ki-picture fs-2 text-primary me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @elseif($hasVideos)
                                                <i class="ki-duotone ki-video fs-2 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @else
                                                <i class="ki-duotone ki-folder fs-2 text-muted me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            @endif
                                            <span class="fs-4 fw-bold text-gray-900 text-hover-primary mb-0">{{ Str::limit($gallery->title, 20) }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-2">
                                            @if($gallery->is_featured)
                                                <span class="badge badge-light-warning me-2">Mis en avant</span>
                                            @endif
                                            <span class="badge badge-light-{{ $gallery->is_active ? 'success' : 'danger' }}">{{ $gallery->is_active ? 'Actif' : 'Inactif' }}</span>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-bs-toggle="dropdown">
                                                <i class="ki-duotone ki-dots-vertical fs-5">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('apps.gallerie.show', $gallery->id) }}" class="dropdown-item">
                                                    <i class="ki-duotone ki-eye fs-5 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                    Voir
                                                </a>
                                                <a href="{{ route('apps.gallerie.edit', $gallery->id) }}" class="dropdown-item">
                                                    <i class="ki-duotone ki-pencil fs-5 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Modifier
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('apps.gallerie.destroy', $gallery->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">
                                                        <i class="ki-duotone ki-trash fs-5 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                    <a href="{{ route('apps.gallerie.show', $gallery->id) }}" class="text-gray-800 text-hover-primary">
                                        <div class="overlay">
                                            @if($gallery->media->count() > 0)
                                                @php $firstMedia = $gallery->orderedMedia->first(); @endphp
                                                @if($firstMedia->file_type === 'image')
                                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                         style="background-image: url('{{ $firstMedia->file_url }}'); background-size: contain;"></div>
                                                @else
                                                    <div class="overlay-wrapper d-flex justify-content-center align-items-center card-rounded min-h-175px bg-light-primary">
                                                        <i class="ki-duotone ki-video fs-3x text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                @endif

                                                <!-- Media count badge -->
                                                @if($gallery->media->count() > 1)
                                                    <div class="position-absolute top-0 end-0 mt-4 me-4">
                                                        <span class="badge badge-light-primary fs-7">
                                                            <i class="fas fa-images"></i> {{ $gallery->media->count() }}
                                                        </span>
                                                    </div>
                                                @endif

                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                    <i class="ki-duotone ki-eye fs-3x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </div>
                                            @else
                                                <div class="overlay-wrapper d-flex justify-content-center align-items-center card-rounded min-h-175px bg-light-secondary">
                                                    <i class="ki-duotone ki-picture fs-3x text-muted">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                    <i class="ki-duotone ki-eye fs-3x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="fs-6 fw-bolder text-gray-600 text-hover-primary mt-4">{{ $gallery->title }}</div>
                                    @if($gallery->description)
                                        <div class="fs-7 fw-semibold text-gray-400 mt-1">{{ Str::limit($gallery->description, 60) }}</div>
                                    @endif
                                    <div class="fs-7 text-muted mt-2">
                                        @php
                                            $totalSize = $gallery->media->sum('file_size');
                                            $formattedSize = $totalSize > 0 ? (number_format($totalSize / 1024 / 1024, 2) . ' MB') : '0 MB';
                                        @endphp
                                        <span>{{ $formattedSize }}</span>
                                        <span class="bullet bullet-dot bg-gray-300 mx-2"></span>
                                        <span>{{ $gallery->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex flex-stack flex-wrap pt-10">
                    <div class="fs-6 fw-semibold text-gray-700">
                        Affichage {{ $galleries->firstItem() ?? 0 }} à {{ $galleries->lastItem() ?? 0 }}
                        sur {{ $galleries->total() }} résultats
                    </div>
                    <ul class="pagination">
                        {{ $galleries->links() }}
                    </ul>
                </div>
            @else
                <div class="card card-px-0">
                    <div class="card-body d-flex flex-column flex-center text-center p-10">
                        <div class="symbol symbol-100px mb-7">
                            <i class="ki-duotone ki-picture fs-1 text-gray-300">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <div class="fs-1 fw-bolder text-gray-400 mb-7">Aucun élément trouvé</div>
                        <div class="fs-6 text-gray-600 mb-10">Commencez par ajouter votre première photo ou vidéo à la galerie</div>
                        <a href="{{ route('apps.gallerie.create') }}" class="btn btn-primary">
                            <i class="ki-duotone ki-plus fs-2"></i>
                            Ajouter un élément
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        "use strict";

        var KTGallerysList = function () {
            var table;
            var datatable;

            var initToggleToolbar = function () {
                var container = document.querySelector('#kt_gallery_table');
                var checkboxes = container.querySelectorAll('[type="checkbox"]');

                checkboxes.forEach(c => {
                    c.addEventListener('click', function () {
                        setTimeout(function () {
                            toggleToolbars();
                        }, 50);
                    });
                });
            }

            var toggleToolbars = function () {
                var container = document.querySelector('#kt_gallery_table');
                var toolbarBase = document.querySelector('[data-kt-gallery-table-toolbar="base"]');
                var toolbarSelected = document.querySelector('[data-kt-gallery-table-toolbar="selected"]');
                var selectedCount = document.querySelector('[data-kt-gallery-table-select="selected_count"]');

                var allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');
                var checkedState = false;
                var counter = 0;

                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        counter++;
                    }
                });

                if (checkedState) {
                    selectedCount.innerHTML = counter;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            return {
                init: function () {
                    initToggleToolbar();
                }
            };
        }();

        KTUtil.onDOMContentLoaded(function () {
            KTGallerysList.init();
        });
    </script>
    @endpush
</x-default-layout>
