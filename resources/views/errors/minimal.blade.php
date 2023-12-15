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
    <header class="navbar bg-base-100 fixed top-0 left-0 w-full z-50">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl" href="/">
                <x-application-mark />
            </a>
        </div>
        <nav class="flex-none">
            <ul class="menu flex-row px-1">
                @auth
                    <li>
                        <a href="{{ url('/dashboard') }}" class="text-sm underline">Dashboard</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="text-sm underline">Log in</a>
                    </li>

                    @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}" class="ml-4 text-sm  underline">Register</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>
    </header>

    <div class="mt-10 md:mt-0">
        <div class="relative flex items-top justify-center min-h-screen bg-base-100 sm:items-center sm:pt-0">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                    <div class="px-4 text-lg  border-r border-gray-400 tracking-wider">
                        @yield('code')
                    </div>

                    <div class="ml-4 text-lg  uppercase tracking-wider">
                        @yield('message')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('accessibility-component')

</body>


</html>
