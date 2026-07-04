<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $remark = '';

    public function updateStatus($orderId, $newStatus)
    {
        $order = Order::findOrFail($orderId);

        if (! $order->canTransitionTo($newStatus)) {
            session()->flash('error', "Cannot move order from {$order->status} to {$newStatus}.");
            return;
        }

        $order->update([
            'status' => $newStatus,
            'status_updated_by' => auth('admin')->id(),
            'delivered_at' => $newStatus === 'delivered' ? now() : $order->delivered_at,
        ]);

        $order->statusHistory()->create([
            'status' => $newStatus,
            'changed_by' => auth('admin')->id(),
            'remark' => $this->remark ?: null,
        ]);

        $this->remark = '';
        session()->flash('message', "Order #{$order->order_number} updated to {$newStatus}.");
    }

    public function render()
    {
        $query = Order::with(['user', 'items'])->latest();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.orders.index', [
            'orders' => $query->paginate(15),
            'statuses' => Order::STATUSES,
        ])->layout('layouts.admin');
    }
}
