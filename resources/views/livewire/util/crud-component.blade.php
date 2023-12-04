<div class="overflow-x-auto">
    <x-dialog-modal wire:model="modals.save">
        <x-slot name="title">
            {{ gettype($data['id']) == 'string' ? 'Create' : 'Update' }} {{ $name }}
        </x-slot>

        <x-slot name="content">
            @foreach ($types as $key => $type)
                <x-form-control class="mt-2">
                    <x-label for="" value="{{ __(ucFirst($key)) }}" />

                    @if (isset($type['component']))
                        @livewire($type['component'])
                    @else
                        @switch($type["type"])
                            @case('textarea')
                                <textarea id="{{ $key }}" wire:model="data.{{ $key }}" class="textarea textarea-bordered"
                                    @foreach ($type as $key => $value)
                                        @if ($key != 'type')
                                         {{ $key }}="{{ $value }}"
                                           @endif @endforeach></textarea>
                            @break

                            @case('file')
                                <input id="{{ $key }}" wire:model="files.{{ $key }}" type="file"
                                    class="file-input file-input-bordered"
                                    @foreach ($type as $key => $value)
                                       @if ($key != 'type')
                                            {{ $key }}="{{ $this->parseValue($value) }}"
                                        @endif @endforeach>
                            @break

                            @default
                                <x-input id="{{ $key }}" wire:model="data.{{ $key }}"
                                    type="{{ $type['type'] }}" />
                        @endswitch
                    @endif

                </x-form-control>
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

            <h2>¿Are you sure you want do delete "{{ $data[$mainKey] }}" {{ $name }}?</h2>
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-base-100 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="mockup-browser border border-base-300">
                <div class="mockup-browser-toolbar flex items-center">
                    <input class="input py-5" wire:model="filter.search" type="text"
                        placeholder="Search {{ $name }}s">
                    <button wire:click="Modal('save', true)"
                        class=" btn btn-ghost bg-base-100 hover:bg-base-300 hover:text-blue-50 py-2 px-4 ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if ($items->isNotEmpty())
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                @foreach ($keys as $key)
                                    <th class="capitalize {{ $mainKey == $key ? '' : '' }}">{{ $key }}</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($showingItems as $item)
                                <tr class="hover">
                                    <td>{{ $item->id }}</td>

                                    @foreach ($types as $key => $type)
                                        @isset($type['hidden'])
                                            @continue
                                        @endisset

                                        <td>
                                            @if (isset($type['parser']))
                                                @php
                                                    $value = $type['parser']($item[$key]);
                                                @endphp
                                                @if (gettype($value) == 'string')
                                                    {{ $value }}
                                                @else
                                                    @foreach ($value as $v)
                                                        {{ $v }} <br>
                                                    @endforeach
                                                @endif
                                            @else
                                                @switch($type["type"])
                                                    @case('file')
                                                        @if (gettype($item[$key]) == 'string')
                                                            <img src="{{ $item[$key] }}" alt=""
                                                                class="w-10 h-10 rounded-full">
                                                        @else
                                                            <button class="btn btn-ghost"
                                                                onclick="{{ $key }}{{ $item['id'] }}Modal.showModal()">
                                                                @component('components.icons.arrows-pointing-out')
                                                                @endcomponent
                                                            </button>
                                                            <dialog id="{{ $key }}{{ $item['id'] }}Modal"
                                                                class="modal modal-bottom md:modal-middle">
                                                                <div class="modal-box md:w-11/12 md:max-w-5xl">
                                                                    <h3 class="font-bold text-lg mb-2">{{ $Name }}
                                                                        {{ $key }}</h3>
                                                                    <div class="flex flex-wrap gap-2">
                                                                        @foreach ($item[$key] as $file)
                                                                            <img src="{{ $file['url'] }}" alt=""
                                                                                class="h-36  rounded border border-base-300">
                                                                        @endforeach
                                                                    </div>

                                                                    <div class="modal-action">
                                                                        <form method="dialog">
                                                                            <button class="btn">Close</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <form method="dialog" class="modal-backdrop">
                                                                    <button>close</button>
                                                                </form>
                                                            </dialog>
                                                        @endif
                                                    @break

                                                    @case('textarea')
                                                        <span>{{ \Illuminate\Support\Str::limit($item[$key], 50) }}</span>
                                                    @break

                                                    @default
                                                        {{ $item[$key] }}
                                                    @break
                                                @endswitch
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
                @else
                    <div class="flex flex-col items-center justify-center mt-5">
                        <h2 class="text-2xl opacity-90">No {{ $name }}s found</h2>
                        <button wire:click="Modal('save', true)" class=" btn btn-primary py-2 px-4 mt-4">
                            @component('components.icons.plus')
                            @endcomponent
                            Create {{ $name }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @component('components.util.crud-socket-scripts', ['socketListeners' => $socketListeners])
    @endcomponent
</div>
