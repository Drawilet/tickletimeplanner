<div class="flex flex-col md:flex-row">
    <div class="md:max-w-xs p-2 rounded shadow-lg">
        <div class="tabs tabs-lifted">
            @foreach (['table', 'calendar'] as $mode)
                <a class="capitalize tab {{ $mode == $filter['display_mode'] ? 'tab-active' : '' }}"
                    wire:click='changeDisplayMode("{{ $mode }}")'>{{ $mode }}</a>
            @endforeach
        </div>

        <x-input id="search" name="search" wire:model="filter.search" placeholder="Search event" />

        <a href="{{ route('events.new') }}" class="btn btn-neutral w-full mt-2">
            <x-icons.plus></x-icons.plus> New
        </a>
    </div>

    <div class="mt-3 md:mt-0 md:ml-5">
        @if ($filter['display_mode'] == 'table')
            @include('livewire.Event.show-component.table-component')
        @else
            @include('livewire.Event.show-component.calendar-component')
        @endif
    </div>
</div>
