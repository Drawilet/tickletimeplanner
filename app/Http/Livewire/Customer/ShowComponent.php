<?php

namespace App\Http\Livewire\Customer;

use App\Events\CustomerEvent;
use App\Http\Livewire\Util\CrudComponent;
use App\Models\Customer;

class ShowComponent extends CrudComponent
{
    public function mount()
    {
        $this->setup(Customer::class, CustomerEvent::class, [
            "mainKey" => "tradename",
            "types" => [
                "logo" =>     [
                    "type" => "file",
                    "accept" => ["image/jpeg", "image/png"],
                ],
                "tradename" => ["type" => "text"],
                "businessname" => ["type" => "text"]
            ],
        ]);
    }
}
