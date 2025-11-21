<div class="d-flex align-items-center">
    <div class="symbol symbol-50px me-3">
        <img src="{{ $category->image_url }}" alt="{{ $category->title }}" />
    </div>
    <div class="d-flex flex-column">
        <a href="{{ route('apps.cataloge.categories.show', $category) }}" class="text-gray-800 text-hover-primary mb-1 fs-6 fw-bold">
            {{ $category->title }}
        </a>
        @if($category->parent)
            <span class="text-muted fw-semibold d-block fs-7">
                Parent: {{ $category->parent->title }}
            </span>
        @endif
    </div>
</div>
