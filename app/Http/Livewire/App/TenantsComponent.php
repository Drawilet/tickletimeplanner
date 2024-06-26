<?php

namespace App\Http\Livewire\App;

use App\Models\Tenant;
use Livewire\Component;

class TenantsComponent extends Component
{
    public $tenants;

    public function mount()
    {
        $this->tenants = Tenant::all();
    }

    public function render()
    {
        return view('livewire.app.tenants-component');

    }
}
