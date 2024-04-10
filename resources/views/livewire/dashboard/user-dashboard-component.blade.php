<div class="w-full">
    @include('livewire.dashboard.user-dashboard.delete-modal')

    @include('livewire.dashboard.user-dashboard.save-modal')

    @livewire('dashboard.user-dashboard.calendar-component', [
        'dragAndDropEnabled' => false,
        'beforeCalendarView' => '/livewire/dashboard/filter-component',
    ])
</div>
