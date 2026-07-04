<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Coupons</h1>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded">+ Add Coupon</button>
    </div>

    @if (session('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('message') }}</div>
    @endif

    @if ($showForm)
        <form wire:submit.prevent="save" class="mb-6 p-4 border rounded space-y-3 grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium">Code</label>
                <input type="text" wire:model="code" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Type</label>
                <select wire:model="type" class="w-full border rounded p-2">
                    <option value="flat">Flat amount</option>
                    <option value="percent">Percentage</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Value</label>
                <input type="number" step="0.01" wire:model="value" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Min Order Amount</label>
                <input type="number" step="0.01" wire:model="min_order_amount" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Max Discount (percent only)</label>
                <input type="number" step="0.01" wire:model="max_discount" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Total Usage Limit</label>
                <input type="number" wire:model="usage_limit" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Per User Limit</label>
                <input type="number" wire:model="per_user_limit" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Valid From</label>
                <input type="date" wire:model="valid_from" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Valid Until</label>
                <input type="date" wire:model="valid_until" class="w-full border rounded p-2">
            </div>
            <label class="flex items-center gap-2 col-span-2">
                <input type="checkbox" wire:model="is_active"> Active
            </label>
            <div class="col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
            </div>
        </form>
    @endif

    <table class="w-full border-collapse">
        <thead>
            <tr class="border-b text-left">
                <th class="py-2">Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Used</th>
                <th>Active</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $c)
                <tr class="border-b">
                    <td class="py-2 font-mono">{{ $c->code }}</td>
                    <td>{{ ucfirst($c->type) }}</td>
                    <td>{{ $c->value }}</td>
                    <td>{{ $c->used_count }}{{ $c->usage_limit ? '/'.$c->usage_limit : '' }}</td>
                    <td>{{ $c->is_active ? 'Yes' : 'No' }}</td>
                    <td class="text-right">
                        <button wire:click="edit({{ $c->id }})" class="text-indigo-600">Edit</button>
                        <button wire:click="delete({{ $c->id }})" wire:confirm="Delete this coupon?" class="text-red-600 ml-3">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
