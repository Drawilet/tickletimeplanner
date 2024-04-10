<div>
    @role('app.admin')
        @livewire('settings.app-settings-component')
    @endrole

    @role('tenant.admin')
        @livewire('settings.tenant-settings-component')
    @endrole
</div>
