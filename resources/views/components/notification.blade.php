@props(['message', 'date', 'link', 'icon', 'color', 'readAt', 'id', 'image'])
<button class="flex items-center gap-3 p-2 hover:bg-base-200 {{ $readAt ? '' : 'bg-base-100' }}"
    wire:click="click('{{ $id }}')">
    <section class="relative">
        <span class="w-14 h-14 rounded-full bg-base-200 block bg-center bg-no-repeat bg-cover"
            style="background-image: url('{{ $image }}')">

        </span>
        <span class="w-5 h-5 rounded-full flex justify-center items-center absolute bottom-0 right-0"
            style="background-color: {{ $color }}">
            @component('components.icons.' . $icon, ['class' => 'w-4 h-4'])
            @endcomponent
        </span>
    </section>

    <section>
        <p class="text-sm">{{ __($message) }}</p>
        <p class="text-xs opacity-70">{{ $date }}</p>
    </section>
</button>
