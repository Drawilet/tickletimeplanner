<?php

namespace App\Http\Livewire\Dashboard;

use Asantibanez\LivewireCalendar\LivewireCalendar;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CalendarComponent extends LivewireCalendar

{
    protected $listeners = [
        "update-events" => "updateEvents"
    ];
    public function updateEvents($events)
    {
        $this->events = collect($events);
    }

    public Collection $events;

    public function events(): Collection
    {
        return collect($this->events->map(function ($event) {
            return [
                'id' => $event["id"],
                'title' => $event["name"],
                'description' => $event["space"]["name"] . "\n" . substr($event["start_time"], 0, -3) . ' - ' . substr($event["end_time"], 0, -3),
                'date' => $event["date"],
            ];
        }));
    }

    public function onDayClick($year, $month, $day)
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);

       /*  $selectedDate = Carbon::create($year, $month, $day);
        if ($selectedDate->isPast())
            return; */

        $this->emit('Modal', 'new', true, [
            'date' => $year . '-' . $month . '-' . $day,
        ]);
    }
}
