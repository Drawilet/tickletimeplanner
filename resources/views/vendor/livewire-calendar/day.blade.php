<div ondragenter="onLivewireCalendarEventDragEnter(event, '{{ $componentId }}', '{{ $day }}', '{{ $dragAndDropClasses }}');"
    ondragleave="onLivewireCalendarEventDragLeave(event, '{{ $componentId }}', '{{ $day }}', '{{ $dragAndDropClasses }}');"
    ondragover="onLivewireCalendarEventDragOver(event);"
    ondrop="onLivewireCalendarEventDrop(event, '{{ $componentId }}', '{{ $day }}', {{ $day->year }}, {{ $day->month }}, {{ $day->day }}, '{{ $dragAndDropClasses }}');"
    class="flex-1 border border-base-100 -mt-px -ml-px">

    {{-- Wrapper for Drag and Drop --}}
    <div class="w-full h-full" id="{{ $componentId }}-{{ $day }}">

        <div @if ($dayClickEnabled && ($isToday || $day->isFuture())) wire:click="onDayClick({{ $day->year }}, {{ $day->month }}, {{ $day->day }})" @endif
            class="w-full h-full p-2 {{ $dayInMonth ? ($isToday ? 'bg-primary' : 'bg-base-300') : 'bg-base-200' }} flex flex-col {{ $isToday || $day->isFuture() ? 'cursor-pointer' : 'cursor-not-allowed' }}">
            {{-- Number of Day --}}
            <div class="flex items-center">
                <p class="text-sm {{ $dayInMonth ? ' font-medium ' : '' }}">
                    {{ $day->format('j') }}
                </p>
                <p class="text-xs text-gray-600 ml-4">
                    @if ($events->isNotEmpty())
                        {{ $events->count() }} {{ Str::plural(__('calendar-lang.event'), $events->count()) }}
                    @endif
                </p>
            </div>

            {{-- Events --}}
            <div class="p-2 flex-1 overflow-y-scroll max-h-16">
                <div class="grid grid-cols-1
                grid-flow-row gap-1">
                    @foreach ($events as $event)
                        <div @if ($dragAndDropEnabled) draggable="true" @endif
                            ondragstart="onLivewireCalendarEventDragStart(event, '{{ $event['id'] }}')">
                            @include($eventView, [
                                'event' => $event,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
