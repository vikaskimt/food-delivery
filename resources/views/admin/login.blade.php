<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow rounded p-8 w-full max-w-sm">
        <h1 class="text-xl font-bold mb-6 text-center">Admin Login</h1>

        @if ($errors->any())
            <div class="mb-4 p-2 bg-red-100 text-red-800 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2" required>
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded">Login</button>
        </form>
    </div>
</body>
</html>
