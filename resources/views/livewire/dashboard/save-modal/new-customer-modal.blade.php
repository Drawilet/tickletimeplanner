<div class="drawer drawer-end">
    <input type="checkbox" class="drawer-toggle" @checked($modals['newCustomer']) />
    <div class="drawer-side">
        <label aria-label="close sidebar" class="drawer-overlay" wire:click="Modal('newCustomer', false)"></label>
        <ul class="menu p-4 w-96 min-h-full bg-base-200 text-base-content">
            <h2 class="text-2xl text-center mb-2">{{ __('calendar-lang.Newcustomer') }}</h2>

            <x-form-control>
                <x-label for="firstname" value="{{ __('calendar-lang.Firstname') }}" />
                <x-input id="firstname" name="firstname" wire:model="customer.firstname" />
                <x-input-error for="firstname" class="mt-2" />
            </x-form-control>

            <x-form-control>
                <x-label for="lastname" value="{{ __('calendar-lang.Lastname') }}" />
                <x-input id="lastname" name="lastname" wire:model="customer.lastname" />
                <x-input-error for="lastname" class="mt-2" />
            </x-form-control>

            <x-form-control>
                <x-label for="email" value="{{ __('calendar-lang.Email') }}" />
                <x-input id="email" name="email" wire:model="customer.email" />
                <x-input-error for="email" class="mt-2" />
            </x-form-control>

            <x-form-control>
                <x-label for="phone" value="{{ __('calendar-lang.Phone') }}" />
                <x-input id="phone" name="phone" wire:model="customer.phone" />
                <x-input-error for="phone" class="mt-2" />
            </x-form-control>

            <x-form-control>
                <x-label for="address" value="{{ __('calendar-lang.Address') }}" />
                <textarea id="address" name="address" wire:model="customer.address" class="textarea textarea-bordered"></textarea>
                <x-input-error for="address" class="mt-2" />
            </x-form-control>

            <button class="btn btn-primary mt-2" wire:click='newCustomer'>{{ __('calendar-lang.Submit') }}</button>
        </ul>
    </div>
</div>
