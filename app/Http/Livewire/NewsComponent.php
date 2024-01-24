<?php

namespace App\Http\Livewire;

use App\Http\Socket\WithCrudSockets;
use App\Models\Event;
use App\Models\EventProduct;
use Carbon\Carbon;
use Livewire\Component;

class NewsComponent extends Component
{
    use WithCrudSockets;
    protected $listeners = [
        "socket" => "handleSocket",
        "toggleNews" => "toggleNews"
    ];

    public $modals = [
        "news" => false,
    ];

    public $events, $products;

    public function mount()
    {
        $this->addSocketListener("event", ["useItemsKey" => false, "get" => false, "afterUpdate" => "getProducts"]);
        $this->addSocketListener("product", ["useItemsKey" => false, "get" => true]);

        $this->events = Event::whereBetween("date", [
            Carbon::now()->format("Y-m-d"),
            Carbon::now()->addDays(1)->format("Y-m-d")
        ])->get();
    }

    public function render()
    {
        return view('livewire.news-component');
    }

    public function getTotal($event)
    {
        $total = $event["price"] ?? 0;
        foreach ($event["products"] as $data) {
            $total += $this->products->find($data["product_id"])->price * $data["quantity"];
        }
        return $total;
    }

    public function getRemaining($id)
    {
        $event = $this->events->find($id);
        $remaining = $this->getTotal($event);
        foreach ($event["payments"] as $payment) {
            $remaining -= $payment["amount"];
        }
        return $remaining;
    }

    public function getProducts()
    {
        if ($this->events->isEmpty()) return;
        if ($this->products->isEmpty()) return;

        $event = $this->events->last();
        if (!$event)
            return;

        $products = EventProduct::where("event_id", $event->id)->get();
        $event->products = $products;

        $this->events->pop();
        $this->events->push($event);
    }


    public function toggleNews($value)
    {
        $this->modals["news"] = $value;
    }


    public function openEvent($id)
    {
        $this->toggleNews(false);
        $this->emit("Modal", "save", true, ["id" => $id]);
    }
}
