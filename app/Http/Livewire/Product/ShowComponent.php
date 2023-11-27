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
            "types" => [
                "photo" => [
                    "type" => "file",
                    "max" => 1,
                    "accept" => ["image/jpeg", "image/png"],
                ],
                "name" => ["type" => "text"],
                "description" => ["type" => "textarea",  "rows" => 4],
                "cost" => ["type" => "number"],
                "price" => ["type" => "number"],
            ],
        ]);
        $this->items = $this->Model::all();
    }

    protected function rules()
    {
        return [];
    }
}
