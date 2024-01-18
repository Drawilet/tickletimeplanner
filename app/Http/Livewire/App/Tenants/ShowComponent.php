<?php

namespace App\Http\Livewire\App\Tenants;

use App\Models\Tenant;
use Livewire\Component;

class ShowComponent extends Component
{
    public $tenant;

    public function mount($id)
    {
        $this->tenant = Tenant::find($id);
    }


    public function render()
    {
        return view('livewire.app.tenants.show-component');
    }
}
