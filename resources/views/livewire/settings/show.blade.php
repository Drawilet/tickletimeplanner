<div
x-data="{
    links: [{ url: '', icon: 'default-link' }],
    addLink() {
        this.links.push({ url: '', icon: 'default-link' })
    },
    isDefault(cadena, substrings, cantidad) {
        // Verifica que la cadena no contenga la cantidad especificada de substrings
        return substrings.every(substring => cadena.indexOf(substring) === -1) && substrings.length === cantidad;
    }
}
">
    <div class="w-full flex justify-center">
        <div class="bg-base rounded-lg w-1/2 shadow-xl pb-8">
            <div class="w-full h-[250px]">
                <img src="" alt="" class="mx-auto overflow-hidden rounded-full max-h-32">
                <input wire:model="" type="file" id="" class="hidden">
            </div>
            <div class="flex flex-col items-center -mt-20">
                <div class="mx-auto h-32 w-32 bg-base-300 rounded-full overflow-hidden relative">
                    <img src="" alt="" class="mx-auto overflow-hidden rounded-full max-h-32">
                        <label for="data.photo"
                        class="w-32 h-12 bottom-0  bg-base-100 absolute flex items-center justify-center opacity-0 hover:opacity-75 transition duration-150 ease-in-out">
                        <img src="/iconphoto.svg">
                        <input wire:model="data.photo" type="file" id="data.photo" class="hidden">
                </div>
                <div class="flex items-center space-x-2 mt-2">
                    <p class="text-2xl">Your name</p>
                </div>
                <p class="text-gray-700">Your bio</p>
                <p class="text-sm text-gray-500">where are you?</p>
                <x-form-control>
                    <x-labell for="">Name</x-labell>
                    <x-input id="" name="" wire:model=""/>
                    <x-labell for="">Last name</x-labell>
                    <x-input id="" name="" wire:model=""/>
                    <x-labell for="">Bio</x-labell>
                    <x-input id="" name="" wire:model=""/>
                    <x-labell for="">Location</x-labell>
                    <x-input id="" name="" wire:model=""/>
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
                            <div x-show="link.url.includes('twitter')">
                                <x-icons.twitter />
                            </div>
                            <div x-show="link.url.includes('linkedin')">
                                <x-icons.linkedin />
                            </div>
                            <div x-show="isDefault(link.url, ['facebook','instagram','tiktok', 'twitter', 'linkedin'], 5)">
                                <x-icons.default-link />
                            </div>
                            <input x-model="link.url" type="text" placeholder="Link here" class="input input-bordered input-warning w-full max-w-xs" />
                            <x-button x-on:click="addLink">Add</x-button>
                        </div>
                    </template>
            </div>
                <button class="btn btn-success">Save</button>
                <button class="btn btn-active btn-ghost">Cancel</button>
            </div>
        </div>
    </div>
