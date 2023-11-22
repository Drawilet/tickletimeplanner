<div class="overflow-x-auto">
    <x-dialog-modal wire:model="modals.save">
        <x-slot name="title">

        </x-slot>
        <x-slot name="content">

            @foreach ($initialData as $key => $value)
                @if ($key != 'id')
                    <x-form-control class="mt-4">
                        <x-label>{{ ucfirst($key) }}</x-label>
                        <x-input id="{{ $key }}" wire:model="data.{{ $key }}"
                            class="{{ isset($files[$key]) ? 'file-input' : '' }}"
                            type="{{ $this->getInputType($key, $value) }}" />
                        <x-input-error for="data.{{ $key }}" class="mt-2" />
                    </x-form-control>
                @endif
            @endforeach

        </x-slot>
        <x-slot name="footer">
            <button wire:click="Modal('save', false)" type="button" class="btn btn-neutral w-28 mr-2">Cancel</button>
            <button wire:click="save" class=" btn btn-accent w-28">Save</button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="modals.delete">
        <x-slot name="title">

        </x-slot>
        <x-slot name="content">

            <h2>¿Are you sure you want do delete "{{ $data[$primaryKey] }}" {{ $name }}?</h2>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="Modal('delete', false)" type="button" class="btn btn-neutral w-28">Cancel</button>
            <button wire:click.prevent="delete()" type="button" class="btn btn-warning w-28 mr-2">Delete</button>

        </x-slot>
    </x-dialog-modal>

    {{--  <x-dialog-modal wire:model="modals.error">
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

    <div class="max-w-7xl mx-auto sm:px6 lg:px-8">
        <div class="bg-base-100 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="mockup-browser border border-base-300">
                <div class="mockup-browser-toolbar flex items-center">
                    <input class="input border border-base-300" wire:model="filter.search" type="text" placeholder="Search">
                    <button wire:click="Modal('save', true)"
                        class=" btn btn-ghost bg-base-100 hover:bg-base-300 text-black hover:text-blue-50 py-2 px-4 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        @foreach ($keys as $key)
                            <th class="capitalize">{{ $key }}</th>
                        @endforeach
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($showingItems as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            @foreach ($keys as $key)
                                <td class="  ">
                                    @if (isset($files[$key]))
                                        <img src="{{ $item[$key] }}" alt="" class="w-10 h-10 rounded-full">
                                    @else
                                        {{ $item[$key] }}
                                    @endif
                                </td>
                            @endforeach

                            <td>
                                <button wire:click="Modal('save', true, '{{ $item->id }}')">
                                    @component('components.icons.pencil-square')
                                    @endcomponent
                                </button>
                                <button wire:click="Modal('delete', true, '{{ $item->id }}')">
                                    @component('components.icons.trash')
                                    @endcomponent
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script type="module">
        Echo.channel("global").listen('{{ $Name }}Event', (e) => {
            window.livewire.emit('socket', e)
        })
    </script>
</div>
