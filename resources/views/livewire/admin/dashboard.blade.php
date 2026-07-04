<div>
    <h1 class="text-xl font-semibold mb-4">Welcome, {{ auth('admin')->user()->name }}</h1>
    <p class="text-gray-600 mb-6">Role: {{ auth('admin')->user()->roles->first()?->name }}</p>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-2xl font-bold">{{ $pendingOrders }}</div>
            <div class="text-gray-500 text-sm">Pending Orders</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-2xl font-bold">{{ $menuItems }}</div>
            <div class="text-gray-500 text-sm">Menu Items</div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-2xl font-bold">{{ $customers }}</div>
            <div class="text-gray-500 text-sm">Customers</div>
        </div>
    </div>
</div>
