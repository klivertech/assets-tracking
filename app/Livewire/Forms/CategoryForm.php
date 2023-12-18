<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Category;
use Livewire\Attributes\Rule;

class CategoryForm extends Form
{
    public ?Category $category;

    #[Rule('required')]
    public $name;

    public $description;

    public function setCategory(Category $category)
    {
        $this->category = $category;

        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function store()
    {
        Category::create($this->except(['category']));
    }

    public function update()
    {
        $this->category->update($this->except(['category']));
    }
}
