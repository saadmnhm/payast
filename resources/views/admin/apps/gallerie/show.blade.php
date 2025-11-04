<x-default-layout>
    @section('title')
        Détails de l'élément - {{ $gallerie->title }}
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
                <li class="breadcrumb-item text-muted">{{ Str::limit($gallerie->title, 30) }}</li>
            </ul>
        </div>
    @endsection

    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
        <!-- Actions -->
        <div class="card card-flush py-4">
            <div class="card-header">
                <div class="card-title">
                    <h2>Actions</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex gap-3">
                    <a href="{{ route('apps.gallerie.edit', $gallerie->id) }}" class="btn btn-primary">
                        <i class="ki-duotone ki-pencil fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Modifier
                    </a>
                    <a href="{{ $gallerie->file_url }}" class="btn btn-light-primary" target="_blank" download="{{ $gallerie->file_name }}">
                        <i class="ki-duotone ki-cloud-download fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Télécharger
                    </a>
                    <form action="{{ route('apps.gallerie.destroy', $gallerie->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">
                            <i class="ki-duotone ki-trash fs-2">
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

        <div class="row g-7">
            <!-- Media Display -->
            <div class="col-lg-8">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Médias ({{ $gallerie->media->count() }})</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if($gallerie->media->count() > 0)
                            <div class="row g-4">
                                @foreach($gallerie->orderedMedia as $media)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card">
                                            <div class="card-body p-4">
                                                @if($media->file_type === 'image')
                                                    <img src="{{ $media->file_url }}" class="img-fluid rounded mb-3" alt="{{ $media->original_name }}" style="height: 200px; width: 100%; object-fit: cover;" />
                                                @else
                                                    <video class="rounded mb-3" style="height: 200px; width: 100%; object-fit: cover;" controls preload="metadata">
                                                        <source src="{{ $media->file_url }}" type="{{ $media->mime_type }}">
                                                        Votre navigateur ne supporte pas cette vidéo.
                                                    </video>
                                                @endif

                                                <div class="text-start">
                                                    <h5 class="card-title text-truncate" title="{{ $media->original_name }}">{{ $media->original_name }}</h5>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="badge badge-light-{{ $media->file_type === 'image' ? 'primary' : 'success' }}">
                                                            {{ $media->file_type === 'image' ? 'Image' : 'Vidéo' }}
                                                        </span>
                                                        <small class="text-muted">{{ $media->file_size_formatted }}</small>
                                                    </div>

                                                    @if($media->is_compressed)
                                                        <div class="alert alert-success py-2 mb-2">
                                                            <i class="fas fa-compress-alt"></i>
                                                            <strong>Compressée:</strong> {{ $media->compression_ratio }}% de réduction<br>
                                                            <small>Taille originale: {{ $media->original_size_formatted }}</small>
                                                        </div>
                                                    @endif

                                                    <div class="text-center">
                                                        <a href="{{ $media->file_url }}" target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="ki-duotone ki-eye fs-5"></i>
                                                            Voir en grand
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <i class="ki-duotone ki-picture fs-3x text-muted mb-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <p class="text-muted">Aucun média disponible</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Information Panel -->
            <div class="col-lg-4">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Informations</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-7">
                            <label class="fw-semibold fs-6 mb-2">Titre</label>
                            <div class="fs-6 text-gray-800">{{ $gallerie->title }}</div>
                        </div>

                        @if($gallerie->description)
                            <div class="mb-7">
                                <label class="fw-semibold fs-6 mb-2">Description</label>
                                <div class="fs-6 text-gray-800">{{ $gallerie->description }}</div>
                            </div>
                        @endif

                        <div class="mb-7">
                            <label class="fw-semibold fs-6 mb-2">Statistiques</label>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-gray-600">Total médias:</span>
                                <span class="fw-bold">{{ $gallerie->media->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-gray-600">Images:</span>
                                <span class="fw-bold text-primary">{{ $gallerie->images->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-gray-600">Vidéos:</span>
                                <span class="fw-bold text-success">{{ $gallerie->videos->count() }}</span>
                            </div>
                            @php
                                $compressedCount = $gallerie->media->where('is_compressed', true)->count();
                                $totalSize = $gallerie->media->sum('file_size');
                                $formattedSize = $totalSize > 0 ? (number_format($totalSize / 1024 / 1024, 2) . ' MB') : '0 MB';
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-gray-600">Compressées:</span>
                                <span class="fw-bold text-warning">{{ $compressedCount }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-gray-600">Taille totale:</span>
                                <span class="fw-bold">{{ $formattedSize }}</span>
                            </div>
                        </div>

                        <div class="mb-7">
                            <label class="fw-semibold fs-6 mb-2">Type MIME</label>
                            <div class="fs-6 text-gray-800">{{ $gallerie->mime_type }}</div>
                        </div>

                        <div class="mb-7">
                            <label class="fw-semibold fs-6 mb-2">Statut</label>
                            <div class="d-flex gap-2">
                                <span class="badge badge-light-{{ $gallerie->is_active ? 'success' : 'danger' }}">
                                    {{ $gallerie->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                                @if($gallerie->is_featured)
                                    <span class="badge badge-light-warning">Mis en avant</span>
                                @endif
                            </div>
                        </div>


                        <div class="mb-7">
                            <label class="fw-semibold fs-6 mb-2">Créé le</label>
                            <div class="fs-6 text-gray-800">{{ $gallerie->created_at->format('d/m/Y à H:i') }}</div>
                        </div>

                        @if($gallerie->updated_at != $gallerie->created_at)
                            <div class="mb-7">
                                <label class="fw-semibold fs-6 mb-2">Modifié le</label>
                                <div class="fs-6 text-gray-800">{{ $gallerie->updated_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices

            try {
                document.execCommand('copy');

                // Show success message
                Swal.fire({
                    text: "URL copiée dans le presse-papiers!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    },
                    timer: 2000
                });
            } catch (err) {
                console.error('Erreur lors de la copie: ', err);
                Swal.fire({
                    text: "Erreur lors de la copie.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        }
    </script>
    @endpush
</x-default-layout>
