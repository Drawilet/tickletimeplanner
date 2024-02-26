<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class HomeComponent extends Component
{
    public $locale;

    public function mount()
    {
        $this->locale = app()->getLocale();
    }

    public function render()
    {

        return view('livewire.home-component')->layout("layouts.guest");
    }
}
