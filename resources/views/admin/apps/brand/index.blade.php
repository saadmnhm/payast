<x-default-layout>

@section('title', 'Marques')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Marques</h1>
        <a href="{{ route('apps.brand.create') }}" class="btn btn-primary">Ajouter une marque</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($brands->isEmpty())
        <div class="alert alert-info">Aucune marque trouvée.</div>
    @else
        <div class="row g-3">
            @foreach($brands as $brand)
                <div class="col-md-3">
                    <div class="card h-100 pt-4 align-items-center">
                        @if($brand->image)
                            <img src="{{ asset('uploads/'.$brand->image) }}" class="card-img-top" alt="{{ $brand->label}}" style="height:160px;width: 200px;object-fit:contain;">
                        @endif
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $brand->label }}</h5>
                            <a href="{{ route('apps.brand.edit', $brand) }}" class="btn btn-sm btn-warning me-2">Éditer</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-default-layout>