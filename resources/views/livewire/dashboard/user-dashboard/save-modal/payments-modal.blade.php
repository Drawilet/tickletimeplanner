@isset($event['id'])
    @php
        $remaining = $this->getRemaining();
    @endphp

    <div
        class="{{ $modals['payments'] ? 'block' : 'hidden' }} w-11/12 md:block lg:w-96 absolute right-0 top-0 h-full p-4 bg-base-100 text-base-content">
        <h3 class="text-xl text-center">{{ __('calendar-lang.Payments') }}</h3>
        <h4 class="text-lg text-center">{{ __('calendar-lang.total') }}: ${{ number_format($this->getTotal(), 2) }} </h4>

        <ul class="menu">
            <div class=" overflow-y-auto max-h-48">
                @isset($event['payments'])
                    @foreach ($event['payments'] as $payment)
                        <li>
                            <a class="flex justify-between">
                                <span>{{ Carbon\Carbon::parse($payment['created_at'])->format('d/m/Y') }}</span>
                                <span>{{ $payment['notes'] }}</span>
                                <span>${{ number_format($payment['amount'], 2) }}</span>
                            </a>
                        </li>
                    @endforeach
                @endisset
            </div>
            <label class="divider divider-base-200"></label>
            <li>
                <a class="flex justify-between">
                    <span>{{ __('calendar-lang.balance') }}</span>
                    <span> ${{ number_format($remaining, 2) }}</span>
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
                        <x-label for="payment.notes" value="{{ __('calendar-lang.payment-notes') }}" />
                        <textarea class="textarea textarea-bordered" id="payment.notes" name="payment.notes" wire:model="payment.notes"> </textarea>
                        <x-input-error for="notes" class="mt-2" />
                    </x-form-control>


                    <button class="btn btn-primary w-full mt-2" wire:click.prevent='addEventPayment()'>
                        <x-icons.plus />{{ __('calendar-lang.AddPayment') }}
                    </button>
                </form>
            @endif

            <button class="mt-2 w-full btn btn-secondary md:hidden " wire:click="Modal('payments', false)">
                {{ __('calendar-lang.hide-payments') }}
            </button>
        </ul>
    </div>
@endisset
