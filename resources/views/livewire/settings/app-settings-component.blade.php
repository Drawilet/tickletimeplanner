<div class="bg-base rounded-lg w-full max-w-lg  mx-auto shadow-xl pb-8">
    <div class="p-4">
        <h1 class="text-3xl text-center">
            App settings
        </h1>

        <div class="mb-4">
            <x-form-control>
                <x-label for="monthly_price" value="{{ __('app-settings.monthly_price') }}" />
                <x-input type="number" name="monthly_price" wire:model="data.monthly_price" />
                <x-input-error for="monthly_price" />
            </x-form-control>
        </div>

        <x-button class="btn btn-primary mt-4 w-full" wire:click="save">{{ __('app-settings.save') }}</x-button>
    </div>
</div>
