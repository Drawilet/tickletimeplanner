<div class="flex flex-col">
    <div class="join">
        @foreach ($days as $day)
            <button wire:click='toggleDay("{{ $day }}")'
                class="capitalize join-item btn
                {{ $selectedDay == $day ? 'btn-neutral' : 'btn-active' }}
                {{ isset($data['schedule'][$day]['opening']) &&
                $data['schedule'][$day]['opening'] != '' &&
                isset($data['schedule'][$day]['closing']) &&
                $data['schedule'][$day]['closing'] != ''
                    ? 'btn-primary'
                    : '' }} ">
                {{ substr(__('days-lang.' . $day), 0, 1) }}
            </button>
        @endforeach
    </div>

    @isset($selectedDay)
        <x-form-control>
            <x-label for="opening" value="{{ __('calendar-lang.Opening') }}" />
            <x-input id="opening" name="opening" wire:model="data.schedule.{{ $selectedDay }}.opening"
                wire:change='handleScheduleChange' type="time" />
        </x-form-control>

        <x-form-control>
            <x-label for="closing" value="{{ __('calendar-lang.Closing') }}" />
            <x-input id="closing" name="closing" wire:model="data.schedule.{{ $selectedDay }}.closing"
                wire:change='handleScheduleChange' type="time" />
        </x-form-control>

        <div class="mt-2 flex gap-2 ">
            <x-button class="btn-primary w-1/2" wire:click="copyDay">
                @component('components.icons.clipboard')
                @endcomponent
            </x-button>
            <x-button class="btn-error w-1/2" wire:click="removeDay">
                @component('components.icons.trash')
                @endcomponent
            </x-button>
        </div>
    @endisset

</div>
