<div @if ($eventClickEnabled) wire:click.stop="onEventClick('{{ $event['id'] }}')" @endif
    class="bg-neutral rounded-lg border py-2 px-3 shadow-md cursor-pointer text-black"
    style="background-color: {{ $event['color'] }}">

    <p class="text-sm font-medium">
        {{ $event['title'] }} <sup>({{ $event['location'] }})</sup>
    </p>
    <p class="mt-2 text-xs">
        {{ $event['description'] ?? 'No description' }}
    </p>

</div>
