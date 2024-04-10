@role('app.admin')
    @livewire('settings.app-settings-component')
@else
    @livewire('settings.tenant-settings-component')
@endrole
