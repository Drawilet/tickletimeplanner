@if ($readonly)
    @php
        $remaining = $this->getRemaining();
    @endphp


    <div class="w-96 absolute right-0 top-0 h-full p-4 bg-base-200 text-base-content">
        <h3 class="text-xl text-center">{{ __('calendar-lang.AddPayment') }}</h3>

        <ul class="menu">
            @isset($event['payments'])
                @foreach ($event['payments'] as $payment)
                    <li>
                        <a class="flex justify-between">
                            <span>{{ $payment['concept'] }}</span>
                            <span>${{ $payment['amount'] }}</span>
                        </a>
                    </li>
                @endforeach
            @endisset

            <label class="divider divider-base-200"></label>
            <li>
                <a class="flex justify-between">
                    <span>{{ __('calendar-lang.Remaining')}}</span>
                    <span> ${{ $remaining }}</span>
                </a>
            </li>

            @if ($remaining > 0)
                <form class="mt-2">
                    <x-form-control>
                        <x-label for="payment.amount" value="{{ __('calendar-lang.Amount') }}" />
                        <x-input id="payment.amount" name="payment.amount" wire:model="payment.amount" type="number" />
                        <x-input-error for="amount" class="mt-2" />
                    </x-form-control>

                    <x-form-control>
                        <x-label for="payment.concept" value="{{ __('calendar-lang.Concept') }}" />
                        <x-input id="payment.concept" name="payment.concept" wire:model="payment.concept" />
                        <x-input-error for="concept" class="mt-2" />
                    </x-form-control>

                    <button class="btn btn-primary w-full mt-2" wire:click.prevent='addPayment()'>
                        <x-icons.plus />{{ __('calendar-lang.AddPayment')}}
                    </button>
                </form>
            @endif

        </ul>
    </div>
@endif
