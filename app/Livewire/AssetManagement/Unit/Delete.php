<?php

namespace App\Livewire\AssetManagement\Unit;

use App\Models\Unit;
use App\Models\Asset;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;

class Delete extends Component
{
    public $isOpenDeleteUnit = 0;

    #[Locked]
    public $serialNumber;

    #[Locked]
    public $id;

    public function openModalDeleteUnit()
    {
        // dd($this->isOpenDeleteUnit);
        $this->isOpenDeleteUnit = true;
    }
    public function closeModalDeleteUnit()
    {
        $this->isOpenDeleteUnit = false;
    }

    #[On('trigger-unit-delete')]
    public function bang($id, $serialNumber)
    {

        // return redirect()->to('/dashboard');
        $this->id = $id;
        $this->serialNumber = $serialNumber;

        $this->openModalDeleteUnit();
    }

    public function delete()
    {

        try {

            DB::beginTransaction();
            $assetId = Unit::where('id', $this->id)->select('asset_id')->first();
            $totalUnitFinal = Asset::where('id', $assetId->asset_id)->select('total_unit')->first();

            Unit::destroy($this->id);
            Asset::where('id', $assetId->asset_id)->update(['total_unit' => $totalUnitFinal->total_unit - 1]);

            $this->closeModalDeleteUnit();

            $this->dispatch('notification',
                            status:'success',
                            position:'top-end',
                            title: 'Data has been deleted',
                            button: 'false',
                            timer: '1500');

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollback();

            $this->dispatch('notification',
                            status:'error',
                            position:'center',
                            title: 'Something went wrong',
                            button: 'false',
                            timer: '3500');

            echo $e;

        }

    }

    public function render()
    {
        return view('livewire.asset-management.unit.delete');
    }
}
