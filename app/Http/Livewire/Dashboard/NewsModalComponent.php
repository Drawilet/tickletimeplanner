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
}
