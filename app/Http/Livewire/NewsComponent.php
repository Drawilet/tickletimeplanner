<?php

namespace App\Http\Livewire;

use App\Http\Traits\WithCrudActions;
use App\Models\Event;
use App\Models\EventProduct;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;

class NewsComponent extends Component
{
    use WithCrudActions;
    protected $listeners = [
        "toggleNews" => "toggleNews"
    ];

    public $modals = [
        "news" => false,
    ];

    public $events, $filteredEvents, $products,$offON;

    public function mount()
    {
        $this->addCrud(Event::class, ["useItemsKey" => false, "get" => false, "afterUpdate" => "getProducts"]);
        $this->addCrud(Product::class, ["useItemsKey" => false, "get" => true]);
    
        $this->events = Event::whereBetween("date", [
            Carbon::now()->format("Y-m-d"),
            Carbon::now()->addDays(1)->format("Y-m-d")
        ])->get();
    
        if ($this->events->isEmpty()) {
            $this->emit('toggleNews', false);
        }
    }

    public function render()
{
    $this->filteredEvents =
        $this->events->filter(function ($event) {
            return count($event->payments) > 0;
        });

    if ($this->filteredEvents->isEmpty()) {
        $this->modals["news"] = false;
        $this->offON = false;
    }else{
        $this->offON = true;
    }

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
