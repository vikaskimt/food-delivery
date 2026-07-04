<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Categories</h1>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded">+ Add Category</button>
    </div>

    @if (session('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('message') }}</div>
    @endif

    @if ($showForm)
        <form wire:submit.prevent="save" class="mb-6 p-4 border rounded space-y-3">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" wire:model="name" class="w-full border rounded p-2">
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Sort Order</label>
                <input type="number" wire:model="sort_order" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Image</label>
                <input type="file" wire:model="image" class="w-full border rounded p-2">
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
                <th>Sort</th>
                <th>Active</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr class="border-b">
                    <td class="py-2">{{ $category->name }}</td>
                    <td>{{ $category->sort_order }}</td>
                    <td>{{ $category->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-right">
                        <button wire:click="edit({{ $category->id }})" class="text-indigo-600">Edit</button>
                        <button wire:click="delete({{ $category->id }})" wire:confirm="Delete this category?" class="text-red-600 ml-3">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
