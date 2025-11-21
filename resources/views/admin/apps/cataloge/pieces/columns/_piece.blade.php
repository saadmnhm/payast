<div class="d-flex align-items-center">
    <div class="symbol symbol-50px me-3">
        <img src="{{ $piece->image_url }}" alt="{{ $piece->name }}" />
    </div>
    <div class="d-flex flex-column">
        <a href="{{ route('apps.cataloge.pieces.show', $piece) }}" class="text-gray-800 text-hover-primary mb-1 fs-6 fw-bold">
            {{ $piece->name }}
        </a>
        <span class="text-muted fw-semibold d-block fs-7">
            Réf: {{ $piece->reference }}
        </span>
    </div>
</div>
