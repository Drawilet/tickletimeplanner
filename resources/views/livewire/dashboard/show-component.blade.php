<div>
    @include('livewire.dashboard.delete-modal')

    @livewire('dashboard.news-modal-component')

    @include('livewire.dashboard.save-modal')

    @livewire('dashboard.calendar-component', [
        'events' => $events,
        'dragAndDropEnabled' => false,
        'beforeCalendarView' => '/livewire/dashboard/filter-component',
    ])

    @component('components.util.crud-socket-scripts', ['socketListeners' => $socketListeners])
    @endcomponent
</div>
