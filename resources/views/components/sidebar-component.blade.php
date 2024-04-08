<div class="drawer z-50">
    <input id="sidebar" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
        <label for="sidebar" class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block w-5 h-5 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </label>
    </div>

    <div class="drawer-side">
        <label for="sidebar" aria-label="close sidebar" class="drawer-overlay">
        </label>
        <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-truncate">
            <a href="{{ route('dashboard.show') }}" class="btn btn-ghost normal-case text-xl mb-3">
                <x-application-mark />
            </a>
            {{-- MENU --}}
            @foreach ($sidebar as $label => $item)
                @if (gettype($item) == 'string')
                    <label class="divider divider-accent">{{ __('sidebar.' . $item) }}</label>
                @else
                    @can(isset($item['permission']) ? $item['permission'] : null)
                        <li class="{{ isset($item['sub']) ? 'dropdown dropdown-hover dropdown-right' : '' }}">
                            <a href="{{ route($item['route']) }}"
                                class="{{ $currentRoute == $item['route'] ? 'active' : '' }}">
                                @component('components.icons.' . $item['icon'])
                                @endcomponent

                                {{ __('sidebar.' . $label) }}
                            </a>

                            @isset($item['sub'])
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded w-52 -translate-x-5">
                                    @foreach ($item['sub'] as $subLabel => $subItem)
                                        <a href="{{ route($subItem['route']) }}" class="flex items-center">
                                            @component('components.icons.' . $subItem['icon'])
                                            @endcomponent

                                            {{ $subLabel }}
                                        </a>
                                    @endforeach
                                </ul>
                            @endisset

                        </li>
                    @else
                    @endcan
                @endif
            @endforeach

            <label class="divider divider-base-200 mt-auto"></label>
            @role('tenant.admin')
                <li>
                    <a href="{{ route('tenant.settings.show') }}">
                        <x-icons.cog-6-tooth />
                        <span>{{ __('sidebar.Settings') }}</span>
                    </a>
                </li>
            @endrole
    </div>
    </ul>
</div>
