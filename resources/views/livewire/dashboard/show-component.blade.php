<div>
    @include('livewire.dashboard.delete-modal')

    @include('livewire.dashboard.save-modal')

    @livewire('dashboard.calendar-component', [
        'events' => $events,
        'dragAndDropEnabled' => false,
        'beforeCalendarView' => '/livewire/dashboard/filter-component',
    ])
</div>
