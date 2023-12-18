<?php

namespace App\Livewire\AssetManagement\Asset;

use Livewire\Component;
use App\Models\Category;
use App\Livewire\Forms\AssetsForm;

class Create extends Component
{
    public AssetsForm $form;
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
        $this->validate();

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
        $categories = Category::all();

        return view('livewire.asset-management.asset.create', ['categories' => $categories]);
    }
}
