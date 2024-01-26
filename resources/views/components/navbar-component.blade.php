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


        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn m-1">
                {{ Auth::user()->name }}

                <img src="/storage/{{ Auth::user()->profile_photo_path }}" alt="" class="h-7">
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
