<?php

namespace App\Http\Livewire\App\Tenants;

use App\Models\Tenant;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TenantComponent extends Component
{
    public $tenant, $transactions;
    public $remainingDays;

    public $initialTransaction = [
        'amount' => 0,
        "notes" => "",
    ], $transaction;


    public function mount($id)
    {
        $this->tenant = Tenant::find($id);
        $this->transactions = $this->tenant->transactions;
        $this->remainingDays = Carbon::parse($this->tenant->subscription_ends_at)->diffInDays(now());

        $this->transaction = $this->initialTransaction;
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
        $tenant->transactions()->delete();

        $tenant->delete();
        return redirect()->route('app.tenants');
    }


    public function addTransaction()
    {
        Validator::make($this->transaction, [
            'amount' => 'required|numeric|min:1',
            'notes' => 'required|string|min:3|max:255',
        ])->validate();

        $transaction = $this->tenant->transactions()->create($this->transaction);
        $this->transactions->push($transaction);

        $this->transaction = $this->initialTransaction;

        $this->tenant->balance += $transaction->amount;

        if ($this->tenant->balance >= 0) {
            $this->tenant->suspended = false;
        }

        $this->tenant->save();
    }
}
