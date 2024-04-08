<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsComponent extends Component
{
    protected $listeners = ['update-data' => 'handleData'];

    public $data = [
        'permissions' => [],
    ];
    public function handleData($data)
    {
        if (isset ($data['permissions'])) {
            $this->data['permissions'] = $data['permissions'];
        }
    }

    public $permissions;
    public function mount()
    {
        $this->permissions = Permission::where('name', 'like', 'tenant.%')->get();
    }

    public function render()
    {
        return view('livewire.users.permissions-component');
    }

    public function togglePermission($permission)
    {
        if (in_array($permission, $this->data['permissions'])) {
            $this->data['permissions'] = array_diff($this->data['permissions'], [$permission]);
        } else {
            $this->data['permissions'][] = $permission;
        }

        $this->emit('update-data', $this->data);
    }

    public function parseName($name)
    {
        $split = explode('.', $name);
        return $split[1] . ' ' . $split[0];
    }
}
