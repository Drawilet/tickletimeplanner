<x-dialog-modal wire:model="modals.save">
    <x-slot name="title">
        {{ gettype($data['id']) == 'string' ? 'Create' : 'Update' }} {{ __('show-lang.' . $name) }}
    </x-slot>

    <x-slot name="content">
        @foreach ($types as $key => $type)
            <x-form-control class="mt-2">
                <x-label for="" value="{{ __($name . '-lang.' . $key) }}" />

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

                        @case('select')
                            <select id="{{ $key }}" wire:model="data.{{ $key }}"
                                class="select select-bordered">
                                <option value=""></option>
                                @foreach ($type['options'] as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                @endforeach
                            </select>
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

                <x-input-error for="{{ $key }}" class="mt-2" />
            </x-form-control>
        @endforeach
    </x-slot>

    <x-slot name="footer">
        <button wire:click="Modal('save', false)" type="button"
            class="btn btn-neutral w-28 mr-2">{{ __('show-lang.cancel') }}</button>
        <button wire:click="save" class=" btn btn-accent w-28">{{ __('show-lang.save') }}</button>
    </x-slot>
</x-dialog-modal>
