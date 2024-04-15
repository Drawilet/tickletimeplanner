<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CountdownComponent extends Component
{
    public $remainingDays;
    public function mount()
    {
        $tenant = Auth::user()->tenant;
        $this->remainingDays = Carbon::parse($tenant->subscription_ends_at)->diffInDays(now());

    }

    public function render()
    {
        return view('livewire.countdown-component');
    }
}
