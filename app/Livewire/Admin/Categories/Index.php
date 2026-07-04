<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $categories;
    public $name;
    public $sort_order = 0;
    public $is_active = true;
    public $image;
    public $editingId = null;
    public bool $showForm = false;

    public function mount()
    {
        $this->refreshList();
    }

    public function refreshList()
    {
        $this->categories = Category::orderBy('sort_order')->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->editingId = $id;
        $this->name = $category->name;
        $this->sort_order = $category->sort_order;
        $this->is_active = $category->is_active;
        $this->showForm = true;
    }

    public function save()
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:100'],
            'sort_order' => ['integer'],
            'is_active' => ['boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->image) {
            $data['image'] = $this->image->store('categories', 'public');
        } else {
            unset($data['image']);
        }

        if ($this->editingId) {
            Category::findOrFail($this->editingId)->update($data);
        } else {
            Category::create($data);
        }

        $this->resetForm();
        $this->refreshList();
        session()->flash('message', 'Category saved.');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        $this->refreshList();
        session()->flash('message', 'Category deleted.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'sort_order', 'is_active', 'image', 'editingId']);
        $this->sort_order = 0;
        $this->is_active = true;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.categories.index')->layout('layouts.admin');
    }
}
