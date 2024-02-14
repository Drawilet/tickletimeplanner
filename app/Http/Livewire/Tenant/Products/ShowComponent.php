<?php

namespace App\Http\Livewire\Tenant\Products;

use App\Events\ProductEvent;
use App\Http\Livewire\Util\CrudComponent;
use App\Models\Product;
use App\Rules\Price;

class ShowComponent extends CrudComponent
{
    public function mount()
    {
        $this->setup(Product::class,  [
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
                "notes" => ["type" => "text", "rules" => "nullable"],
            ],
            "foreigns" => ["events"],
        ]);
    }
}
