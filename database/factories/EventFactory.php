<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "space_id" => $this->faker->numberBetween(1, 2,),
            "customer_id" => $this->faker->numberBetween(1, 10,),
            "date" => $this->faker->dateTimeBetween('now', '+1 month'),
            "start_time" => $this->faker->time(),
            "end_time" => $this->faker->time(),
            "price" => $this->faker->randomFloat(2, 100, 1000,),
            "tenant_id" => "1",
        ];
    }
}
