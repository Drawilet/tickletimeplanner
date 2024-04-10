<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = Tenant::factory()->count(10)->create();
        foreach ($tenants as $tenant) {
            $admin = $tenant->users()->create([
                'name' => 'Admin ' . $tenant->name,
                'email' => 'admin@' . $tenant->name . ".com",
                'password' => bcrypt('password'),
                "email_verified_at" => now(),
            ]);
            $admin->assignRole('tenant.admin');

            Customer::factory()->count(10)->create(['tenant_id' => $tenant->id]);
        }
    }
}
