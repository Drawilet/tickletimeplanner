
<div class="flex items-center">
@if($this->offON)
    <button id="toggle-news" class="btn btn-circle">
        <x-icons.newspaper />
    </button>
@endif
    <dialog id="news_modal" class="modal modal-bottom sm:modal-middle" @if ($modals['news']) open @endif>
        <div class="modal-box overflow-hidden">
            <h2 class="text-3xl text-center text-blue-500 mb-4">{{ __('news-modal.title') }}</h2>
            <ul class="space-y-4 max-h-96 overflow-y-scroll">
                @foreach ($filteredEvents as $event)
                    <li class="p-4 rounded-md shadow-md cursor-pointer" wire:click='openEvent("{{ $event->id }}")'>
                        <h3 class="flex items-center text-xl text-blue-600">
                            <span class="mr-2">{{ $event->name }}</span>
                            <span
                                class="w-3 h-3 rounded-full"style="background-color: {{ $event->space->color }}"></span>
                        </h3>
                        <p class="text-white-600 mt-2">
                            <span>{{ __('news-modal.message') }}</span>
                            <span>
                                @isset($event['date'])
                                    {{ \Carbon\Carbon::parse($event['date'])->format('d') }},
                                    {{ __('month-lang.' . strtolower(\Carbon\Carbon::parse($event['date'])->format('F'))) }},
                                    {{ \Carbon\Carbon::parse($event['date'])->format('Y') }}
                                @endisset
                            </span>

                        </p>
                        <p class="text-white-500 mt-1">

                            @php
                                $remaining = $this->getRemaining($event->id);
                            @endphp

                            @if ($remaining > 0)
                                <span>{{ __('news-modal.payment-message') }}</span>
                                <span class="text-red-500 font-semibold mt-1">
                                    ${{ $remaining }}
                                </span>
                            @else
                                <span>{{ __('news-modal.paid') }}</span>
                            @endif

                        </p>

                    </li>
                @endforeach
            </ul>

            <div class="modal-action mt-4">
                <button class="btn btn-secondary rounded-md px-4 py-2" id="later-button">
                    {{ __('news-modal.remind') }}
                </button>
                <button class="btn btn-primary rounded-md px-4 py-2"
                    id="tomorrow-button">{{ __('news-modal.close') }}</button>
            </div>
        </div>
    </dialog>

    <script type="module">
        function toggleNews(value) {
            window.livewire.emit("toggleNews", value)
        }

        const cookieKey = "news_date"

        const cookie = document.cookie.split('; ').find(row => row.startsWith(cookieKey))
        const cookieValue = cookie ? cookie.split('=')[1] : null

        if (!cookieValue) toggleNews(true)

        function close(when) {
            const date = new Date()

            if (when === 'tomorrow')
                date.setDate(date.getDate() + 1)
            else if (when === 'later')
                date.setHours(date.getHours() + 6)

            document.cookie = `${cookieKey}=${date}; expires=${date.toUTCString()}; path=/`
            toggleNews(false)
        }


        document.getElementById('toggle-news').addEventListener('click', () => toggleNews(true))

        document.getElementById('later-button').addEventListener('click', () => close('later'))
        document.getElementById('tomorrow-button').addEventListener('click', () => close('tomorrow'))
    </script>
</div>
