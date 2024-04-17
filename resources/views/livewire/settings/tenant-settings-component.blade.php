<div class="w-full relative">
    @include('livewire.settings.tenant.form')
    @include('livewire.settings.tenant.plans')
    @include('livewire.settings.tenant.transactions')

    <x-button class="block btn btn-primary mt-4 w-full max-w-sm mx-auto"
        wire:click="save">{{ __('tenant-settings.save') }}</x-button>
</div>
