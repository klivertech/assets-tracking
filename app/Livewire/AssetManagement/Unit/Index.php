<?php

namespace App\Livewire\AssetManagement\Unit;

use Livewire\Component;

class Index extends Component
{

    public function mount($id)
    {
        $this->id_asset = $id;
    }

    public function render()
    {
        return view('livewire.asset-management.unit.index');
    }
}
