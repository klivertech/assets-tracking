<?php

namespace App\Livewire\AssetManagement\Category;

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
    public $categoryName;

    #[Locked]
    public $id;

    #[Locked]
    public $assets;

    public function openModal()
    {
        $this->isOpenDelete = true;
    }
    public function closeModal()
    {
        $this->isOpenDelete = false;
    }

    #[On('trigger-category-delete')]
    public function show_confirmation($id, $categoryName)
    {
        $this->id = $id;
        $this->categoryName = $categoryName;
        $this->assets = Asset::where('category_id', $id)->get();

        $this->openModal();
    }

    public function delete()
    {

        try {

            DB::beginTransaction();

            DB::table('units')
                ->join('assets', 'units.asset_id','=', 'assets.id')
                ->where('assets.category_id', $this->id)->delete();

            DB::table('assets')->where('category_id', $this->id)->delete();
            DB::table('categories')->where('id', $this->id)->delete();

            $this->closeModal();

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
        return view('livewire.asset-management.category.delete');
    }
}
