<?php

namespace App\Livewire\AssetManagement\Asset;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;

class Index extends Component
{
    #[On('trigger-asset-detail')]
    public function show_unit($id)
    {
        return redirect()->route('admin.assetmanagement.units.index', $id);

        $this->id_asset = $id;
    }

    public function render()
    {
        return view('livewire.asset-management.asset.index');
    }
}
