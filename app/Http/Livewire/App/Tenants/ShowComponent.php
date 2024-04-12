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
    public function toggleSuspended($id)
    {
        $this->tenant->suspended = !$this->tenant->suspended;
        $this->tenant->save();
    }
    public function delete($id)
    {
        $tenant = Tenant::find($id);

        // Elimina todas las entidades asociadas al Tenant
        foreach ($tenant->users as $user) {
            $user->notifications()->delete();
            $user->delete();
        }
        $tenant->customers()->delete();
        $tenant->spaces()->delete();
        $tenant->events()->delete();
        $tenant->products()->delete();
        $tenant->payments()->delete();

        // Luego elimina el Tenant
        $tenant->delete();
        return redirect()->route('app.tenants');
    }
}
