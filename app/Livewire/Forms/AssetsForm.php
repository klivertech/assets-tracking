<?php

namespace App\Livewire\Forms;

use Response;
use Livewire\Form;
use App\Models\Unit;
use App\Models\Asset;
use Illuminate\Http\Request;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;

class AssetsForm extends Form
{
    public ?Asset $asset;

    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $total_unit;

    #[Rule('required')]
    public $category_id;

    public $description;

    public function setAsset(Asset $asset)
    {
        $this->asset = $asset;

        $this->name = $asset->name;
        $this->total_unit = $asset->total_unit;
        $this->description = $asset->description;
        $this->category_id = $asset->category_id;

    }

    public function store()
    {
        $totalUnit = Asset::where('name', $this->name)->firstOr(function () {
            return 0;
        });

        if ($totalUnit != null) {
            $totalUnit = $totalUnit->total_unit;
        }

            // Get asset if exists or create new.
            $asset = Asset::updateOrCreate(
                ['name' => $this->name,'category_id' => $this->category_id],
                [
                    'total_unit' => $this->total_unit + $totalUnit,
                    'description' => $this->description,
                    'category_id' => $this->category_id
                ]
            );

            // Loop the process store unit based on total unit.
            for ($i=1; $i <= $this->total_unit; $i++) {
                // Check whether unit has exists.
                if (Unit::count() == 0) {
                    $serialNumber = 'PRDC-'.date('Ymd').sprintf('%06d', 1);
                } else {
                    $lastUnit = Unit::orderBy('id', 'desc')->first();
                    $serialNumber = 'PRDC-'.date('Ymd').sprintf('%06d', $lastUnit->id + 1);
                }

                // The process store unit.
                Unit::create([
                    'serial_number' => $serialNumber,
                    // 'purchase_date' => $request->input('assetPurchaseDate'),
                    'purchase_date' => '2016-03-21',
                    'location' => '504 Ernser Cape',
                    'asset_id' => $asset->id
                ]);
            }
    }

    public function update()
    {
        $duplicateAsset = Asset::where('name', $this->name)->where('category_id', $this->category_id)->first();


        // if ($duplicateAsset != null) {
        //     // $this->dispatch('notification',
        //     //                 status:'error',
        //     //                 position:'center',
        //     //                 title: 'Something went wrong',
        //     //                 button: 'false',
        //     //                 timer: '3500');
        //     return back()->withInput();
        // }

        $this->asset->update($this->except(['asset']));
    }

}
