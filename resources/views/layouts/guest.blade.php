<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
</head>

<body>
    <header class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl" href="/">
                <x-application-mark />
            </a>
        </div>
        <nav class="flex-none">
            <ul class="menu flex-row px-1">
                @auth
                    <li>
                        <a href="{{ url('/dashboard') }}" class="text-sm underline">{{ __('login-register.Dashboard') }}</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="text-sm underline">{{__('login-register.Login')}}</a>
                    </li>

                    @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}" class="ml-4 text-sm  underline">{{ __('login-register.Register') }}</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>
    </header>

    <div class="font-sansantialiased">
        {{ $slot }}
    </div>

    @livewire('accessibility-component')
    @livewireScripts
</body>


</html>
