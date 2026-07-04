<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin — Food Delivery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="flex min-h-screen">
        <aside class="w-60 bg-gray-900 text-white p-4 space-y-2">
            <div class="text-lg font-bold mb-6">🍔 Admin Panel</div>
            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-2 rounded hover:bg-gray-800">Dashboard</a>

            @if (auth('admin')->user()?->hasAnyRole(['Super Admin', 'Menu Manager']))
                <a href="{{ route('admin.categories') }}" class="block py-2 px-2 rounded hover:bg-gray-800">Categories</a>
                <a href="{{ route('admin.food-items') }}" class="block py-2 px-2 rounded hover:bg-gray-800">Food Items</a>
            @endif

            @if (auth('admin')->user()?->hasAnyRole(['Super Admin']))
                <a href="{{ route('admin.coupons') }}" class="block py-2 px-2 rounded hover:bg-gray-800">Coupons</a>
                <a href="{{ route('admin.admins') }}" class="block py-2 px-2 rounded hover:bg-gray-800">Admin Users</a>
            @endif

            @if (auth('admin')->user()?->hasAnyRole(['Super Admin', 'Order Manager']))
                <a href="{{ route('admin.orders') }}" class="block py-2 px-2 rounded hover:bg-gray-800">Orders</a>
            @endif

            <form method="POST" action="{{ route('admin.logout') }}" class="pt-4">
                @csrf
                <button class="text-red-400 hover:text-red-300">Logout</button>
            </form>
        </aside>

        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
