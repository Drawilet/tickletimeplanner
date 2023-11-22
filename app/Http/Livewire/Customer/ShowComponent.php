<?php

namespace App\Http\Livewire\Customer;

use App\Events\CustomerEvent;
use App\Http\Livewire\Util\CrudComponent;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowComponent extends CrudComponent
{
    protected $listeners =  ["socket" => "socketHandler"];

    public function mount()
    { {
            $this->setup(Customer::class, CustomerEvent::class, ["tradename", "businessname"], [
                "tradename" => "",
                "businessname" => "",
            ], "businessname");
            $this->items = $this->Model::all();
        }
    }
}
