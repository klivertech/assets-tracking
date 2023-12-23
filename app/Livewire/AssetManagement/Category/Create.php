<?php

namespace App\Livewire\AssetManagement\Category;

use Livewire\Component;
use App\Livewire\Forms\CategoryForm;

class Create extends Component
{
    public CategoryForm $form;
    public $isOpen = 0;

    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function save()
    {
        // $this->validate();

        try {

            $this->form->store();
            $this->reset();
            $this->closeModal();
            $this->dispatch('notification',
                            status:'success',
                            position:'top-end',
                            title: 'Data has been saved',
                            button: 'false',
                            timer: '1500');

        } catch (\Throwable $e) {

            echo $e;

        }

    }

    public function render()
    {
        return view('livewire.asset-management.category.create');
    }
}
