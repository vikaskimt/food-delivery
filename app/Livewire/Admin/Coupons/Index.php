<?php

namespace App\Livewire\Admin\Coupons;

use App\Models\Coupon;
use Livewire\Component;

class Index extends Component
{
    public $coupons;

    public $code;
    public $type = 'flat';
    public $value;
    public $min_order_amount = 0;
    public $max_discount;
    public $usage_limit;
    public $per_user_limit = 1;
    public $valid_from;
    public $valid_until;
    public $is_active = true;
    public $editingId = null;
    public bool $showForm = false;

    public function mount()
    {
        $this->refreshList();
    }

    public function refreshList()
    {
        $this->coupons = Coupon::latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $c = Coupon::findOrFail($id);
        $this->editingId = $id;
        $this->code = $c->code;
        $this->type = $c->type;
        $this->value = $c->value;
        $this->min_order_amount = $c->min_order_amount;
        $this->max_discount = $c->max_discount;
        $this->usage_limit = $c->usage_limit;
        $this->per_user_limit = $c->per_user_limit;
        $this->valid_from = optional($c->valid_from)->format('Y-m-d');
        $this->valid_until = optional($c->valid_until)->format('Y-m-d');
        $this->is_active = $c->is_active;
        $this->showForm = true;
    }

    public function save()
    {
        $data = $this->validate([
            'code' => ['required', 'string', 'max:30'],
            'type' => ['required', 'in:flat,percent'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['numeric', 'min:0'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['integer', 'min:1'],
            'valid_from' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
            'is_active' => ['boolean'],
        ]);

        $data['code'] = strtoupper($data['code']);

        if ($this->editingId) {
            Coupon::findOrFail($this->editingId)->update($data);
        } else {
            Coupon::create($data);
        }

        $this->resetForm();
        $this->refreshList();
        session()->flash('message', 'Coupon saved.');
    }

    public function delete($id)
    {
        Coupon::findOrFail($id)->delete();
        $this->refreshList();
    }

    public function resetForm()
    {
        $this->reset([
            'code', 'value', 'max_discount', 'usage_limit', 'valid_from', 'valid_until', 'editingId',
        ]);
        $this->type = 'flat';
        $this->min_order_amount = 0;
        $this->per_user_limit = 1;
        $this->is_active = true;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.coupons.index')->layout('layouts.admin');
    }
}
