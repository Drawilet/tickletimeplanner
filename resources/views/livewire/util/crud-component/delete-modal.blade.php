<x-dialog-modal wire:model="modals.delete">
    <x-slot name="title">

    </x-slot>
    <x-slot name="content">

        <h2>{{ __('show-lang.h1') }}{{ $data[$mainKey] }}" {{ __('show-lang.' . $name) }}?</h2>
    </x-slot>
    <x-slot name="footer">
        <button wire:click="Modal('delete', false)" type="button"
            class="btn btn-neutral w-28">{{ __('show-lang.cancel') }}</button>
        <button wire:click.prevent="delete()" type="button"
            class="btn btn-warning w-28 mr-2">{{ __('show-lang.delete') }}</button>

    </x-slot>
</x-dialog-modal>
