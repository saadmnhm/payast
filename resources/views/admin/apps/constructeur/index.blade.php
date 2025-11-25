<x-default-layout>

@section('title', 'Marques')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Marques</h1>
        <a href="{{ route('apps.constructeur.create') }}" class="btn btn-primary">Ajouter une marque</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($constructeurs->isEmpty())
        <div class="alert alert-info">Aucune marque trouvée.</div>
    @else
        <div class="row g-3">
            @foreach($constructeurs as $constructeur)
                <div class="col-md-3">
                    <div class="card h-100 pt-4 align-items-center">
                        @if($constructeur->image)
                            <img src="{{ asset('uploads/'.$constructeur->image) }}" class="card-img-top" alt="{{ $constructeur->label}}" style="height:160px;width: 200px;object-fit:contain;">
                        @endif
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $constructeur->label }}</h5>
                            <a href="{{ route('apps.constructeur.edit', $constructeur) }}" class="btn btn-sm btn-warning me-2">Éditer</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-default-layout>