<?php

namespace App\Http\Livewire\Event;

use Livewire\Component;

class Product extends Component
{
    public $products;

    public function render()
    {
        return view('livewire.event.product');
    }
}
