<div class="flex flex-col gap-4 mx-auto">
    <h2 class="text-2xl font-bold text-center">
        {{ __('tenant-settings.choose') }}
    </h2>

    <div class="flex flex-wrap gap-4 justify-evenly">
        @foreach ($plans as $plan)
            <div
                class="w-full max-w-md md:max-w-xs flex flex-col bg-base-200 p-4 gap-2 transition-all rounded  {{ $data['plan_id'] == $plan['id'] || $data['next_plan_id'] == $plan['id'] ? 'scale-100 opacity-100  shadow-2xl' : 'scale-95 opacity-80' }} {{ $data['plan_id'] == $plan['id'] ? 'border border-secondary' : '' }}
                ">
                <div class="flex items-center">
                    <img src="/icon.svg" class="size-8">
                    {{ config('app.name') }}
                </div>

                <div>
                    <h3 class="text-3xl font-bold text-secondary">
                        {{ $plan->name }}
                    </h3>
                </div>

                <div>
                    <p class="text-lg">
                        ${{ number_format($plan->price, 2) }} /
                        {{ $plan->duration }}
                        {{ __('tenant-settings.' . $plan->duration_unit) }}
                    </p>
                </div>

                <button wire:click.prevent='$set("data.next_plan_id", {{ $plan['id'] }})' class="btn btn-secondary">
                    {{ __('tenant-settings.suscribe') }}
                </button>

                @if ($plan['id'] == $data['plan_id'])
                    <p class="text-sm">
                        {{ __('tenant-settings.current') }}
                    </p>
                @elseif ($plan['id'] == $data['next_plan_id'])
                    <p class="text-sm">
                        {{ __('tenant-settings.next') }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>

    <x-input-error for="plan_id" />
    <x-input-error for="next_plan_id" />

    @if ($oldData['plan_id'] != $data['plan_id'] || isset($data['plan_id']))
        <p class="text-sm text-center">
            {{ __('tenant-settings.alert') }}
        </p>
    @endif

</div>
