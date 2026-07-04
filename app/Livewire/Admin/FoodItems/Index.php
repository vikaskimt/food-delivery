<?php

namespace App\Livewire\Admin\FoodItems;

use App\Models\Category;
use App\Models\FoodItem;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $items;
    public $categories;

    public $category_id;
    public $name;
    public $description;
    public $price;
    public $is_veg = true;
    public $is_available = true;
    public $sort_order = 0;
    public $image;
    public $editingId = null;
    public bool $showForm = false;

    public function mount()
    {
        $this->categories = Category::orderBy('sort_order')->get();
        $this->refreshList();
    }

    public function refreshList()
    {
        $this->items = FoodItem::with('category')->orderBy('sort_order')->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $item = FoodItem::findOrFail($id);
        $this->editingId = $id;
        $this->category_id = $item->category_id;
        $this->name = $item->name;
        $this->description = $item->description;
        $this->price = $item->price;
        $this->is_veg = $item->is_veg;
        $this->is_available = $item->is_available;
        $this->sort_order = $item->sort_order;
        $this->showForm = true;
    }

    public function save()
    {
        $data = $this->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_veg' => ['boolean'],
            'is_available' => ['boolean'],
            'sort_order' => ['integer'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->image) {
            $data['image'] = $this->image->store('food-items', 'public');
        } else {
            unset($data['image']);
        }

        if ($this->editingId) {
            FoodItem::findOrFail($this->editingId)->update($data);
        } else {
            FoodItem::create($data);
        }

        $this->resetForm();
        $this->refreshList();
        session()->flash('message', 'Food item saved.');
    }

    public function toggleAvailability($id)
    {
        $item = FoodItem::findOrFail($id);
        $item->update(['is_available' => ! $item->is_available]);
        $this->refreshList();
    }

    public function delete($id)
    {
        FoodItem::findOrFail($id)->delete();
        $this->refreshList();
        session()->flash('message', 'Food item deleted.');
    }

    public function resetForm()
    {
        $this->reset([
            'category_id', 'name', 'description', 'price', 'is_veg',
            'is_available', 'sort_order', 'image', 'editingId',
        ]);
        $this->is_veg = true;
        $this->is_available = true;
        $this->sort_order = 0;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.fooditems.index')->layout('layouts.admin');
    }
}
