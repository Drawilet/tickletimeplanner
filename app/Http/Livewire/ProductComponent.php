<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductComponent extends Component
{
    public $allproducts, $CreateModal;
    public function render()
    {
        $this->allproducts = Product::all();
        return view('livewire.product-component');
    }
}
