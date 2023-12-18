<?php

namespace App\Livewire\AssetManagement\Asset;

use App\Models\Unit;
use App\Models\Asset;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;

class Delete extends Component
{
    public $isOpenDelete = 0;

    #[Locked]
    public $assetName;

    #[Locked]
    public $id;

    #[Locked]
    public $units;

    public function openModal()
    {
        $this->isOpenDelete = true;
    }
    public function closeModal()
    {
        $this->isOpenDelete = false;
    }

    #[On('trigger-asset-delete')]
    public function show_confirmation($id, $assetName)
    {
        $this->id = $id;
        $this->assetName = $assetName;
        $this->units = Unit::where('asset_id', $id)->get();

        $this->openModal();
    }

    public function delete()
    {

        try {

            DB::table('units')->where('asset_id', $this->id)->delete();
            DB::table('assets')->where('id', $this->id)->delete();

            $this->closeModal();

            $this->dispatch('notification',
                            status:'success',
                            position:'top-end',
                            title: 'Data has been deleted',
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
        return view('livewire.asset-management.asset.delete');
    }
}
