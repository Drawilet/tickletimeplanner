<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <x-form-control>
                <x-label for="email" value="{{ __('login-register.Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </x-form-control>

            <x-form-control class="mt-3">
                <x-label for="password" value="{{ __('login-register.Password') }}" />
                <label class="input-bordered flex items-center relative ">
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <kbd class="kbd kbd-sm absolute right-0 mr-3">

                        <label class="swap swap-rotate">
                            <!-- this hidden checkbox controls the state -->
                            <x-checkbox id="show-password" class="theme-controller sr-only absolute"
                                value="synthwave" />

                            <!-- eye -->
                            <svg class="swap-on fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 4.5C7.30558 4.5 3.3408 7.55025 2.05025 12C3.3408 16.4497 7.30558 19.5 12 19.5C16.6944 19.5 20.6592 16.4497 21.9497 12C20.6592 7.55025 16.6944 4.5 12 4.5ZM12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17Z" />
                                <!-- line -->
                                <path d="M2 2 L22 22" stroke="white" stroke-width="2" />
                            </svg>

                            <!-- eye-slash -->
                            <svg class="swap-off fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 4.5C7.30558 4.5 3.3408 7.55025 2.05025 12C3.3408 16.4497 7.30558 19.5 12 19.5C16.6944 19.5 20.6592 16.4497 21.9497 12C20.6592 7.55025 16.6944 4.5 12 4.5ZM12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17Z" />
                            </svg>
                        </label>
                    </kbd>
                </label>
            </x-form-control>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm ">{{ __('login-register.Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm  " href="{{ route('password.request') }}">
                        {{ __('login-register.Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('login-register.Login') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
    <script>
        document.getElementById('show-password').addEventListener('change', function() {
            const passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</x-guest-layout>
