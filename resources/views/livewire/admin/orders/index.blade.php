<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Orders</h1>
        <select wire:model.live="statusFilter" class="border rounded p-2">
            <option value="">All statuses</option>
            @foreach ($statuses as $s)
                <option value="{{ $s }}">{{ ucwords(str_replace('_', ' ', $s)) }}</option>
            @endforeach
        </select>
    </div>

    @if (session('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('message') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <div class="space-y-4">
        @foreach ($orders as $order)
            <div class="border rounded p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold">#{{ $order->order_number }}</div>
                        <div class="text-sm text-gray-600">{{ $order->user->phone }} &middot; {{ $order->created_at->format('d M, H:i') }}</div>
                        <div class="text-sm mt-1">
                            @foreach ($order->items as $item)
                                <div>{{ $item->quantity }} x {{ $item->name_snapshot }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold">₹{{ number_format($order->total, 2) }}</div>
                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-800">
                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>

                @if (!in_array($order->status, ['delivered', 'cancelled']))
                    <div class="mt-3 flex gap-2 flex-wrap">
                        @foreach (\App\Models\Order::TRANSITIONS[$order->status] as $next)
                            <button wire:click="updateStatus({{ $order->id }}, '{{ $next }}')"
                                class="px-3 py-1 text-sm rounded border hover:bg-gray-50">
                                Mark as {{ ucwords(str_replace('_', ' ', $next)) }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
</div>
