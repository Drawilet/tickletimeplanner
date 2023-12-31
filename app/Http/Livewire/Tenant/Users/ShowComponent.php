<?php

namespace App\Http\Livewire\Tenant\Users;

use App\Http\Livewire\Util\CrudComponent;
use App\Events\UserEvent;
use App\Http\Livewire\Users\PermissionsComponent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ShowComponent extends CrudComponent
{
    public $events = ["beforeOpenSaveModal", "beforeSave", "afterSave"];
    public function beforeOpenSaveModal($user)
    {
        $data = $user->toArray();
        if (isset($user["password"])) unset($data["password"]);
        $data["permissions"] =   $user->permissions->pluck("name")->toArray();

        return $data;
    }

    public function beforeSave($data)
    {
        if (isset($data["password"])) {
            $data["password"] = Hash::make($data["password"]);
        }
        return $data;
    }

    public function afterSave($user, $data)
    {
        if (isset($data["permissions"]))
            $user->syncPermissions($data["permissions"]);
    }

    public function mount()
    {
        $this->setup(User::class, UserEvent::class, [
            "mainKey" => "name",
            "types" => [
                "name" => ["type" => "text"],
                "email" => ["type" => "email"],
                "password" => [
                    "type" => "password",
                    "hidden" => true,
                ],
                "permissions" => [
                    "type" => "array",
                    "hidden" => true,
                    "component" => PermissionsComponent::class
                ],
            ],
        ]);
    }
}
