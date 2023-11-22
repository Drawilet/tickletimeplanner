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
            "primaryKey" => "name",
            "keys" => ["photo", "name", "description", "cost", "price"],
            "initialData" => [
                "photo" => "",
                "name" => "",
                "description" => "",
                "cost" => 0,
                "price" => 0,
            ],
            "files" => ["photo" => "img"],
        ]);
        $this->items = $this->Model::all();
    }

    protected function rules()
    {
        return [];
    }
}
