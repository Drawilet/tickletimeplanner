<div @if ($pollMillis !== null && $pollAction !== null) wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif($pollMillis !== null)
        wire:poll.{{ $pollMillis }}ms @endif
    class="h-full w-full flex gap-2">
    <div class="h-full ">
        <div class="flex flex-col h-full">
            <div class="w-full flex flex-row">
                @foreach ($monthGrid->first() as $day)
                    @include($dayOfWeekView, ['day' => $day])
                @endforeach
            </div>

            @foreach ($monthGrid as $week)
                <div class="w-full flex flex-row flex-1">
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

    <div class="h-full flex flex-col w-full gap-2 flex-1 px-1">
        <div>
            <h2 class="text-2xl ml-2 text-center" id="title">
                {{ trans('month-lang.' . strtolower($monthGrid[2]->first()->format('F'))) }}
                {{ $monthGrid[2]->first()->format('Y') }}
            </h2>
        </div>

        <div class="flex justify-between w-ful">
            <button type="button" title="{{ __('month-lang.Previousmonth') }}" wire:click='goToPreviousMonth'
                aria-pressed="false" class="btn ">
                @component('components.icons.chevron-left')
                @endcomponent
            </button>

            <button type="button" title="{{ __('month-lang.CurrentMonth') }}" wire:click='goToCurrentMonth'
                aria-pressed="false" class="btn">
                @component('components.icons.calendar')
                @endcomponent
            </button>

            <button type="button" title="{{ __('month-lang.Nextmonth') }}" wire:click='goToNextMonth'
                aria-pressed="false" class="btn ">
                @component('components.icons.chevron-right')
                @endcomponent
            </button>
        </div>

        <div class="max-h-96 overflow-y-scroll">
            @foreach ($events as $event)
                <button class="cursor-pointer flex gap-2 items-center"
                    wire:click.stop="onEventClick('{{ $event['id'] }}')">

                    <span class="size-3 bg-base-300 block rounded-full"
                        style="background-color: {{ $event['isDraft'] ? '' : $event['color'] }}">
                    </span>

                    {{ $event['title'] }}
                </button>
            @endforeach
            </d>

        </div>

    </div>
