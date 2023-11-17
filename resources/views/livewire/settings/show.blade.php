<div class="max-w-lg mx-auto">
    <section class="mb-3">
        <h2 class="text-xl">General</h2>
        <x-form-control>
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" name="name" wire:model="data.name" />
            <x-input-error for="data.name" class="mt-2" />
        </x-form-control>
    </section>

    <section class="mb-3">
        <h2 class="text-xl">Schedule</h2>

        <div class="join mt-3">
            @foreach ($days as $day)
                <button wire:click='toggleDay("{{ $day }}")'
                    class="join-item btn {{ in_array($day, $data['schedule']) ? 'btn-neutral' : 'btn-active' }}">{{ substr($day, 0, 1) }}</button>
            @endforeach
        </div>

        <x-form-control>
            <x-label for="opening" value="{{ __('Opening') }}" />
            <x-input id="opening" name="opening" wire:model="data.opening" type="time" />
            <x-input-error for="data.opening" class="mt-2" />
        </x-form-control>

        <x-form-control>
            <x-label for="closing" value="{{ __('Closing') }}" />
            <x-input id="closing" name="closing" wire:model="data.closing" type="time" />
            <x-input-error for="data.closing" class="mt-2" />
        </x-form-control>
    </section>

    <button class="btn btn-primary w-full" wire:click="save">Save</button>
    <x-action-message class="mt-3" on="saved">
        {{ __('Saved.') }}
    </x-action-message>
</div>
