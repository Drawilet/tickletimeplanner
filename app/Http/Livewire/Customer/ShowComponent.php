<?php

namespace App\Http\Livewire\Customer;

use App\Events\CustomerEvent;
use App\Http\Livewire\Util\CrudComponent;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ShowComponent extends CrudComponent
{
    protected $listeners =  ["socket" => "socketHandler"];

    public function mount()
    {
        $this->setup(Customer::class, CustomerEvent::class, [
            "primaryKey" => "tradename",
            "keys" => ["logo", "tradename", "businessname"],
            "initialData" => [
                "logo" => "",
                "tradename" => "",
                "businessname" => "",
            ],
            "files" => ["logo" => "img"],
        ]);
        $this->items = $this->Model::all();
    }

    protected function rules()
    {
        return Validator::make($this->data, [
            "logo" => [Rule::requiredIf(isset($this->data["id"])), "image", "max:1024"],
            "tradename" => ["required", "string", "max:255"],
            "businessname" => ["required", "string", "max:255"],
        ]);
    }
}
