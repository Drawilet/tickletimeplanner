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
                "notes" => ["type" => "textarea", "rules" => "nullable"],
            ],
            "mobileStyles" => "
                .photo {
                    width: 100%;
                    justify-content: center;
                    margin-bottom: 10px;
                }

                .photo img {
                   height: 200px;
                   width: 200px;
                }

                .name {
                    width: 100%;
                    justify-content: center;
                    font-size: 1.2rem;
                    margin-bottom: -8px;
                }

                .description {
                    width: 100%;
                    justify-content: center;
                    font-size: 1rem;
                }

                .cost, .price {
                    width: 50%;
                    justify-content: center;
                    font-size: 1rem;
                }

            ",
            "foreigns" => ["events"],
        ]);
    }
}
