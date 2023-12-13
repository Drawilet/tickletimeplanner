<div>
    <style>
        .checkbox:checked {
            background: currentColor;
        }


    </style>
    <div class="dropdown md:dropdown-end">
        <div tabindex="0" role="button" class="btn m-1 px-10">Spaces</div>
        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
            <li>
                <label for="all">
                    <input id="all" type="checkbox" class="checkbox" wire:click="toggleSpace('all')"
                        @checked(count($spaces) == count($filters['spaces'])) />
                    All
                </label>
            </li>
            @foreach ($spaces as $space)
                <li>
                    <label for="{{ $space->id }}">
                        <input id="{{ $space->id }}" type="checkbox" class="checkbox"
                            @if (in_array($space->id, $filters['spaces'])) style="background: {{ $space->color }}" @endif
                            wire:click="toggleSpace('{{ $space->id }}')" @checked(in_array($space->id, $filters['spaces'])) />
                        {{ $space['name'] }}
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
</div>
