<?php

namespace App\Livewire\Admin;

use App\Models\FoodItem;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'menuItems' => FoodItem::count(),
            'customers' => User::count(),
        ])->layout('layouts.admin');
    }
}
