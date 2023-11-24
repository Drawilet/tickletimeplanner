<?php

namespace App\Http\Livewire\Product;

use App\Events\ProductEvent;
use App\Http\Livewire\Util\CrudComponent;
use App\Models\Product;

class ShowComponent extends CrudComponent
{
    protected $listeners =  ["socket" => "socketHandler"];

    public function mount()
    {
        $this->setup(Product::class, ProductEvent::class, [
            "mainKey" => "name",
            "keys" => ["photo", "name", "description", "cost", "price"],
            "initialData" => [
                "photo" => "",
                "name" => "",
                "description" => "",
                "cost" => 0,
                "price" => 0,
            ],
            "specialInputs" => [
                "photo" => [
                    "type" => "file",
                    "max" => 1,
                    "accept" => ["image/jpeg", "image/png"],
                ],
            ],
        ]);
        $this->items = $this->Model::all();
    }

    protected function rules()
    {
        return [];
    }
}
