<?php

namespace App\Http\Livewire\Dashboard;

use App\Events\EventEvent;
use App\Http\Socket\WithCrudSockets;
use App\Models\Event;
use Livewire\Component;

class ShowComponent extends Component
{
    use WithCrudSockets;
    protected $listeners = [
        "Modal" => "Modal",
        "socket" => "handleSocket",
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
        "space_id" => null,
    ];


    public $events, $filteredEvents, $products, $customers, $spaces;

    public function mount()
    {
        $this->addSocketListener("event", ["useItemsKey" => false, "get" => true, "afterUpdate" => "updateEvents"]);
        $this->addSocketListener("product", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("customer", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);

        $this->data = $this->initialData;
        $this->filters = $this->initialFilters;
    }

    public function render()
    {
        $this->filteredEvents = $this->events->filter(function ($event) {
            if ($this->filters["space_id"] && $event->space_id != $this->filters["space_id"]) return false;
            return true;
        });
        return view('livewire.dashboard.show-component');
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

        $event =  Event::create($this->data);

        event(new EventEvent("create", $event));
        $this->Modal("new", false);
    }

    public function updateEvents()
    {
        $this->emit("update-events", $this->events);
    }
}
