<main class="py-2 px-5  md:px-20 md:flex md:gap-6">
    <section class="md:w-1/2 md:flex md:flex-col md:justify-center">
        <div class="mb-3">
            <h2 class="text-2xl">Instant Reservations</h2>
            <p>Makes it easy for users to book quickly
                and simple space for events,
                whether for corporate meetings,
                private parties or other occasions
            </p>
        </div>
        <div class="mb-3">
            <h2 class="text-2xl">Our services </h2>
            <p>we provide a comprehensive solution for reservation management,
                appointments and events, with a friendly interface and functions that improve efficiency
                and user satisfaction in the planning process.
            </p>
        </div>

        <a href="{{ route('spaces.show') }}">
            <button class="btn btn-primary w-full">Book now</button>
        </a>
    </section>

    <section class="md:w-1/2 md:flex md:justify-center md:items-center">
        <x-vectors.booking width="400px" />
    </section>
</main>
