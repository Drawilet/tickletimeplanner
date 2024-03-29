<div class="relative">
    <a href="{{ url()->previous() ?: url('/fallback-url') }}" class="btn font-bold py-2 px-4 rounded absolute top-0 left-0 m-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
        </svg>
    </a>
    <div class="bg-base rounded-lg w-full md:w-5/12 mx-auto shadow-xl pb-8">
        <div class="w-full h-[250px]">
            <div class="mx-auto w-full h-[250px] bg-base-300 rounded-md overflow-hidden relative">
                @if ($tenant['background_image'])
                <img src="{{ gettype($tenant['background_image']) == 'object' ? $tenant['background_image']->temporaryUrl() : $tenant['background_image'] }}" class="w-full h-full object-cover" alt="Background Image">
                @endif
            </div>
        </div>
        <div class="flex flex-col items-center -mt-20">
            <div class="mx-auto h-32 w-32 bg-base-300 rounded-full overflow-hidden relative">
                @if ($tenant['profile_image'])
                <img src="{{ gettype($tenant['profile_image']) == 'object' ? $tenant['profile_image']->temporaryUrl() : $tenant['profile_image'] }}" alt="Profile Image" class="w-32 h-32 object-cover rounded-full mx-auto">
                @endif
            </div>
        </div>
        <div>
            <div class="text-center px-6 py-4">
                <h1 class="text-xl font-bold text-white-700 mb-3">{{ $tenant->name }}</h1>
                <h2 class="text-base text-gray-500 mb-2">{{ $tenant->email }}</h2>
                <h2 class="text-base text-gray-500 mb-2">{{ $tenant->phone }}</h2>
                <p class="text-sm text-gray-500">{{ $tenant->description }}</p>
            </div>

            <div class="stats stats-vertical lg:stats-horizontal shadow flex flex-col lg:flex-row justify-between">

                <div class="stat flex-1 p-4 shadow">
                    <div class="stat-title text-2xl">{{ __('sidebar.customers') }}</div>
                    <div class="stat-value text-4xl">{{ $tenant->customers->count()}}</div>
                </div>
                <div class="stat flex-1 p-4 shadow">
                    <div class="stat-title text-2xl">{{ __('sidebar.products') }}</div>
                    <div class="stat-value text-4xl">{{ $tenant->products->count()}}</div>
                </div>
                <div class="stat flex-1 p-4 shadow">
                    <div class="stat-title text-2xl">{{ __('sidebar.spaces') }}</div>
                    <div class="stat-value text-4xl">{{ $tenant->spaces->count()}}</div>
                </div>
                <div class="stat flex-1 p-4 shadow">
                    <div class="stat-title text-2xl">{{ __('sidebar.events') }}</div>
                    <div class="stat-value text-4xl">{{ $tenant->events->count()}}</div>
                </div>
            </div>
        </div>
    </div>
