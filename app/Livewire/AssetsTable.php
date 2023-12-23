<?php

namespace App\Livewire;

use App\Models\Asset;
use Livewire\Component;
use Livewire\WithPagination;

class AssetsTable extends Component
{

    use WithPagination;

    public $search = '';
    public $show = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';


    public function setSortBy($sortByField){

        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        $assets = Asset::with('category')
                ->search($this->search)
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->show);

        return view('livewire.assets-table',['assets' => $assets]);
    }
}
