<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Navbar extends Component
{
    public $isDropdownOpen1 = false;
    public $isDropdownOpen2 = false;

    public function toggleDropdown1()
    {
        $this->isDropdownOpen1 = !$this->isDropdownOpen1;

    }

    public function toggleDropdown2()
    {
        $this->isDropdownOpen2 = !$this->isDropdownOpen2;
    }

    public function render()
    {
        return view('livewire.component.navbar');
    }
}
