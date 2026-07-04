<?php

namespace App\Livewire\Admin\Admins;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $admins;
    public $roles;

    public $name;
    public $email;
    public $password;
    public $role;
    public $is_active = true;
    public $editingId = null;
    public bool $showForm = false;

    public function mount()
    {
        // Ensure the three roles exist (idempotent — safe to call repeatedly)
        foreach (['Super Admin', 'Menu Manager', 'Order Manager'] as $r) {
            Role::firstOrCreate(['name' => $r, 'guard_name' => 'admin']);
        }

        $this->roles = Role::where('guard_name', 'admin')->pluck('name');
        $this->refreshList();
    }

    public function refreshList()
    {
        $this->admins = Admin::with('roles')->latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $this->editingId = $id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->is_active = $admin->is_active;
        $this->role = $admin->roles->first()?->name;
        $this->showForm = true;
    }

    public function save()
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:admins,email,'.$this->editingId],
            'role' => ['required', 'in:'.$this->roles->implode(',')],
            'is_active' => ['boolean'],
        ];

        if (! $this->editingId) {
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        $data = $this->validate($rules);
        $role = $data['role'];
        unset($data['role']);

        if ($this->editingId) {
            $admin = Admin::findOrFail($this->editingId);
            $admin->update($data);
        } else {
            $data['password'] = Hash::make($this->password);
            $admin = Admin::create($data);
        }

        $admin->syncRoles([$role]);

        $this->resetForm();
        $this->refreshList();
        session()->flash('message', 'Admin saved.');
    }

    public function delete($id)
    {
        if ($id === auth('admin')->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        Admin::findOrFail($id)->delete();
        $this->refreshList();
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'role', 'editingId']);
        $this->is_active = true;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.admins.index')->layout('layouts.admin');
    }
}
