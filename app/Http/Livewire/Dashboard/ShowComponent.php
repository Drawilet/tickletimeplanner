<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Traits\WithCrudActions;
use App\Http\Traits\WithValidations;
use App\Models\Customer;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Space;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ShowComponent extends Component
{
    use WithCrudActions, WithValidations;
    protected $listeners = [
        "Modal" => "Modal",
    ];

    public $modals = [
        "save" => false,
        "delete" => false,
        "addProduct" => false,
        "newCustomer" => false,
        "payments" => false,
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

    public $events, $products, $filteredProducts, $customers, $spaces, $payments;

    public $currentSpace;
    public $searchTerm;
    public $SelectCustomer;
    public $skip_customer = 0;
    public $CUSTOMER_PER_PAGE = 5;
    public $NewCustomers;
    public $CAN_LOAD_MORE;

    public function mount()
    {
        $this->addCrud(Payment::class, ["useItemsKey" => false, "get" => true]);
        $this->addCrud(Customer::class, ["useItemsKey" => false, "get" => true]);
        $this->addCrud(Space::class, ["useItemsKey" => false, "get" => true]);
        $this->addCrud(Product::class, ["useItemsKey" => false, "get" => true]);

        $this->event = $this->initialEvent;
        $this->payment = $this->initialPayment;
        $this->filters = $this->initialFilters;

        $this->customers = Customer::take($this->CUSTOMER_PER_PAGE)->get();
        $this->skip_customer = $this->CUSTOMER_PER_PAGE;
    }
    public function updatedSearchTerm()
    {
        $this->customers = Customer::where('firstname', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('lastname', 'like', '%' . $this->searchTerm . '%')
            ->get();
    }
    public function SetCustomer($id)
    {
        $this->SelectCustomer = Customer::find($id);
        $this->searchTerm = $this->SelectCustomer->firstname . ' ' . $this->SelectCustomer->lastname;
        $this->event['customer_id'] = $id;
    }
    public function loadMore()
{
    $newCustomers = Customer::skip($this->skip_customer)->take($this->CUSTOMER_PER_PAGE)->get();
    $this->customers = $this->customers->concat($newCustomers);
    $this->skip_customer += $this->CUSTOMER_PER_PAGE;
    $this->CAN_LOAD_MORE = Customer::count() > $this->skip_customer;
}
public function updateCustomerId($value)
{
    $this->event['customer_id'] = $value;
}

    public function render()
    {
        $this->filteredProducts = $this->products->filter(function ($product) {
            if ($this->filters["product_name"] && !str_contains(strtolower($product->name), strtolower($this->filters["product_name"]))) return false;
            return true;
        });

        $this->currentSpace = $this->spaces->find($this->event["space_id"]) ?? null;

        $this->CAN_LOAD_MORE = $this->customers->count() > $this->skip_customer;
        return view('livewire.dashboard.show-component');
    }

    public function Modal($name, $value, $data = null)
    {
        switch ($name) {
            case 'save':
                if ($value === true) $this->event = $this->initialEvent;
                else
                    $this->modals["payments"] = false;

                if ($data) {
                    if (gettype($data) != "array" && array_keys($data->toArray()) > 2) {
                        $this->event = array_merge(
                            $this->event,
                            $data->load("products", "payments")->toArray()
                        );
                    } else if (isset($data["id"])) {
                        $event = Event::find($data["id"]);
                        if ($event)
                            $this->event = array_merge(
                                $this->event,
                                $event->load("products", "payments")->toArray()
                            );
                    } else $this->event = array_merge($this->event, $data);
                }

                break;

            case 'newCustomer':
                if ($value === true) $this->customer = $this->initialCustomer;
                break;

            case 'delete':
                if ($value === true) {
                    $this->event["payments_count"] = count($this->event["payments"]);
                    $this->modals["save"] = false;
                }
                break;
        }

        $this->modals[$name] = $value;
    }

    public function saveEvent()
    {
        $schedule = $this->getSchedule();

        Validator::make($this->event, [
            "name" => "required|" . $this->validations["text"],
            "space_id" => "required",
            "customer_id" => "required",
            "date" => "required",
            "price" => "required|" . $this->validations["number"],
            "notes" => "nullable|" . $this->validations["textarea"],
        ])->validate();

        if (!isset($this->event["id"])) {
            Validator::make($this->event, [
                "start_time" => "required|after_or_equal:" . $schedule["opening"] . "|before_or_equal:" . $schedule["closing"],
                "end_time" => "required|after:start_time|before_or_equal:" . $schedule["closing"],
            ])->validate();

            $events = Event::where("space_id", $this->event["space_id"])->where("date", $this->event["date"]);
            foreach ($events as $event) {
                if (
                    ($this->event["start_time"] >= $event->start_time && $this->event["start_time"] < $event->end_time) ||
                    ($this->event["end_time"] > $event->start_time && $this->event["end_time"] <= $event->end_time)
                ) {
                    $this->emit("toast", "error", __("calendar-lang.not-available"));
                    return;
                }
            }
        }

        $event = Event::updateOrCreate(["id" => $this->event["id"] ?? ""], $this->event);

        $event->products()->delete();
        foreach ($this->event["products"] as  $product) {
            $event->products()->create([
                "product_id" => $product["product_id"],
                "quantity" => $product["quantity"],
            ]);
        }

        if (strlen($event["start_time"]) == 5) $event["start_time"] .= ":00";
        if (strlen($event["end_time"]) == 5) $event["end_time"] .= ":00";

        $this->emit("update-event", $this->event);
    }

    public function productAction($product_id, $action, $quantity = 1)
    {
        $productIndex = array_search($product_id, array_column($this->event["products"], "product_id"));

        switch ($action) {
            case 'add':
                if ($productIndex !== false) {
                    $this->event["products"][$productIndex]["quantity"] += $quantity;
                } else {
                    $this->event["products"][] = [
                        "quantity" => $quantity,
                        "product_id" => $product_id,
                    ];
                }
                break;

            case 'decrease':
                if ($productIndex !== false) {
                    if ($this->event["products"][$productIndex]["quantity"] > 1) {
                        $this->event["products"][$productIndex]["quantity"] -= $quantity;
                    } else {
                        unset($this->event["products"][$productIndex]);
                    }
                }
                break;

            case 'remove':
                if ($productIndex !== false) {
                    unset($this->event["products"][$productIndex]);
                }
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
        if (!$this->event["id"] || !Event::find($this->event["id"]))
            return $this->emit("toast", "error", __("calendar-lang.event-not-found"));

        Validator::make($this->payment, [
            "amount" => "required|" . "max:" . $this->getRemaining() . "|" . $this->validations["number"],
            "notes" => "required|" . $this->validations["textarea"],
        ])->validate();

        $this->payment["amount"] = (float) $this->payment["amount"];
        $this->payment["event_id"] = $this->event["id"];
        $this->payment["user_id"] = auth()->user()->id;

        $payment = Payment::create($this->payment);
        $this->event["payments"][] = $payment;
        $this->payment = $this->initialPayment;

        $this->emit("toast", "success", "Payment added successfully");

        $this->handleCrudActions(
            "payment",
            [
                "action" => "create",
                "data" => $payment
            ]
        );

        $this->emit("update-event", $this->event);
    }

    public function newCustomer()
    {
        Validator::make($this->customer, [
            "firstname" => "required|" . $this->validations["text"],
            "lastname" => "required|" . $this->validations["text"],
            "email" => "required|" . $this->validations["email"],
            "phone" => "required|" . $this->validations["tel"],
            "address" => "required|" . $this->validations["textarea"],
            "notes" => "nullable|" . $this->validations["textarea"],
        ])->validate();

        $customer = Customer::create($this->customer);
        $this->setCustomer($customer->id);
        $this->customer = $this->initialCustomer;

        $this->Modal("newCustomer", false);

        $this->handleCrudActions(
            "customer",
            [
                "action" => "create",
                "data" => $customer
            ]
        );

        $this->event["customer_id"] = $customer->id;

        $this->emit("toast", "success", __('toast-lang.Customeraddedsuccessfully'));
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

    public function deleteEvent($id)
    {
        $this->Modal("delete", false);

        $event = Event::find($id);
        if (!$event) return;

        $event->payments()->delete();
        $event->products()->delete();

        $event->delete();

        $this->handleCrudActions(
            "event",
            [
                "action" => "delete",
                "data" => $this->event
            ]
        );

        $this->emit("toast", "success", __('calendar-lang.delete-success'));
    }
}
