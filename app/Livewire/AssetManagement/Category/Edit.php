<?php

namespace App\Livewire\AssetManagement\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use App\Livewire\Forms\CategoryForm;

class Edit extends Component
{
    public CategoryForm $form;
    public $isOpenEdit = 0;

    public function openModal()
    {
        $this->isOpenEdit = true;
    }
    public function closeModal()
    {
        $this->isOpenEdit = false;
    }

    #[On('trigger-category-edit')]
    public function set_category(Category $id)
    {
        $this->form->setCategory($id);

        $this->openModal();
    }

    public function edit()
    {
        $this->validate();

        try {

            $this->form->update();

            $this->reset();
            $this->closeModal();
            $this->dispatch('notification',
                            status:'success',
                            position:'top-end',
                            title: 'Data has been saved',
                            button: 'false',
                            timer: '1500');

        } catch (\Throwable $e) {

            $this->dispatch('notification',
                            status:'error',
                            position:'center',
                            title: 'Something went wrong',
                            button: 'false',
                            timer: '3500');
        }
    }


    public function render()
    {
        return view('livewire.asset-management.category.edit');
    }
}
