<main>
    <section class="hero min-h-screen" style="background-image: url('/jumbotron.png');">
        <div class="hero-overlay bg-opacity-50"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold text-white">{{ __('home-lang.hero.title') }}</h1>
                <p class="mb-5 text-white">{{ __('home-lang.hero.description') }}</p>
                <a class="btn btn-primary" href="#contact">{{ __('home-lang.hero.cta') }}</a>
            </div>
        </div>
    </section>

    <x-hero-component title="{{ __('home-lang.event.title') }}" description="{{ __('home-lang.event.description') }}"
        src="event.png" alt="Tickle Time Planner" align="left" />

    <x-hero-component title="{{ __('home-lang.alert.title') }}" description="{{ __('home-lang.alert.description') }}"
        src="alert.png" alt="Tickle Time Planner" />

    <x-hero-component title="{{ __('home-lang.product.title') }}"
        description="{{ __('home-lang.product.description') }}" src="product.png" alt="Tickle Time Planner"
        align="left" />

    <x-hero-component title="{{ __('home-lang.payment.title') }}"
        description="{{ __('home-lang.payment.description') }}" src="payment.png" alt="Tickle Time Planner" />

    <section class="hero lg:min-h-screen" id="contact">
        <div class="hero-content flex-col lg:flex-row lg:justify-between w-full">
            <div class="max-w-lg">
                <h2 class="text-5xl font-bold mb-4 text-center">{{ __('home-lang.contact.title') }}</h2>
                <p class="mb-2 text-center">
                    {{ __('home-lang.contact.description') }}
                </p>
            </div>

            <form action="" class="w-full max-w-md">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{ __('home-lang.contact.name') }}</span>
                    </label>
                    <input type="text" placeholder="{{ __('home-lang.contact.name') }}"
                        class="input input-bordered">
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{ __('home-lang.contact.email') }}</span>
                    </label>
                    <input type="text" placeholder="{{ __('home-lang.contact.email') }}"
                        class="input input-bordered">
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{ __('home-lang.contact.message') }}</span>
                    </label>
                    <textarea placeholder="{{ __('home-lang.contact.message') }}" class="textarea textarea-bordered"></textarea>
                </div>
                <div class="form-control mt-4">
                    <input type="submit" value="{{ __('home-lang.contact.submit') }}" class="btn btn-primary">
                </div>
            </form>
        </div>
    </section>
</main>
