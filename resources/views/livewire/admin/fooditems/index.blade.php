<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Food Items</h1>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded">+ Add Item</button>
    </div>

    @if (session('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('message') }}</div>
    @endif

    @if ($showForm)
        <form wire:submit.prevent="save" class="mb-6 p-4 border rounded space-y-3">
            <div>
                <label class="block text-sm font-medium">Category</label>
                <select wire:model="category_id" class="w-full border rounded p-2">
                    <option value="">Select category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" wire:model="name" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea wire:model="description" class="w-full border rounded p-2"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium">Price</label>
                <input type="number" step="0.01" wire:model="price" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Image</label>
                <input type="file" wire:model="image" class="w-full border rounded p-2">
            </div>
            <div class="flex gap-4">
                <label class="flex items-center gap-2"><input type="checkbox" wire:model="is_veg"> Veg</label>
                <label class="flex items-center gap-2"><input type="checkbox" wire:model="is_available"> Available</label>
            </div>
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
                <th>Category</th>
                <th>Price</th>
                <th>Available</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>
                        <button wire:click="toggleAvailability({{ $item->id }})"
                            class="px-2 py-1 rounded text-xs {{ $item->is_available ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                            {{ $item->is_available ? 'Available' : 'Hidden' }}
                        </button>
                    </td>
                    <td class="text-right">
                        <button wire:click="edit({{ $item->id }})" class="text-indigo-600">Edit</button>
                        <button wire:click="delete({{ $item->id }})" wire:confirm="Delete this item?" class="text-red-600 ml-3">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
