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
        @if ($sent)
            <div class="w-full max-w-md flex flex-col items-center">
                <svg class="max-w-sm" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="570"
                    height="511.67482" viewBox="0 0 570 511.67482" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path
                        d="M879.99927,389.83741a.99678.99678,0,0,1-.5708-.1792L602.86963,197.05469a5.01548,5.01548,0,0,0-5.72852.00977L322.57434,389.65626a1.00019,1.00019,0,0,1-1.14868-1.6377l274.567-192.5918a7.02216,7.02216,0,0,1,8.02-.01318l276.55883,192.603a1.00019,1.00019,0,0,1-.57226,1.8208Z"
                        transform="translate(-315 -194.16259)" fill="#3f3d56" />
                    <polygon
                        points="23.264 202.502 285.276 8.319 549.276 216.319 298.776 364.819 162.776 333.819 23.264 202.502"
                        fill="#e6e6e6" />
                    <path
                        d="M489.25553,650.70367H359.81522a6.04737,6.04737,0,1,1,0-12.09473H489.25553a6.04737,6.04737,0,1,1,0,12.09473Z"
                        transform="translate(-315 -194.16259)" fill="#6c63ff" />
                    <path
                        d="M406.25553,624.70367H359.81522a6.04737,6.04737,0,1,1,0-12.09473h46.44031a6.04737,6.04737,0,1,1,0,12.09473Z"
                        transform="translate(-315 -194.16259)" fill="#6c63ff" />
                    <path
                        d="M603.96016,504.82207a7.56366,7.56366,0,0,1-2.86914-.562L439.5002,437.21123v-209.874a7.00817,7.00817,0,0,1,7-7h310a7.00818,7.00818,0,0,1,7,7v210.0205l-.30371.12989L606.91622,504.22734A7.61624,7.61624,0,0,1,603.96016,504.82207Z"
                        transform="translate(-315 -194.16259)" fill="#fff" />
                    <path
                        d="M603.96016,505.32158a8.07177,8.07177,0,0,1-3.05957-.59863L439.0002,437.54521v-210.208a7.50851,7.50851,0,0,1,7.5-7.5h310a7.50851,7.50851,0,0,1,7.5,7.5V437.68779l-156.8877,66.999A8.10957,8.10957,0,0,1,603.96016,505.32158Zm-162.96-69.1123,160.66309,66.66455a6.1182,6.1182,0,0,0,4.668-.02784l155.669-66.47851V227.33721a5.50653,5.50653,0,0,0-5.5-5.5h-310a5.50653,5.50653,0,0,0-5.5,5.5Z"
                        transform="translate(-315 -194.16259)" fill="#3f3d56" />
                    <path
                        d="M878,387.83741h-.2002L763,436.85743l-157.06982,67.07a5.06614,5.06614,0,0,1-3.88038.02L440,436.71741l-117.62012-48.8-.17968-.08H322a7.00778,7.00778,0,0,0-7,7v304a7.00779,7.00779,0,0,0,7,7H878a7.00779,7.00779,0,0,0,7-7v-304A7.00778,7.00778,0,0,0,878,387.83741Zm5,311a5.002,5.002,0,0,1-5,5H322a5.002,5.002,0,0,1-5-5v-304a5.01106,5.01106,0,0,1,4.81006-5L440,438.87739l161.28027,66.92a7.12081,7.12081,0,0,0,5.43994-.03L763,439.02741l115.2002-49.19a5.01621,5.01621,0,0,1,4.7998,5Z"
                        transform="translate(-315 -194.16259)" fill="#3f3d56" />
                    <path
                        d="M602.345,445.30958a27.49862,27.49862,0,0,1-16.5459-5.4961l-.2959-.22217-62.311-47.70752a27.68337,27.68337,0,1,1,33.67407-43.94921l40.36035,30.94775,95.37793-124.38672a27.68235,27.68235,0,0,1,38.81323-5.12353l-.593.80517.6084-.79346a27.71447,27.71447,0,0,1,5.12353,38.81348L624.36938,434.50586A27.69447,27.69447,0,0,1,602.345,445.30958Z"
                        transform="translate(-315 -194.16259)" fill="#6c63ff" />
                </svg>

                <h2 class="text-3xl font-bold -mt-16 text-center">{{ __('home-lang.contact.success') }}</h2>
            </div>
        @else
            <div class="hero-content flex-col lg:flex-row lg:justify-between w-full">
                <div class="max-w-lg">
                    <h2 class="text-5xl font-bold mb-4 text-center">{{ __('home-lang.contact.title') }}</h2>
                    <p class="mb-2 text-center">
                        {{ __('home-lang.contact.description') }}
                    </p>
                </div>

                <form class="w-full max-w-md">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('home-lang.contact.name') }}</span>
                        </label>
                        <input type="text" placeholder="{{ __('home-lang.contact.name') }}" wire:model="data.name"
                            wire:loading.attr="disabled" wire:target="submit" class="input input-bordered">
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('home-lang.contact.email') }}</span>
                        </label>
                        <input type="text" placeholder="{{ __('home-lang.contact.email') }}" wire:model="data.email"
                            wire:loading.attr="disabled" wire:target="submit" class="input input-bordered">
                        <x-input-error for="email" class="mt-2" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('home-lang.contact.message') }}</span>
                        </label>
                        <textarea placeholder="{{ __('home-lang.contact.message') }}" wire:model='data.message' wire:loading.attr="disabled"
                            wire:target="submit" class="textarea textarea-bordered"></textarea>
                        <x-input-error for="message" class="mt-2" />
                    </div>
                    <div class="form-control mt-4">
                        <button type="button" class="btn btn-primary" wire:click='submit' wire:loading.attr="disabled"
                            wire:target="submit">{{ __('home-lang.contact.submit') }}</button>
                    </div>
                </form>

            </div>
        @endif


    </section>
</main>
