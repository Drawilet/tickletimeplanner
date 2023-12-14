<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SpacesComponent extends Component
{
    public function render()
    {
        return view('livewire.spaces-component')->layout("layouts.guest");
    }
}
