<?php

namespace App\Livewire\AssetManagement\Asset;

use App\Models\Asset;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\AssetsForm;

class Detail extends Component
{
    public AssetsForm $form;
    public $isOpenDetail = 0;

    public function openModal()
    {
        $this->isOpenDetail = true;
    }

    public function closeModal()
    {
        $this->isOpenDetail = false;
    }

    #[On('trigger-asset-detail')]
    public function show_unit($id)
    {
        return redirect()->route('admin.assetmanagement.units.index', $id);

        $this->id_asset = $id;

        $this->openModal();
    }



    public function render()
    {
        return view('livewire.asset-management.asset.detail');
    }
}
