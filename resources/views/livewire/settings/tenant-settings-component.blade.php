<div class="w-full">
    @include('livewire.settings.tenant.form')
    @include('livewire.settings.tenant.plans')

    <x-button class="block btn btn-primary mt-4 w-full max-w-sm mx-auto"
        wire:click="save">{{ __('tenant-settings.save') }}</x-button>
</div>
