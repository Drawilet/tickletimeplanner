<div x-data="{
    links: [{ url: '', icon: 'default-link' }],
    addLink() {
        this.links.push({ url: '', icon: 'default-link' })
    },
    isDefault(cadena, substrings, cantidad) {
        // Verifica que la cadena no contenga la cantidad especificada de substrings
        return substrings.every(substring => cadena.indexOf(substring) === -1) && substrings.length === cantidad;
    }
}">
    <div class="w-full flex justify-center">
        <div class="bg-base rounded-lg w-1/2 shadow-xl pb-8">
            <div class="w-full h-[250px]">
                <div class="mx-auto w-full h-[250px] bg-base-300 rounded-md overflow-hidden relative">
                    @if ($image_background)
                        <img src="{{ $image_background->temporaryUrl() }}"
                            class="mx-auto overflow-hidden rounded-md w-1/2">
                    @else
                        <label for="image-background"
                            class="w-full h-[250px] bottom-0  bg-base-100 absolute flex items-center justify-center opacity-0 hover:opacity-75 transition duration-150 ease-in-out">
                            <img src="/iconphoto.svg" alt="" class="mx-auto overflow-hidden rounded-md w-1/2">
                            <input wire:model="image_background" type="file" id="image-background" class="hidden">
                    @endif
                </div>
            </div>
            <div class="flex flex-col items-center -mt-20">
                <div class="mx-auto h-32 w-32 bg-base-300 rounded-full overflow-hidden relative">
                    @if ($image_profile)
                        <img src="{{ $image_profile->temporaryUrl() }}" alt=""
                            class="mx-auto overflow-hidden rounded-full max-h-32">
                    @else
                        <label for="image-profile"
                            class="w-32 h-12 bottom-0  bg-base-100 absolute flex items-center justify-center opacity-0 hover:opacity-75 transition duration-150 ease-in-out">
                            <img src="/iconphoto.svg">
                            <input wire:model="image_profile" type="file" id="image-profile" class="hidden">
                    @endif
                </div>
                <div class="flex items-center space-x-2 mt-2">
                    <p class="text-2xl">name: {{ $name }}</p>
                    <p class="text-2xl">lastname: {{ $lastname }}</p>
                </div>
                <p class="text-gray-700">Your bio: {{ $bio }}</p>
                <p class="text-sm text-gray-500">where are you?: {{ $location }}</p>
                <x-form-control>
                    <x-labell for="name">Name</x-labell>
                    <x-input id="name" name="name" wire:model="name" />
                    <x-labell for="lastname">Last name</x-labell>
                    <x-input id="lastname" name="lastname" wire:model="lastname" />
                    <x-labell for="bio">Bio</x-labell>
                    <x-input id="bio" name="bio" wire:model="bio" />
                    <x-labell for="location">Location</x-labell>
                    <x-input id="location" name="location" wire:model="location" />
                </x-form-control>
                <template x-for="link in links">
                    <div class="flex space-x-2 items-center">
                        <div x-show="link.url.includes('facebook')">
                            <x-icons.facebook />
                        </div>
                        <div x-show="link.url.includes('instagram')">
                            <x-icons.instagram />
                        </div>
                        <div x-show="link.url.includes('tiktok')">
                            <x-icons.tiktok />
                        </div>
                        {{-- <div x-show="link.url.includes('twitter')">
                                <x-icons.twitter />
                            </div> --}}
                        <div x-show="link.url.includes('linkedin')">
                            <x-icons.linkedin />
                        </div>
                        <div x-show="isDefault(link.url, ['facebook','instagram','tiktok', 'twitter', 'linkedin'], 5)">
                            <x-icons.default-link />
                        </div>
                        <input x-model="link.url" type="text" placeholder="Link here"
                            class="input input-bordered input-warning w-full max-w-xs" />
                        <x-button x-on:click="addLink">Add</x-button>
                    </div>
                </template>
            </div>
            <button class="btn btn-success" wire:click="getValues">Save</button>
            <button class="btn btn-active btn-ghost">Cancel</button>
        </div>
    </div>
</div>
