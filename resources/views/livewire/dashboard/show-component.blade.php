<div>
    <x-dialog-modal wire:model="modals.new">
        <x-slot name="title">
            <h3 class="text-2xl">New Event</h3>
        </x-slot>

        <x-slot name="content">
            <section>
                <x-form-control>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" name="name" wire:model="data.name" />
                    <x-input-error for="data.name" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="space_id" value="{{ __('Space') }}" />
                    <select class="select select-bordered" wire:model="data.space_id">
                        <option value="{{ null }}">Pick one</option>
                        @foreach ($spaces as $space)
                            <option value="{{ $space->id }}">{{ $space->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="data.space_id" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="customer_id" value="{{ __('Customer') }}" />
                    <select class="select select-bordered" wire:model="data.customer_id">
                        <option value="{{ null }}">Pick one</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->firstname }}
                                {{ $customer->lastname }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="data.customer_id" class="mt-2" />
                </x-form-control>

                <div class="divider"></div>

                <x-form-control>
                    <x-label for="date" value="{{ __('Date') }}" />
                    <x-input id="date" name="date" type="date" wire:model="data.date" />
                    <x-input-error for="data.date" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="start_time" value="{{ __('Start time') }}" />
                    <x-input id="start_time" name="start_time" type="time" wire:model="data.start_time" />
                    <x-input-error for="data.start_time" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="end_time" value="{{ __('End time') }}" />
                    <x-input id="end_time" name="end_time" type="time" wire:model="data.end_time" />
                    <x-input-error for="data.end_time" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="price" value="{{ __('Price') }}" />
                    <x-input id="price" name="price" type="number" wire:model="data.price" />
                    <x-input-error for="data.price" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="notes" value="{{ __('Notes') }}" />
                    <textarea id="notes" name="notes" class="textarea textarea-bordered" wire:model="data.notes"></textarea>
                    <x-input-error for="data.notes" class="mt-2" />
                </x-form-control>
            </section>
        </x-slot>

        <x-slot name="footer">
            <x-button class="ml-4" wire:click="newEvent">
                {{ __('Add') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @livewire('dashboard.calendar-component', [
        'events' => $filteredEvents,
        'dragAndDropEnabled' => false,
    ])

    @component('components.util.crud-socket-scripts', ['socketListeners' => $socketListeners])
    @endcomponent
</div>
