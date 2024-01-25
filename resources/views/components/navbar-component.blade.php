<div class="navbar bg-base-200 sticky top-0 z-50">
    <div class="flex-none">
        <x-sidebar-component />
    </div>
    <div class="flex-1">
        <a class="btn btn-ghost normal-case text-xl" href="/dashboard">
            <x-application-mark hideName />
        </a>
    </div>

    <div>
        @livewire('news-component')

        @livewire('notification-bar-component')

        <span class="mr-2"></span>

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-base-300">
                        {{ Auth::user()->name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </x-slot>

            <x-slot name="content">
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs">
                    {{ __('navbar-lang.ManageAccount') }}
                </div>

                <x-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('navbar-lang.Profile') }}
                </x-dropdown-link>


                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('navbar-lang.LogOut') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>
