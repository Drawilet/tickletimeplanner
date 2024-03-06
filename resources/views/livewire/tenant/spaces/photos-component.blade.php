<section class="flex flex-wrap gap-3">
    @foreach ($files['photos'] as $key => $photo)
        <div class="relative" x-data="{ show: false }" x-show="show">
            <img x-loading="show = false" x-on:load="show = true" src="{{ $photo['url'] }}" alt=""
                class="w-full max-w-xs max-h-20 object-cover rounded-md" />
            <button class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 bg-base-200 rounded-full text-red-500"
                wire:click='delete("{{ $key }}")'>
                <x-icons.x-circle />
            </button>
        </div>
    @endforeach

    <input type="file" id="imgs-id" wire:model="uploadedPhotos" multiple class="hidden" accept="image/*" />

    <label for="imgs-id" class="border border-dashed rounded-md p-6 cursor-pointer">
        <x-icons.plus name="plus" class="w-6 h-6" />
    </label>
</section>
