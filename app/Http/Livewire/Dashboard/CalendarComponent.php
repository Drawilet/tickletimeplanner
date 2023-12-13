<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Socket\WithCrudSockets;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CalendarComponent extends LivewireCalendar
{
    use WithCrudSockets;

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

        return collect($this->events->filter(function ($event) {
            if (!in_array($event["space_id"], $this->filters["spaces"])) return false;
            return true;
        })->map(function ($event) {
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

    public $filters = [
        "spaces" => [],
    ];

    public function afterMount($extras = [])
    {
        $this->addSocketListener("space", ["useItemsKey" => false, "get" => true]);
        $this->filters["spaces"] = $this->spaces->pluck("id")->toArray();
    }

    public function toggleSpace($spaceId)
    {
        if ($spaceId == "all") {
            if (count($this->spaces) == count($this->filters['spaces']))
                $this->filters["spaces"] = [];
            else
                $this->filters["spaces"] = $this->spaces->pluck("id")->toArray();

            $this->emit("update-filters", $this->filters);
            return;
        }

        if (!in_array($spaceId, $this->filters["spaces"])) {
            $this->filters["spaces"][] = $spaceId;
        } else {
            $this->filters["spaces"] = array_diff($this->filters["spaces"], [$spaceId]);
        }
    }
}
