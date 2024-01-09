<div class="overflow-x-auto">
    @include('livewire.util.crud-component.save-modal')

    @include('livewire.util.crud-component.delete-modal')

    {{-- <x-dialog-modal wire:model="modals.error">
        <x-slot name="title">
            Unable to delete this {{ $name }}.
    </x-slot>
    <x-slot name="content">
        <h2>There are {{ $count }} product(s) linked to this {{ $name }}.</h2>
    </x-slot>
    <x-slot name="footer">
        <button wire:click="Modal('error', false)" type="button" class="btn btn-accent w-28">Close</button>


    </x-slot>
    </x-dialog-modal> --}}

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-base-100 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="mockup-browser border border-base-300">
                <div class="mockup-browser-toolbar flex items-center">
                    <input class="input py-5" wire:model="filter.search" type="text"
                        placeholder="{{ __($name . '-lang.' . "search") }}">
                    <button wire:click="Modal('save', true)"
                        class=" btn btn-ghost bg-base-100 hover:bg-base-300 hover:text-blue-50 py-2 px-4 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>

            @include('livewire.util.crud-component.table')
        </div>
    </div>

    @component('components.util.crud-socket-scripts', ['socketListeners' => $socketListeners])
    @endcomponent
</div>
