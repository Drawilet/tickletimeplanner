<main class="py-2 px-5 md:px-20 ">
    <div class="flex justify-center items-center w-full mb-1 flex-wrap gap-1">
        <input type="text" class="input input-bordered w-full md:w-1/2 " placeholder="{{ __('spaces.Search') }}..."
            wire:model="filters.name">

        <div class="w-full mt-2 flex gap-1 md:w-1/3 md:mt-0">
            <input type="text" class="input input-bordered w-1/2" placeholder="{{ __('spaces.City') }}"
                wire:model="filters.city">
            <input type="text" class="input input-bordered w-1/2" placeholder="{{ __('spaces.Country') }}"
                wire:model="filters.country">
        </div>
    </div>

    <section class="flex gap-5 flex-wrap mt-5">
        @if ($filteredSpaces->isNotEmpty())
            @foreach ($filteredSpaces as $space)
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
                                <div
                                    class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#{{ $name . ($key == 1 ? $size : $key - 1) }}" class="btn btn-circle">❮</a>
                                    <a href="#{{ $name . ($key == $size ? 1 : $key + 1) }}" class="btn btn-circle">❯</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{ $space->name }}</h2>
                        <p>{{ $space->description }}</p>
                        <p class="text-sm text-gray-500">{{ $space->getAddress() }}</p>
                        <div class="card-actions justify-end">
                            <button class="btn btn-primary"
                                wire:click="Modal('contact', true, '{{ $space->id }}')">{{ __('spaces.Booknow') }}</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="w-96 mx-auto">
                <h2 class="font-bold text-xl text-center">{{ __('spaces.Nospacesfound') }}</h2>
                <p class="text-center">{{ __('spaces.Tryanothersearch') }}</p>
            </div>
        @endif
    </section>

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
                    <label class="btn" wire:click="Modal('contact',false)">{{ __('spaces.Close') }}</label>
                </div>
            </div>
        @endif
        <label class="modal-backdrop" wire:click="Modal('contact',false)"></label>
    </div>

    <script type="module">
        var location, latitude, longitude;

        async function next() {
            if (!location)
                await fetch('https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=' + latitude +
                    '&longitude=' +
                    longitude + '&localityLanguage=en').then((res) => res.json()).then(function(response) {
                    location = {
                        city: response.city,
                        countryCode: response.countryCode,
                        countryName: response.countryName,
                        locality: response.locality,
                    }
                });

            @this.set('filters.city', location.city);
            @this.set('filters.country', location.countryName);
        }

        function getLocation() {
            if (!latitude || !longitude) navigator.geolocation.getCurrentPosition(
                function success(pos) {
                    const loc = pos.coords;
                    latitude = loc.latitude;
                    longitude = loc.longitude;

                    next();
                },
                function error(err) {
                    fetch('https://ipinfo.io/geo').then((res) => res.json()).then(function(response) {
                        var loc = response.loc.split(',');
                        latitude = parseFloat(loc[0]);
                        longitude = parseFloat(loc[1]);

                        next();
                    });
                }, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        }

        getLocation();
    </script>
</main>
