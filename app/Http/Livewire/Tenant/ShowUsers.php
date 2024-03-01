<?php

namespace App\Http\Livewire\Tenant;

use App\Http\Livewire\Util\CrudComponent;
use App\Http\Livewire\Users\PermissionsComponent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ShowUsers extends CrudComponent
{
    public $events = ['beforeOpenSaveModal', 'beforeSave', 'afterSave'];
    public function beforeOpenSaveModal($user)
    {
        $data = $user->toArray();
        if (isset($user['password'])) {
            unset($data['password']);
        }
        $data['permissions'] = $user->permissions->pluck('name')->toArray();

        return $data;
    }

    public function beforeSave($data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }

    public function afterSave($user, $data)
    {
        if (isset($data['permissions'])) {
            $user->syncPermissions($data['permissions']);
        }
    }

    public function mount()
    {
        $this->setup(User::class, [
            'mainKey' => 'name',
            'getItems' => false,
            'types' => [
                'name' => ['type' => 'text'],
                'email' => ['type' => 'email'],
                'password' => [
                    'type' => 'password',
                    'hidden' => true,
                ],
                'permissions' => [
                    'type' => 'array',
                    'hidden' => true,
                    'component' => PermissionsComponent::class,
                ],
            ],
        ]);

        $user = auth()->user();
        $this->items = User::where('tenant_id', $user->tenant_id)
            ->where('id', '<>', $user->id)
            ->get();
    }
}
