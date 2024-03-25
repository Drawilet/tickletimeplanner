<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WizardComponent extends Component
{
    public $user;
    public $step;
    public $currentRoute;

    public $steps = [
        [
            "name" => "tenant",
            "route" => "tenant.settings.show"
        ],
        [
            "name" => "space",
            "route" => "tenant.spaces.show"
        ],
        [
            "name" => "product",
            "route" => "tenant.products.show",
            "skippable" => true
        ],
        [
            "name" => "event",
            "route" => "dashboard.show",
            "skippable" => true
        ]
    ];


    public function mount()
    {
        $this->user = Auth::user();
        $step = $this->user->wizard_step;
        $this->step = $this->steps[$step] ?? null;

        $this->currentRoute = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.wizard-component');
    }

    public function skip()
    {
        if (count($this->steps) == $this->user->wizard_step) {
            $this->user->wizard_step++;
            $this->user->save();

        }


    }
}
