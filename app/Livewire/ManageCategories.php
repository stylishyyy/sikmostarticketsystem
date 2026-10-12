<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;

class ManageCategories extends Component
{
    public $name = '';
    
    // Polja za unos potkategorije
    public $subcategory_name = '';
    public $parent_category_id = '';

    public function addCategory()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:255'
        ]);

        Category::create([
            'name' => $this->name
        ]);

        session()->flash('category_message', 'Kategorija je uspješno dodana.');
        $this->reset('name');
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            session()->flash('category_message', 'Kategorija i sve njene potkategorije su obrisane.');
        }
    }

    public function addSubcategory()
    {
        $this->validate([
            'parent_category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required|string|min:2|max:255'
        ]);

        Subcategory::create([
            'category_id' => $this->parent_category_id,
            'name' => $this->subcategory_name
        ]);

        session()->flash('category_message', 'Potkategorija uspješno dodana!');
        $this->reset(['parent_category_id', 'subcategory_name']);
    }

    public function deleteSubcategory($id)
    {
        $sub = Subcategory::find($id);
        if ($sub) {
            $sub->delete();
            session()->flash('category_message', 'Potkategorija obrisana.');
        }
    }

    public function render()
    {
        return view('livewire.manage-categories', [
            'categories' => Category::with('subcategories')->orderBy('name')->get()
        ]);
    }
}