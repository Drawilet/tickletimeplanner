<x-app-layout>
    @role('app.admin')
        @livewire('dashboard.admin-dashboard-component')
    @else
        @livewire('dashboard.user-dashboard-component')
    @endrole
</x-app-layout>
