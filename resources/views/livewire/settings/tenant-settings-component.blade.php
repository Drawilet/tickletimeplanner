<div class="bg-base rounded-lg w-full max-w-lg  mx-auto shadow-xl pb-8">
    <div class="w-full h-[250px]">
        <div class="mx-auto w-full h-[250px] bg-base-300 rounded-md overflow-hidden relative">
            @if ($data['background_image'])
                <img src="{{ gettype($data['background_image']) == 'object' ? $data['background_image']->temporaryUrl() : $data['background_image'] }}"
                    class="w-full h-full object-cover">
            @endif

            <label for="background_image"
                class="w-full h-5/6 bottom-0 bg-base-100 absolute flex items-center justify-center opacity-0 hover:opacity-75 transition duration-150 ease-in-out">
                <x-icons.arrow-up-tray class="w-16" />
            </label>

            <input wire:model="data.background_image" type="file" id="background_image" class="hidden"
                accept="image/*">
        </div>
    </div>

    <div class="flex flex-col items-center -mt-20">
        <div class="mx-auto h-32 w-32 bg-base-300 rounded-full overflow-hidden relative">
            @if ($data['profile_image'])
                <img src="{{ gettype($data['profile_image']) == 'object' ? $data['profile_image']->temporaryUrl() : $data['profile_image'] }}"
                    alt="" class="w-32 h-32 object-cover rounded-full mx-auto">
            @endif

            <label for="profile_image"
                class="w-full bottom-0 bg-base-100 absolute flex items-center justify-center opacity-0 hover:opacity-75 transition duration-150 ease-in-out">
                <x-icons.arrow-up-tray class="w-10" />
            </label>

            <input wire:model="data.profile_image" type="file" id="profile_image" class="hidden" accept="image/*">
        </div>
    </div>
    <x-input-error for="background_image" />
    <x-input-error for="profile_image" />

    <div class="p-4">
        <div class="mb-4">
            <x-form-control>
                <x-label for="name" value="{{ __('tenant-settings.Name') }}" />
                <x-input id="name" name="name" wire:model="data.name" />
                <x-input-error for="name" />
            </x-form-control>

            <x-form-control>
                <x-label for="description" value="{{ __('tenant-settings.Description') }}" />
                <textarea class="textarea textarea-bordered" name="description" id="description" rows="4"
                    wire:model="data.description"></textarea>
                <x-input-error for="description" />
            </x-form-control>

            <x-form-control>
                <x-label for="phone" value="{{ __('tenant-settings.Phone') }}" />
                <x-input id="phone" name="phone" wire:model="data.phone" type="tel" />
                <x-input-error for="phone" />
            </x-form-control>

            <x-form-control>
                <x-label for="email" value="{{ __('tenant-settings.Email') }}" />
                <x-input id="email" name="email" wire:model="data.email" type="email" />
                <x-input-error for="email" />
            </x-form-control>

        </div>
        <x-button class="btn btn-primary mt-4 w-full" wire:click="save">{{ __('tenant-settings.save') }}</x-button>
    </div>
</div>
