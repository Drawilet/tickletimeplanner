<div class="flex items-center">
    <button id="toggle-news">
        <x-icons.newspaper />
    </button>

    <dialog id="news_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h2 class="text-3xl text-center text-blue-500 mb-4">{{ __('news-modal.Próximoseventos') }}</h2>
            <ul class="space-y-4">
                @foreach ($events as $event)
                    <li class="p-4 rounded-md shadow-md">
                        <h3 class="flex items-center text-xl text-blue-600">
                            <span class="mr-2">{{ $event->name }}</span>
                            <span
                                class="w-3 h-3 rounded-full"style="background-color: {{ $event->space->color }}"></span>
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
                            <span
                                class="text-green-500 font-semibold mt-1">${{ $this->getRemaining($event->id) }}</span>
                        </p>

                    </li>
                @endforeach
            </ul>

            <div class="modal-action mt-4">
                <button class="btn btn-secondary rounded-md px-4 py-2" id="later-button">
                    Remind me later
                </button>
                <button class="btn btn-primary rounded-md px-4 py-2" id="tomorrow-button">Close</button>
            </div>
        </div>
    </dialog>

    <script>
        const modal = document.getElementById('news_modal')
        const cookieKey = "news_date"

        const cookie = document.cookie.split('; ').find(row => row.startsWith(cookieKey))
        const cookieValue = cookie ? cookie.split('=')[1] : null

        if (!cookieValue) modal.showModal()

        function close(when) {
            const date = new Date()

            if (when === 'tomorrow')
                date.setDate(date.getDate() + 1)
            else if (when === 'later')
                date.setHours(date.getHours() + 6)

            document.cookie = `${cookieKey}=${date}; expires=${date.toUTCString()}; path=/`
            modal.close()
        }

        function toggleNews() {
            modal.showModal()
        }

        document.getElementById('toggle-news').addEventListener('click', toggleNews)

        document.getElementById('later-button').addEventListener('click', () => close('later'))
        document.getElementById('tomorrow-button').addEventListener('click', () => close('tomorrow'))
    </script>
</div>
