<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            "tenant.admin" =>
            [
                "customers.manage",
                "customers.show",

                "products.manage",
                "products.show",

                "spaces.manage",
                "spaces.show",

                "payments.manage",
                "payments.show",

                "users.manage",
                "users.show",
            ],
        ];

        foreach ($roles as $role => $permissions) {
            $role = Role::create(["name" => $role]);
            foreach ($permissions as $permission) {
                Permission::create(["name" => $permission]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
