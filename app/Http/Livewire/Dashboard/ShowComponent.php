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
        "update-filters" => "updateFilters",
    ];

    public $modals = [
        "save" => false,
        "addProduct" => false,
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

        "products" => [],
    ];

    public $filters, $initialFilters = [
        "spaces" => [],
        "product_name" => null,
    ];


    public $events, $filteredEvents, $products, $filteredProducts, $customers, $spaces;

    public function mount()
    {
        $this->addSocketListener("event", ["useItemsKey" => false, "get" => true, "afterUpdate" => "updateEvents"]);
        $this->addSocketListener("product", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("customer", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);

        $this->data = $this->initialData;

        $this->initialFilters["spaces"] = $this->spaces->pluck("id")->toArray();
        $this->filters = $this->initialFilters;
    }

    public function getFilteredItems()
    {
        $this->filteredEvents = $this->events->filter(function ($event) {
            if (!in_array($event->space_id, $this->filters["spaces"])) return false;
            return true;
        });

        $this->filteredProducts = $this->products->filter(function ($product) {
            if ($this->filters["product_name"] && !str_contains(strtolower($product->name), strtolower($this->filters["product_name"]))) return false;
            return true;
        });
    }

    public function render()
    {
        $this->getFilteredItems();
        return view('livewire.dashboard.show-component');
    }

    public function Modal($name, $value, $data = null)
    {
        switch ($name) {
            case 'save':
                if ($value === true) $this->data = $this->initialData;
                if ($data) {
                    if (isset($data["id"])) $this->data = array_merge($this->data, $this->events->find($data["id"])->load("products")->toArray());
                    else $this->data = array_merge($this->data, $data);
                }
                break;
        }

        $this->modals[$name] = $value;
    }

    public function saveEvent()
    {
        $this->validate([
            "data.name" => "required",
            "data.space_id" => "required",
            "data.customer_id" => "required",

            "data.date" => "required",
            "data.start_time" => "required",
            "data.end_time" => "required",

            "data.price" => "required",
        ]);

        $event =  Event::create($this->data);

        foreach ($this->data["products"] as  $product) {
            $event->products()->create([
                "product_id" => $product["product_id"],
                "quantity" => $product["quantity"],
            ]);
        }

        event(new EventEvent("create", $event));
        $this->Modal("save", false);
    }

    public function updateEvents()
    {
        $this->getFilteredItems();
        $this->emit("update-events", $this->filteredEvents->load("space", "customer"));
    }

    public function updateFilters($filters)
    {
        $this->filters = array_merge($this->filters, $filters);
        $this->updateEvents();
    }

    public function productAction($product_id, $action, $quantity = 1)
    {
        switch ($action) {
            case 'add':
                if (isset($this->data["products"][$product_id])) {
                    $this->data["products"][$product_id]["quantity"] += $quantity;
                } else {
                    $this->data["products"][$product_id] = [
                        "quantity" => $quantity,
                        "product_id" => $product_id,
                    ];
                }
                break;

            case 'decrease':
                if (isset($this->data["products"][$product_id])) {
                    if ($this->data["products"][$product_id]["quantity"] > 1) {
                        $this->data["products"][$product_id]["quantity"] -= $quantity;
                    } else {
                        unset($this->data["products"][$product_id]);
                    }
                }
                break;

            case 'remove':
                unset($this->data["products"][$product_id]);
                break;
        }

        $this->Modal("addProduct", false);
    }

    public function getTotal()
    {
        $total = $this->data["price"] ?? 0;
        foreach ($this->data["products"] as $data) {
            $total += $this->products->find($data["product_id"])->price * $data["quantity"];
        }
        return $total;
    }
}
