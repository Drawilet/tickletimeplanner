<?php

namespace App\Http\Livewire\Event;

use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;

class NewComponent extends Component
{
    public $initialData = [
        "customer_id" => null,
        "name" => null,
        "date" => null,
        "location" => null,
        "notes" => null,
    ];
    public $data;

    public $products, $customers;

    public function mount()
    {
        $this->customers = Customer::all();
        $this->products = Product::all();

        $this->data = $this->initialData;
    }

    public function render()
    {
        return view('livewire.event.new-component');
    }
}
