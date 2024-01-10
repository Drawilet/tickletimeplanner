<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class NewsModalComponent extends Component
{
    public $events;

    public function mount()
    {
        $this->events = Event::whereBetween("date", [
            Carbon::now()->format("Y-m-d"),
            Carbon::now()->addDays(1)->format("Y-m-d")
        ])->get();
    }

    public function render()
    {
        return view('livewire.dashboard.news-modal-component');
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
        $event= $this->events->find($id);
        $remaining = $this->getTotal($event);
        foreach ($event["payments"] as $payment) {
            $remaining -= $payment["amount"];
        }
        return $remaining;
    }
}
