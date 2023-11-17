<?php

namespace App\Http\Livewire\Event;

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

    public $products = [
        [
            "name" => "Balloons",
            "description" => "A bunch of balloons",
            "price" => 10,
            "photo" => "https://www.creativefabrica.com/wp-content/uploads/2021/04/27/birthday-ballon-Graphics-11408204-1-580x387.png"
        ],        [
            "name" => "Balloons",
            "description" => "A bunch of balloons",
            "price" => 10,
            "photo" => "https://www.creativefabrica.com/wp-content/uploads/2021/04/27/birthday-ballon-Graphics-11408204-1-580x387.png"
        ],        [
            "name" => "Balloons",
            "description" => "A bunch of balloons",
            "price" => 10,
            "photo" => "https://www.creativefabrica.com/wp-content/uploads/2021/04/27/birthday-ballon-Graphics-11408204-1-580x387.png"
        ],        [
            "name" => "Balloons",
            "description" => "A bunch of balloons",
            "price" => 10,
            "photo" => "https://www.creativefabrica.com/wp-content/uploads/2021/04/27/birthday-ballon-Graphics-11408204-1-580x387.png"
        ],        [
            "name" => "Balloons",
            "description" => "A bunch of balloons",
            "price" => 10,
            "photo" => "https://www.creativefabrica.com/wp-content/uploads/2021/04/27/birthday-ballon-Graphics-11408204-1-580x387.png"
        ]
    ];

    public function mount()
    {
        $this->data = $this->initialData;
    }

    public function render()
    {
        return view('livewire.event.new-component');
    }
}
