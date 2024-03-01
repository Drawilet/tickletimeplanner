<div>
    @include('livewire.dashboard.delete-modal')

    @include('livewire.dashboard.save-modal')

    @livewire('dashboard.calendar-component', [
        'dragAndDropEnabled' => false,
        'beforeCalendarView' => '/livewire/dashboard/filter-component',
    ])
</div>
