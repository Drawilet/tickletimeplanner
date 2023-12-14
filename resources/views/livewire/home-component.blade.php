<main class="py-2 px-5  md:px-20 md:flex md:gap-6">
    <section class="md:w-1/2 md:flex md:flex-col md:justify-center">
        <div class="mb-3">
            <h2 class="text-2xl">{{ __('home-lang.Instant Reservations') }}</h2>
            <p>
                {{ __('home-lang.p1') }}
            </p>
        </div>
        <div class="mb-3">
            <h2 class="text-2xl">{{ __('home-lang.Ourservices') }}</h2>
            <p>
                {{ __('home-lang.p2') }}
            </p>
        </div>

        <a href="{{ route('spaces.show') }}">
            <button class="btn btn-primary w-full">{{ __('home-lang.Booknow') }}</button>
        </a>
    </section>

    <section class="md:w-1/2 md:flex md:justify-center md:items-center">
        <x-vectors.booking width="400px" />
    </section>
</main>
