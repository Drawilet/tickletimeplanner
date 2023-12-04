<div
    @if ($pollMillis !== null && $pollAction !== null) wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif($pollMillis !== null)
        wire:poll.{{ $pollMillis }}ms @endif>
    <div>
        <section class="flex flex-col md:flex-row justify-between mb-3">
            <div class="flex items-center mb-2 md:mb-0">
                <button type="button" title="Previous month" wire:click='goToPreviousMonth' aria-pressed="false"
                    class="btn ">
                    @component('components.icons.chevron-left')
                    @endcomponent
                </button>

                <button type="button" title="Next month" wire:click='goToNextMonth' aria-pressed="false" class="btn ">
                    @component('components.icons.chevron-right')
                    @endcomponent
                </button>

                <h2 class="text-2xl ml-2" id="title">
                    Title
                </h2>
            </div>
        </section>
    </div>

    <div class="flex">
        <div class="overflow-x-auto w-full">
            <div class="inline-block min-w-full overflow-hidden">
                <div class="w-full flex flex-row">
                    @foreach ($monthGrid->first() as $day)
                        @include($dayOfWeekView, ['day' => $day])
                    @endforeach
                </div>

                @foreach ($monthGrid as $week)
                    <div class="w-full flex flex-row">
                        @foreach ($week as $day)
                            @include($dayView, [
                                'componentId' => $componentId,
                                'day' => $day,
                                'dayInMonth' => $day->isSameMonth($startsAt),
                                'isToday' => $day->isToday(),
                                'events' => $getEventsForDay($day, $events),
                            ])
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div>
        @includeIf($afterCalendarView)
    </div>
</div>
