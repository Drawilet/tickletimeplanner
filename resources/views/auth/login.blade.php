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
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <label class="flex items-center mt-4">
                    <x-checkbox id="show-password" name="remember" />
                    <span class="ml-2 text-sm ">{{ __("login-register.passwprd") }}</span>
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
        document.getElementById('show-password').addEventListener('change', function () {
            const passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</x-guest-layout>
