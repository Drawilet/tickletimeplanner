@isset($event['id'])
    <x-dialog-modal wire:model="modals.delete">
        <x-slot name="title">
            <h2>{{ __('calendar-lang.delete-title', [
                'name' => $event['name'],
            ]) }}
            </h2>
        </x-slot>
        <x-slot name="content">
            @if (isset($event['payments_count']) && $event['payments_count'] > 0)
                <p>{{ __('calendar-lang.payments', ['payments_count' => $event['payments_count']]) }}</p>
            @endif
        </x-slot>
        <x-slot name="footer">
            <button wire:click="Modal('delete', false)" type="button"
                class="btn w-28">{{ __('calendar-lang.cancel') }}</button>
            <button wire:click.prevent="deleteEvent('{{ $event['id'] }}')" type="button"
                class="btn btn-error w-28 ml-2">{{ __('calendar-lang.delete') }}</button>
        </x-slot>
    </x-dialog-modal>
@endisset
