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
            "route" => "settings.show"
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
        $tenant = $this->user->tenant;
        if ($tenant && !$this->user->hasRole("tenant.admin"))
            return $this->step = null;

        $step = $this->user->wizard_step;
        $this->step = $this->steps[$step] ?? null;

        $this->currentRoute = request()->route()->getName();
        if ($this->currentRoute == "profile.show")
            $this->step = null;
    }

    public function render()
    {
        return view('livewire.wizard-component');
    }

    public function skip()
    {
        $this->user->wizard_step++;
        $this->user->save();

        $step = $this->steps[$this->user->wizard_step] ?? null;
        if ($step)
            redirect()->route($step['route']);
        else
            redirect()->route('dashboard.show');
    }
}
