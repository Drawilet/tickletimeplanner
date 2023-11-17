<div class="">
    <div class="max-w-xs p-2 rounded shadow-lg">
        <div class="tabs tabs-lifted">
            @foreach (['table', 'calendar'] as $mode)
                <a class="capitalize tab {{ $mode == $filter['display_mode'] ? 'tab-active' : '' }}"
                    wire:click='changeDisplayMode("{{ $mode }}")'>{{ $mode }}</a>
            @endforeach
        </div>

        <x-input id="search" name="search" wire:model="filter.search" placeholder="Search event" />

        <span class="text-sm ml-2 mt-2 block">4 events found</span>

    </div>
</div>
