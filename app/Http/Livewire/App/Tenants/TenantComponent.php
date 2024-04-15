<?php

namespace App\Http\Livewire\App\Tenants;

use App\Models\Tenant;
use App\Models\Customer;
use Livewire\Component;
use Carbon\Carbon;

class TenantComponent extends Component
{
    public $tenant;
    public $remainingDays;

    public function mount($id)
    {
        $this->tenant = Tenant::find($id);
        $this->remainingDays = Carbon::parse($this->tenant->subscription_ends_at)->diffInDays(now());
    }

    public function render()
    {
        return view('livewire.app.tenants.tenant-component');
    }
    public function toggleSuspended($id)
    {
        $this->tenant->suspended = !$this->tenant->suspended;
        $this->tenant->save();
    }
    public function delete($id)
    {
        $tenant = Tenant::find($id);

        foreach ($tenant->users as $user) {
            $user->notifications()->delete();
            $user->delete();
        }
        $tenant->customers()->delete();
        $tenant->spaces()->delete();
        $tenant->events()->delete();
        $tenant->products()->delete();
        $tenant->payments()->delete();

        $tenant->delete();
        return redirect()->route('app.tenants');
    }
}
