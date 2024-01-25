@isset($event['id'])
    @php
        $remaining = $this->getRemaining();
    @endphp

    <div class="hidden lg:block lg:w-96 absolute right-0 top-0 h-full p-4 bg-base-100 text-base-content">
        <h3 class="text-xl text-center">{{ __('calendar-lang.Payments') }}</h3>
        <h4 class="text-lg text-center">{{ __('calendar-lang.total') }}: {{ $this->getTotal() }} </h4>

        <ul class="menu">
            <div class=" overflow-y-auto max-h-48">
                @isset($event['payments'])
                    @foreach ($event['payments'] as $payment)
                        <li>
                            <a class="flex justify-between">
                                <span>{{ Carbon\Carbon::parse($payment['created_at'])->format('d/m/Y') }}</span>
                                <span>{{ $payment['notes'] }}</span>
                                <span>${{ $payment['amount'] }}</span>
                            </a>
                        </li>
                    @endforeach
                @endisset
            </div>
            <label class="divider divider-base-200"></label>
            <li>
                <a class="flex justify-between">
                    <span>{{ __('calendar-lang.balance') }}</span>
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
                        <x-label for="payment.notes" value="{{ __('calendar-lang.Notes') }}" />
                        <x-input id="payment.notes" name="payment.notes" wire:model="payment.notes" />
                        <x-input-error for="notes" class="mt-2" />
                    </x-form-control>

                    <button class="btn btn-primary w-full mt-2" wire:click.prevent='addPayment()'>
                        <x-icons.plus />{{ __('calendar-lang.AddPayment') }}
                    </button>
                </form>
            @endif

        </ul>
    </div>
@endisset
