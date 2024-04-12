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
        @livewire('countdown-component')

        @livewire('news-component')

        @livewire('notification-bar-component')

        <span class="mr-2"></span>


        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-neutral m-1">
                {{ Auth::user()->name }}

                @isset(Auth::user()->profile_photo_path)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                        class="w-8 h-8 rounded-full">
                @endisset

            </div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
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
            </ul>
        </div>
    </div>
</div>
