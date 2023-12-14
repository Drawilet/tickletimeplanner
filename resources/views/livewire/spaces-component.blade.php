<main class="py-2 px-5 md:px-20 flex gap-5 flex-wrap">
    @foreach ($spaces as $space)
        <div class="card w-96 bg-base-100 shadow-xl mx-auto md:mx-0">
            <div class="carousel w-full max-h-60">
                @php
                    $photos = $space->photos->toArray();
                @endphp
                @foreach ($photos as $key => $photo)
                    @php
                        $key = $key + 1;
                        $name = $space->id . '-carrousel-';
                        $size = count($photos);
                    @endphp
                    <div id="{{ $name . $key }}" class="carousel-item relative w-full">
                        <img src="{{ $photo['url'] }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#{{ $name . ($key == 0 ? $size : $key - 1) }}" class="btn btn-circle">❮</a>
                            <a href="#{{ $name . ($key == $size ? 1 : $key + 1) }}" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-body">
                <h2 class="card-title">{{ $space->name }}</h2>
                <p>{{ $space->description }}</p>
                <div class="card-actions justify-end">
                    <button class="btn btn-primary" wire:click="Modal('contact', true, '{{ $space->id }}')">Book
                        now</button>
                </div>
            </div>
        </div>
    @endforeach

    <input type="checkbox" class="modal-toggle" @checked($modals['contact']) />
    <div class="modal" role="dialog">
        @if ($currentSpace)
            <div class="modal-box">
                <div class="w-full h-[250px]">
                    <div class="mx-auto w-full h-[250px] bg-base-300 rounded-md overflow-hidden relative">
                        <img src="{{ $currentSpace->tenant->background_image }}" class="w-full">
                    </div>
                </div>

                <div class="flex flex-col items-center -mt-20">
                    <div class="mx-auto h-32 w-32 bg-base-200 rounded-full overflow-hidden relative">
                        <img src="{{ $currentSpace->tenant->profile_image }}" alt=""
                            class="mx-auto overflow-hidden rounded-full max-h-32">
                    </div>
                </div>

                <h3 class="font-bold text-2xl text-center">{{ $currentSpace->tenant->name }}</h3>
                <div class="flex flex-col items-center mt-2">
                    <p class="flex gap-2">
                        <x-icons.phone />
                        <a href="tel:{{ $currentSpace->tenant->phone }}"> {{ $currentSpace->tenant->phone }}</a>
                    </p>
                    <p class="flex gap-2">
                        <x-icons.envelope />
                        <a href="mailto:{{ $currentSpace->tenant->email }}"> {{ $currentSpace->tenant->email }}</a>
                    </p>
                </div>

                <div class="modal-action">
                    <label class="btn" wire:click="Modal('contact',false)">Close!</label>
                </div>
            </div>
        @endif
        <label class="modal-backdrop" wire:click="Modal('contact',false)"></label>
    </div>
</main>
