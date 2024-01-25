<?php

namespace App\Http\Livewire\Tenant\Customers;

use App\Events\CustomerEvent;
use App\Http\Livewire\Util\CrudComponent;
use App\Models\Customer;

class ShowComponent extends CrudComponent
{
    public function mount()
    {
        $this->setup(Customer::class, CustomerEvent::class, [
            "mainKey" => "firstname",
            "types" => [
                "firstname" => ["type" => "text"],
                "lastname" => ["type" => "text"],
                "email" => ["type" => "email"],
                "phone" => ["type" => "text"],
                "address" => ["type" => "textarea",  "rows" => 4],
                "notes" => ["type" => "text", "rules" => "nullable"],
            ],
            "foreigns" => ["events"],
        ]);
    }
}
