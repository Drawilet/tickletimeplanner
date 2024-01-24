<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->company(),
            "description" => $this->faker->text(),
            "phone" => $this->faker->phoneNumber(),
            "email" => $this->faker->email(),
            /*   "social_nets" => [
                [
                    "url" => $this->faker->url(),
                    "icon" => "components/icons/default-link"
                ]
            ], */
        ];
    }
}
