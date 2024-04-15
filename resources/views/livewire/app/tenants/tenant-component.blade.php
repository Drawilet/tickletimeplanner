<div class="relative w-full">
    <a href="{{ url()->previous() ?: url('/fallback-url') }}"
        class="btn font-bold py-2 px-4 rounded absolute top-0 left-0 m-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
        </svg>
    </a>

    <div class="bg-base rounded-lg w-full  max-w-lg mx-auto shadow-xl pb-8">
        <div class="w-full h-[250px]">
            <div class="mx-auto w-full h-[250px] bg-base-300 rounded-md overflow-hidden relative">
                @if ($tenant['background_image'])
                    <img src="{{ gettype($tenant['background_image']) == 'object' ? $tenant['background_image']->temporaryUrl() : $tenant['background_image'] }}"
                        class="w-full h-full object-cover" alt="Background Image">
                @endif
            </div>
        </div>

        <div class="flex flex-col items-center -mt-20">
            <div class="mx-auto h-32 w-32 bg-base-300 rounded-full overflow-hidden relative">
                @if ($tenant['profile_image'])
                    <img src="{{ gettype($tenant['profile_image']) == 'object' ? $tenant['profile_image']->temporaryUrl() : $tenant['profile_image'] }}"
                        alt="Profile Image" class="w-32 h-32 object-cover rounded-full mx-auto">
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
                    <div class="stat-value text-4xl">{{ $tenant->customers->count() }}</div>
                </div>
                <div class="stat flex-1 p-4 shadow">
                    <div class="stat-title text-2xl">{{ __('sidebar.products') }}</div>
                    <div class="stat-value text-4xl">{{ $tenant->products->count() }}</div>
                </div>
                <div class="stat flex-1 p-4 shadow">
                    <div class="stat-title text-2xl">{{ __('sidebar.spaces') }}</div>
                    <div class="stat-value text-4xl">{{ $tenant->spaces->count() }}</div>
                </div>
                <div class="stat flex-1 p-4 shadow">
                    <div class="stat-title text-2xl">{{ __('sidebar.events') }}</div>
                    <div class="stat-value text-4xl">{{ $tenant->events->count() }}</div>
                </div>

            </div>


            <div class="mt-4">
                <p class="text-sm">
                    {{ $remainingDays }}d {{ __('countdown.label') }}
                </p>
            </div>

            <div class="w-full flex justify-center items-center mt-4 gap-2">
                <button class="w-1/2 btn btn-error" wire:click="delete({{ $tenant->id }})">
                    <x-icons.trash />
                </button>
                <button class="w-1/2 btn {{ $tenant->suspended ? 'btn-neutral' : 'btn-secondary' }}"
                    wire:click="toggleSuspended({{ $tenant->id }})">
                    @if ($tenant->suspended)
                        {{ __('suspended.Activate') }}
                    @else
                        {{ __('suspended.Suspend') }}
                    @endif

                </button>
            </div>
        </div>
    </div>

    <div class="absolute -top-4 right-0 bg-base-200 shadow-lg rounded-lg p-6 border border-base-100 w-96">
        <h2 class="text-2xl mb-4 border-b pb-2 text-primary">{{ __('Historial de Pagos') }}</h2>
        <div class="space-y-1 overflow-auto h-36">
            <div class="bg-base-300 shadow p-2 rounded-lg flex justify-between items-center">
                <p class="text-primary">05/04/2024</p>
                <p class="text-secondary font-semibold">$950</p>
            </div>
            <div class="bg-base-300 shadow p-2 rounded-lg flex justify-between items-center">
                <p class="text-primary">05/04/2024</p>
                <p class="text-secondary"></p>
                <p class="text-secondary font-semibold">$950</p>
            </div>
            <div class="bg-base-300 shadow p-2 rounded-lg flex justify-between items-center">
                <p class="text-primary">05/04/2024</p>
                <p class="text-secondary font-semibold">$950</p>
            </div>
            <div class="bg-base-300 shadow p-2 rounded-lg flex justify-between items-center">
                <p class="text-primary">05/04/2024</p>
                <p class="text-secondary font-semibold">$950</p>
            </div>
            <div class="bg-base-300 shadow p-2 rounded-lg flex justify-between items-center">
                <p class="text-primary">05/04/2024</p>
                <p class="text-secondary font-semibold">$950</p>
            </div>
            <div class="bg-base-300 shadow p-2 rounded-lg flex justify-between items-center">
                <p class="text-primary">05/04/2024</p>
                <p class="text-secondary font-semibold">$950</p>
            </div>
            <div class="bg-base-300 shadow p-2 rounded-lg flex justify-between items-center">
                <p class="text-primary">05/04/2024</p>
                <p class="text-secondary font-semibold">$950</p>
            </div>
        </div>
        <form class="mt-10">
            <x-form-control>
                <x-label value="{{ __('calendar-lang.Amount') }}" />
                <x-input name="payment.amount" wire:model="" type="number" />
                <x-input-error for="amount" class="mt-2" />
            </x-form-control>

            <x-form-control>
                <x-label  value="{{ __('calendar-lang.payment-notes') }}" />
                <textarea class="textarea textarea-bordered"  name="payment.notes" wire:model=""> </textarea>
                <x-input-error for="notes" class="mt-2" />
            </x-form-control>


            <button class="btn btn-primary w-full mt-2">
                <x-icons.plus />{{ __('calendar-lang.AddPayment') }}
            </button>
        </form>
    </div>

</div>
