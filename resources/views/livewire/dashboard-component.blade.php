<div>
    <section class="flex flex-col md:flex-row justify-between mb-3">
        <div class="flex items-center mb-2 md:mb-0">
            <button type="button" title="Previous month"onclick="calendar.prev()" aria-pressed="false" class="btn ">
                <span class="fc-icon fc-icon-chevron-left" role="img"></span>
            </button>

            <button type="button" title="Next month" onclick="calendar.next()" aria-pressed="false" class="btn ">
                <span class="fc-icon fc-icon-chevron-right" role="img"></span>
            </button>

            <h2 class="text-2xl ml-2" id="title"></h2>
        </div>

        <div>
            <select class="select select-bordered" wire:model="filters.space_id">
                <option value="{{ null }}">All</option>
                @foreach ($spaces as $space)
                    <option value="{{ $space->id }}">{{ $space->name }}
                    </option>
                @endforeach
            </select>

            <select class="select select-bordered" wire:model="filters.view_type" wire:change="changeView">
                <option value="timeGrid">Day</option>
                <option value="listWeek">Week</option>
                <option value="dayGridMonth">Month</option>
            </select>
        </div>

    </section>

    <div id='calendar' class="max-h-screen"></div>

    <x-dialog-modal wire:model="modals.new">
        <x-slot name="title">
            <h3 class="text-2xl">New Event</h3>
        </x-slot>

        <x-slot name="content">
            <section>
                <x-form-control>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" name="name" wire:model="data.name" />
                    <x-input-error for="data.name" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="space_id" value="{{ __('Space') }}" />
                    <select class="select select-bordered" wire:model="data.space_id">
                        <option value="{{ null }}">Pick one</option>
                        @foreach ($spaces as $space)
                            <option value="{{ $space->id }}">{{ $space->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="data.space_id" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="customer_id" value="{{ __('Customer') }}" />
                    <select class="select select-bordered" wire:model="data.customer_id">
                        <option value="{{ null }}">Pick one</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->firstname }}
                                {{ $customer->lastname }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="data.customer_id" class="mt-2" />
                </x-form-control>

                <div class="divider"></div>

                <x-form-control>
                    <x-label for="date" value="{{ __('Date') }}" />
                    <x-input id="date" name="date" type="date" wire:model="data.date" />
                    <x-input-error for="data.date" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="start_time" value="{{ __('Start time') }}" />
                    <x-input id="start_time" name="start_time" type="time" wire:model="data.start_time" />
                    <x-input-error for="data.start_time" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="end_time" value="{{ __('End time') }}" />
                    <x-input id="end_time" name="end_time" type="time" wire:model="data.end_time" />
                    <x-input-error for="data.end_time" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="price" value="{{ __('Price') }}" />
                    <x-input id="price" name="price" type="number" wire:model="data.price" />
                    <x-input-error for="data.price" class="mt-2" />
                </x-form-control>

                <x-form-control>
                    <x-label for="notes" value="{{ __('Notes') }}" />
                    <textarea id="notes" name="notes" class="textarea textarea-bordered" wire:model="data.notes"></textarea>
                    <x-input-error for="data.notes" class="mt-2" />
                </x-form-control>
            </section>
        </x-slot>

        <x-slot name="footer">
            <x-button class="ml-4" wire:click="newEvent">
                {{ __('Add') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        function openModal(info) {
            const data = {}
            const dateValue = info.dateStr.split("T");
            data.date = dateValue[0];
            if (dateValue[1]) {
                const timeValue = dateValue[1].split(":00-");
                data.start_time = timeValue[0];
                data.end_time = timeValue[0];
            }

            Livewire.emit('Modal', "new", true, data);
        };

        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: false,
            dateClick: openModal,
            initialView: "dayGridMonth",
            events: [
                @foreach ($showingEvents as $event)
                    {
                        id: '{{ $event->id }}',
                        title: '{{ $event->name }}',
                        start: '{{ $event->date }}T{{ $event->start_time }}',
                        end: '{{ $event->date }}T{{ $event->end_time }}',
                    },
                @endforeach
            ],
            dayCellDidMount: function(info) {
                document.getElementById('title').innerText = info.view.title;
            },
        });
        calendar.render();

        /*   window.livewire.on("changeView", (view) => {
              calendar.changeView(view);
          }); */
    </script>
</div>
