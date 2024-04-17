<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Monthly',
            'price' => 99,
            'duration' => 1,
            'duration_unit' => 'month',
        ]);

        Plan::create([
            'name' => 'Trimestral',
            'price' => 249,
            'duration' => 3,
            'duration_unit' => 'month',
        ]);

        Plan::create([
            'name' => 'Yearly',
            'price' => 999,
            'duration' => 1,
            'duration_unit' => 'year',
        ]);


    }
}
