<x-dialog-modal wire:model.defer="modals.save">
    <x-slot name="title">
        {{ gettype($data['id']) == 'string' ? __($name . '-lang.' . 'create') : __($name . '-lang.' . 'update') }}
    </x-slot>

    <x-slot name="content">
        @foreach ($types as $key => $type)
            <x-form-control class="mt-2">
                <x-label for="" value="{{ __($name . '-lang.' . $key) }}" />

                @isset($type['component'])
                    @livewire($type['component'], key($key))
                @else
                    @switch($type["type"])
                        @case('textarea')
                            <textarea id="{{ $key }}" wire:model.defer="data.{{ $key }}" class="textarea textarea-bordered"
                                @foreach ($type as $key => $value)
                                    @if ($key != 'type')
                                     {{ $key }}="{{ $value }}"
                                       @endif @endforeach></textarea>
                        @break

                        @case('select')
                            <select id="{{ $key }}" wire:model.defer="data.{{ $key }}"
                                class="select select-bordered">
                                <option value=""></option>
                                @foreach ($type['options'] as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                @endforeach
                            </select>
                        @break

                        @case('file')
                            <input id="{{ $key }}" wire:model.defer="files.{{ $key }}" type="file"
                                class="file-input file-input-bordered"
                                @foreach ($type as $key => $value)
                            @if ($key != 'type')
                      {{ $key }}="{{ $this->parseValue($value) }}"
                     @endif @endforeach>
                        @break

                        @default
                            <x-input id="{{ $key }}" wire:model.defer="data.{{ $key }}"
                                type="{{ $type['type'] }}" />
                    @endswitch
                @endisset
                <x-input-error for="{{ $key }}" class="mt-2" />
            </x-form-control>
        @endforeach
    </x-slot>

    <x-slot name="footer">
        <button wire:click="Modal('save', false)" type="button"
            class="btn w-28 mr-2">{{ __('show-lang.cancel') }}</button>
        <button class="btn btn-primary px-8" wire:click="save" wire:loading.attr="disabled">
            <span wire:loading wire:target="save">
                {{ __('auth.cargando') }}...
            </span>
            <span wire:loading.remove wire:target="save">
                {{ __('calendar-lang.Save') }}
            </span>
        </button>
    </x-slot>
</x-dialog-modal>
