<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ChargePaid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ChargePaid>
 */
final class ChargePaidFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = ChargePaid::class;

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'e2e' => fake()->word,
            'paied_date' => fake()->datetime(),
            'charge_id' => \App\Models\Charge::factory(),
            'json_response' => fake()->optional()->text,
        ];
    }
}
