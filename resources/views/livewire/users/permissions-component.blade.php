<div class="px-5">
    <table class="w-full">
        <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td class="capitalize">{{ trans('User-lang.'.strtolower($permission->name))}}</td>
                    <td>
                        <input type="checkbox" class="toggle toggle-primary"
                            wire:change='togglePermission("{{ $permission->name }}")' @checked(in_array($permission->name, $data['permissions'])) />
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
