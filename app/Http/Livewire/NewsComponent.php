<?php

namespace App\Http\Livewire;

use App\Http\Socket\WithCrudSockets;
use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class NewsComponent extends Component
{
    use WithCrudSockets;
    protected $listeners = [
        "socket" => "handleSocket",
    ];

    public $events;

    public function mount()
    {
        $this->addSocketListener("event", ["useItemsKey" => false, "get" => false]);

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
}
