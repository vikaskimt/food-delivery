<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Admin Users</h1>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded">+ Add Admin</button>
    </div>

    @if (session('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('message') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    @if ($showForm)
        <form wire:submit.prevent="save" class="mb-6 p-4 border rounded space-y-3">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" wire:model="name" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" wire:model="email" class="w-full border rounded p-2">
            </div>
            @if (!$editingId)
                <div>
                    <label class="block text-sm font-medium">Password</label>
                    <input type="password" wire:model="password" class="w-full border rounded p-2">
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium">Role</label>
                <select wire:model="role" class="w-full border rounded p-2">
                    <option value="">Select role</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r }}">{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model="is_active"> Active
            </label>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
            </div>
        </form>
    @endif

    <table class="w-full border-collapse">
        <thead>
            <tr class="border-b text-left">
                <th class="py-2">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $a)
                <tr class="border-b">
                    <td class="py-2">{{ $a->name }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->roles->first()?->name }}</td>
                    <td>{{ $a->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-right">
                        <button wire:click="edit({{ $a->id }})" class="text-indigo-600">Edit</button>
                        <button wire:click="delete({{ $a->id }})" wire:confirm="Delete this admin?" class="text-red-600 ml-3">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
