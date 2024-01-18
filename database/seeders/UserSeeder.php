<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant = Tenant::factory()->create();

        $user =  User::factory()->create(
            [
                "name" => "admin",
                "email" => "admin@example.com",
                "tenant_id" => $tenant->id,
            ]
        );
        $user->assignRole("tenant.admin");
        $user->assignRole("app.admin");
    }
}
