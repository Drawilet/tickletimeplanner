<dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle" open>
    <div class="modal-box">
        <h2 class="text-3xl text-center text-blue-500 mb-4">{{ __('news-modal.Próximoseventos') }}</h2>
        <ul class="space-y-4">
            @foreach ($events as $event)
            <li class="p-4 rounded-md shadow-md">
                <h3 class="flex items-center text-xl text-blue-600">
                    <span class="mr-2">{{ $event->name }}</span>
                    <span class="w-3 h-3 rounded-full"style="background-color: {{$event->space->color}}"></span>
                </h3>
                <p class="text-white-600 mt-2">
                <span>{{ __('news-modal.dia') }}</span> 
                <span>
                @isset($event['date'])
                        {{ \Carbon\Carbon::parse($event['date'])->format('d') }},
                        {{ __('month-lang.' . strtolower(\Carbon\Carbon::parse($event['date'])->format('F'))) }},
                        {{ \Carbon\Carbon::parse($event['date'])->format('Y') }}
                    @endisset
                    </span>
                
                </p>
                <p class="text-white-500 mt-1">
            <span>{{ __('news-modal.pago') }}</span>
            <span class="text-green-500 font-semibold mt-1">${{$this->getRemaining($event->id)}}</span>
                </p>
                
            </li>
            @endforeach
        </ul>

        <div class="modal-action mt-4">
            <form method="dialog">
                <button class="btn bg-blue-500 text-white rounded-md px-4 py-2">Cerrar</button>
            </form>
        </div>
    </div>
</dialog>