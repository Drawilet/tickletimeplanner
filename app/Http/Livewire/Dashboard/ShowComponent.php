<?php

namespace App\Http\Livewire\Dashboard;

use App\Events\EventEvent;
use App\Http\Socket\WithCrudSockets;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ShowComponent extends Component
{
    use WithCrudSockets;
    protected $listeners = [
        "Modal" => "Modal",
        "socket" => "handleSocket",
    ];

    public $modals = [
        "save" => false,
        "addProduct" => false,
    ];
    public $eventData, $initialEventData = [
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
        "product_name" => null,
    ];


    public $events, $products, $filteredProducts, $customers, $spaces;

    public function mount()
    {
        $this->addSocketListener("event", ["useItemsKey" => false, "get" => true, "afterUpdate" => "updateEvents"]);
        $this->addSocketListener("product", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("customer", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);

        $this->eventData = $this->initialEventData;
        $this->filters = $this->initialFilters;
    }

    public function render()
    {
        $this->filteredProducts = $this->products->filter(function ($product) {
            if ($this->filters["product_name"] && !str_contains(strtolower($product->name), strtolower($this->filters["product_name"]))) return false;
            return true;
        });
        return view('livewire.dashboard.show-component');
    }

    public function Modal($name, $value, $data = null)
    {
        switch ($name) {
            case 'save':
                if ($value === true) $this->eventData = $this->initialEventData;
                if ($data) {
                    if (isset($data["id"])) $this->eventData = array_merge($this->eventData, $this->events->find($data["id"])->load("products")->toArray());
                    else $this->eventData = array_merge($this->eventData, $data);
                }
                break;
        }

        $this->modals[$name] = $value;
    }

    public function saveEvent()
    {
        Validator::make($this->eventData, [
            "name" => "required",
            "space_id" => "required",
            "customer_id" => "required",

            "date" => "required",
            "start_time" => "required",
            "end_time" => "required",

            "price" => "required",
        ])->validate();

        $event =  Event::create($this->eventData);

        foreach ($this->eventData["products"] as  $product) {
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
        $this->emit("update-events", $this->events->load("space", "customer"));
    }

    public function productAction($product_id, $action, $quantity = 1)
    {
        switch ($action) {
            case 'add':
                if (isset($this->eventData["products"][$product_id])) {
                    $this->eventData["products"][$product_id]["quantity"] += $quantity;
                } else {
                    $this->eventData["products"][$product_id] = [
                        "quantity" => $quantity,
                        "product_id" => $product_id,
                    ];
                }
                break;

            case 'decrease':
                if (isset($this->eventData["products"][$product_id])) {
                    if ($this->eventData["products"][$product_id]["quantity"] > 1) {
                        $this->eventData["products"][$product_id]["quantity"] -= $quantity;
                    } else {
                        unset($this->eventData["products"][$product_id]);
                    }
                }
                break;

            case 'remove':
                unset($this->eventData["products"][$product_id]);
                break;
        }

        $this->Modal("addProduct", false);
    }

    public function getTotal()
    {
        $total = $this->eventData["price"] ?? 0;
        foreach ($this->eventData["products"] as $data) {
            $total += $this->products->find($data["product_id"])->price * $data["quantity"];
        }
        return $total;
    }
}
