<?php

namespace Database\Factories;

use App\Models\OlxPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OlxPrice>
 */
class OlxPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->text('5'),
            'link' => $this->faker->url()
        ];
    }
}
