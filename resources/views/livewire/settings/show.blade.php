<div>
    <section class="mb-3">
        <h2 class="text-xl">General</h2>
        <x-form-control>
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" name="name" wire:model="name" />
        </x-form-control>
    </section>

    <section class="mb-3">
        <h2 class="text-xl">Schedule</h2>

        <div class="join mt-3">
            <button class="join-item btn btn-neutral">S</button>
            <button class="join-item btn btn-neutral">M</button>
            <button class="join-item btn btn-neutral">T</button>
            <button class="join-item btn btn-neutral">W</button>
            <button class="join-item btn btn-neutral">T</button>
            <button class="join-item btn btn-active">F</button>
            <button class="join-item btn btn-active">S</button>
        </div>

        <x-form-control>
            <x-label for="opening" value="{{ __('Opening') }}" />
            <x-input id="opening" name="opening" wire:model="opening" type="time" />
        </x-form-control>

        <x-form-control>
            <x-label for="closing" value="{{ __('Closing') }}" />
            <x-input id="closing" name="closing" wire:model="closing" type="time" />
        </x-form-control>
    </section>

    <button class="btn btn-primary w-full">Save</button>
</div>
