<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;


use Livewire\Component;

class AccessibilityComponent extends Component
{
    public function render()
    {
        return view('livewire.accessibility-component');
    }
}
