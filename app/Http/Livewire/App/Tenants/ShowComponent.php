<?php

namespace App\Http\Livewire\App\Tenants;

use App\Models\Tenant;
use App\Models\Customer;
use Livewire\Component;

class ShowComponent extends Component
{
    public $tenant;
    public $customer;

    public function mount($id)
    {
        $this->tenant = Tenant::find($id);

        $this->customer = Customer::find($id);
    }

    public function render()
    {
        return view('livewire.app.tenants.show-component');
    }
}
