<?php

namespace App\Livewire\AssetManagement\Asset;

use App\Models\Asset;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use App\Livewire\Forms\AssetsForm;

class Edit extends Component
{
    public AssetsForm $form;
    public $isOpenEdit = 0;

    public function openModal()
    {
        $this->isOpenEdit = true;
    }
    public function closeModal()
    {
        $this->isOpenEdit = false;
    }

    #[On('trigger-asset-edit')]
    public function set_asset(Asset $id)
    {
        $this->form->setAsset($id);

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
        $categories = Category::all();

        return view('livewire.asset-management.asset.edit', ['categories' => $categories]);
    }
}
