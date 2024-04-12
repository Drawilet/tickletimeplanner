<x-app-layout>
    @role('app.admin')
        @livewire('settings.app-settings-component')
    @else
        @livewire('settings.tenant-settings-component')
    @endrole
</x-app-layout>
