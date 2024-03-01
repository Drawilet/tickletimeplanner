<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Traits\WithCrudActions;
use App\Models\Event;
use App\Models\Space;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CalendarComponent extends LivewireCalendar
{
    use WithCrudActions;
    protected $listeners = ['update-event' => 'updateEvent'];

    public $currentEvents, $currentDate;

    public function getCurrentEvents()
    {
        $this->currentEvents = Event::where('date', '>=', $this->gridStartsAt)
            ->where('date', '<=', $this->gridEndsAt)
            ->when(count($this->filters['spaces']) > 0, function ($query) {
                return $query->whereIn('space_id', $this->filters['spaces']);
            })
            ->get();
    }

    public function updateEvent($event)
    {
        $this->currentEvents = $this->currentEvents->map(function ($e) use ($event) {
            if ($e->id == $event['id']) {
                $e = Event::find($event['id']);
            }
            return $e;
        });
    }

    public function events(): Collection
    {
        if ($this->currentDate != $this->gridStartsAt) {
            $this->currentDate = $this->gridStartsAt;
            $this->getCurrentEvents();
        }

        return collect(
            $this->currentEvents
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->name,
                        'location' => $event->space->name,
                        'description' => Carbon::createFromFormat('H:i:s', $event->start_time)->format('g:i A') . ' - ' . Carbon::createFromFormat('H:i:s', $event->end_time)->format('g:i A'),
                        'date' => $event->date,
                        'color' => $event->space->color,
                        'start_time' => $event->start_time,
                        'isDraft' => isset ($event->payments) && count($event->payments) == 0,
                    ];
                })
                ->sortBy('start_time')
                ->values()
                ->toArray(),
        );
    }

    public function onDayClick($year, $month, $day)
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);

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
        'spaces' => [],
    ];

    public function afterMount($extras = [])
    {
        $this->addCrud(Space::class, ['useItemsKey' => false, 'get' => true]);

        $this->filters['spaces'] = $this->spaces->pluck('id')->toArray();
    }

    public function toggleSpace($spaceId)
    {
        if ($spaceId == 'all') {
            if (count($this->spaces) == count($this->filters['spaces'])) {
                $this->filters['spaces'] = [];
            } else {
                $this->filters['spaces'] = $this->spaces->pluck('id')->toArray();
            }

            $this->emit('update-filters', $this->filters);
            return;
        }

        if (!in_array($spaceId, $this->filters['spaces'])) {
            $this->filters['spaces'][] = $spaceId;
        } else {
            $this->filters['spaces'] = array_diff($this->filters['spaces'], [$spaceId]);
        }
    }
}
