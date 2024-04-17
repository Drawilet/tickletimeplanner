@if ($transactions && count($transactions) > 0)
    <div class="absolute -top-4 right-0 bg-base-200 shadow-lg rounded-lg p-6 border border-base-100 w-96">
        <h2 class="text-xl mb-4 border-b pb-2 text-primary">{{ __('Historial de Transacciones') }}</h2>
        <div class="space-y-1 overflow-auto h-36">
            @foreach ($transactions as $transaction)
                <div class="shadow p-2 rounded-lg flex justify-between items-center">
                    <p class="text-primary">{{ Carbon\Carbon::parse($transaction['created_at'])->format('d/m/Y') }}</p>

                    <p>
                        {{ $transaction['notes'] }}
                    </p>

                    <p class="text-secondary font-semibold">${{ number_format($transaction['amount'], 2) }}</p>
                </div>
            @endforeach
        </div>

        <h3 class="text-right -mb-1">
            {{ __('calendar-lang.balance') }}: ${{ number_format($data['balance'], 2) }}
        </h3>

        <h3 class="text-right text-sm">
            {{ __('tenant.next-payment') }}: ${{ number_format($data['plan']['price'], 2) }}
        </h3>
    </div>

@endif
