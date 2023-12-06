<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Product;
use App\Models\Space;
use Livewire\Component;

class DashboardComponent extends Component
{
    protected $listeners = [
        "Modal" => "Modal",
    ];

    public $modals = [
        "new" => false,
    ];
    public $data, $initialData = [
        "customer_id" => null,
        "name" => null,
        "space_id" => null,

        "date" => null,
        "start_time" => null,
        "end_time" => null,

        "price" => null,
        "notes" => null,
    ];

    public $filters, $initialFilters = [
        "view_type" => "dayGridMonth",

        "space_id" => null,
    ];


    public $events, $showingEvents, $products, $customers, $spaces;

    public function mount()
    {
        $this->events = Event::all();
        $this->customers = Customer::all();
        $this->products = Product::all();
        $this->spaces = Space::all();

        $this->data = $this->initialData;
        $this->filters = $this->initialFilters;
    }

    public function render()
    {
        $this->showingEvents = $this->events->filter(function ($event) {
            if ($this->filters["space_id"] && $event->space_id != $this->filters["space_id"]) return false;
            return true;
        });
        return view('livewire.dashboard-component');
    }

    public function Modal($name, $value, $data = null)
    {
        if ($value === true) $this->data = $this->initialData;
        if ($data) $this->data = array_merge($this->data, $data);

        $this->modals[$name] = $value;
    }

    public function newEvent()
    {
        $this->validate([
            "data.name" => "required|string|max:20",
            "data.space_id" => "required",
            "data.customer_id" => "required",

            "data.date" => "required",
            "data.start_time" => "required",
            "data.end_time" => "required",

            "data.price" => "required",
        ]);

        Event::create($this->data);

        $this->Modal("new", false);
    }

    public function changeView()
    {
        $this->emit("changeView", $this->filters["view_type"]);
    }
}
