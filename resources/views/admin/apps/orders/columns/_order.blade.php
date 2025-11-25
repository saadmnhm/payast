<div class="d-flex align-items-center">
    <div class="d-flex flex-column">
        <a href="{{ route('apps.orders.show', $order) }}" class="text-gray-800 text-hover-primary fw-bold">
            {{ $order->order_number }}
        </a>
        <span class="text-muted fs-7">{{ $order->created_at->format('d/m/Y H:i') }}</span>
    </div>
</div>