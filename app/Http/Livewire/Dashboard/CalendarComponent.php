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
                "location" => $event["space"]["name"],
                'description' => substr($event["start_time"], 0, -3) . ' - ' . substr($event["end_time"], 0, -3),
                'date' => $event["date"],
                'color' => $event["space"]["color"],
                "start_time" => $event["start_time"],
            ];
        })->sortBy('start_time')->values()->toArray());
    }

    public function onDayClick($year, $month, $day)
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);

        /*  $selectedDate = Carbon::create($year, $month, $day);
        if ($selectedDate->isPast())
            return; */

        $this->emit('Modal', 'save', true, [
            'date' => $year . '-' . $month . '-' . $day,
        ]);
    }

    public function onEventClick($eventId)
    {
        $this->emit('Modal', 'save', true, [
            'id' => $eventId,
        ]);
    }
}
