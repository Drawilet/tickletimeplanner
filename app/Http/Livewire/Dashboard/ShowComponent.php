<?php

namespace App\Http\Livewire\Dashboard;

use App\Events\CustomerEvent;
use App\Events\EventEvent;
use App\Http\Socket\WithCrudSockets;
use App\Models\Customer;
use App\Models\Event;
use App\Models\Payment;
use App\Rules\PhoneNumber;
use Carbon\Carbon;
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
        "newCustomer" => false,
    ];
    public $event, $initialEvent = [
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

    public $payment, $initialPayment = [
        "user_id" => null,
        "event_id" => null,
        "amount" => null,
        "notes" => null,
    ];

    public $customer, $initialCustomer = [
        "firstname" => null,
        "lastname" => null,
        "email" => null,
        "phone" => null,
        "address" => null,
        "notes" => null,
    ];

    public $events, $products, $filteredProducts, $customers, $spaces;

    public $currentSpace;

    public function mount()
    {
        $this->addSocketListener("event", ["useItemsKey" => false, "get" => true, "afterUpdate" => "updateEvents"]);
        $this->addSocketListener("product", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("customer", ["useItemsKey" => false, "get" => true]);
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);

        $this->event = $this->initialEvent;
        $this->payment = $this->initialPayment;
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
                if ($value === true) $this->event = $this->initialEvent;
                if ($data) {
                    if (gettype($data) != "array" && array_keys($data->toArray()) > 2) {
                        error_log("Data is not an array");
                        $this->event = array_merge($this->event, $data->load("products", "payments")->toArray());
                    } else if (isset($data["id"]))
                        $this->event = array_merge(
                            $this->event,
                            $this->events->find($data["id"])->load("products", "payments")->toArray()
                        );
                    else $this->event = array_merge($this->event, $data);
                }
                break;

            case 'newCustomer':
                if ($value === true) $this->customer = $this->initialCustomer;
                break;
        }

        $this->modals[$name] = $value;
    }

    public function saveEvent()
    {
        $schedule = $this->getSchedule();

        Validator::make($this->event, [
            "name" => "required",
            "space_id" => "required",
            "customer_id" => "required",

            "date" => "required",
            "start_time" => "required|after_or_equal:" . $schedule["opening"] . "|before_or_equal:" . $schedule["closing"],
            "end_time" => "required|after:start_time|before_or_equal:" . $schedule["closing"],

            "price" => "required",
        ])->validate();

        $event = Event::updateOrCreate(["id" => $this->event["id"] ?? ""], $this->event);

        $event->products()->delete();
        foreach ($this->event["products"] as  $product) {
            $event->products()->create([
                "product_id" => $product["product_id"],
                "quantity" => $product["quantity"],
            ]);
        }

        event(new EventEvent(isset($this->event["id"]) ? "update" : "create", $event));

        $this->Modal("save", true, $event);
    }

    public function updateEvents()
    {
        $this->emit("update-events", $this->events->load("space", "customer"));
    }

    public function productAction($product_id, $action, $quantity = 1)
    {
        switch ($action) {
            case 'add':
                if (isset($this->event["products"][$product_id])) {
                    $this->event["products"][$product_id]["quantity"] += $quantity;
                } else {
                    $this->event["products"][$product_id] = [
                        "quantity" => $quantity,
                        "product_id" => $product_id,
                    ];
                }
                break;

            case 'decrease':
                if (isset($this->event["products"][$product_id])) {
                    if ($this->event["products"][$product_id]["quantity"] > 1) {
                        $this->event["products"][$product_id]["quantity"] -= $quantity;
                    } else {
                        unset($this->event["products"][$product_id]);
                    }
                }
                break;

            case 'remove':
                unset($this->event["products"][$product_id]);
                break;
        }

        $this->Modal("addProduct", false);
    }

    public function getTotal()
    {
        $total = $this->event["price"] ?? 0;
        foreach ($this->event["products"] as $data) {
            $total += $this->products->find($data["product_id"])->price * $data["quantity"];
        }
        return $total;
    }

    public function getRemaining()
    {
        $remaining = $this->getTotal();
        foreach ($this->event["payments"] as $payment) {
            $remaining -= $payment["amount"];
        }
        return $remaining;
    }

    public function addPayment()
    {
        Validator::make($this->payment, [
            "amount" => "required|numeric|max:" . $this->getRemaining() . "|min:0",
            "notes" => "required",
        ])->validate();

        $this->payment["amount"] = (float) $this->payment["amount"];
        $this->payment["event_id"] = $this->event["id"];
        $this->payment["user_id"] = auth()->user()->id;

        $payment = Payment::create($this->payment);
        $this->event["payments"][] = $payment;
        $this->payment = $this->initialPayment;

        $this->emit("toast", "success", "Payment added successfully");
    }

    public function newCustomer()
    {
        Validator::make($this->customer, [
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required|email",
            "phone" => ["required", new PhoneNumber()],
            "address" => "required",
            "notes" => "max:255"
        ])->validate();

        $customer = Customer::create($this->customer);
        $this->customer = $this->initialCustomer;

        $this->Modal("newCustomer", false);

        event(new CustomerEvent("create", $customer));

        $this->event["customer_id"] = $customer->id;

        $this->emit("toast", "success", __('toast-lang.Customeraddedsuccessfully'));
    }

    public function updateSpace()
    {
        $this->currentSpace = $this->spaces->find($this->event["space_id"]) ?? null;
    }

    public function getSchedule()
    {
        $date = Carbon::parse($this->event["date"]);
        $dayName = strtolower($date->format("l"));
        $schedule = $this->currentSpace
            ? $this->currentSpace->schedule[$dayName]
            : [
                'opening' => '00:00',
                'closing' => '00:00',
            ];

        return  $schedule;
    }

    function updateEndTime()
    {
        if ($this->event["end_time"]) return;
        $this->event["end_time"] = $this->event["start_time"];
    }
}
