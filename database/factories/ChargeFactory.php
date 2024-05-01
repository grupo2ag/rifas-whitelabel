<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Charge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Charge>
 */
final class ChargeFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Charge::class;

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
            'pix_id' => fake()->text,
            'pix_code' => fake()->text,
            'amount' => fake()->word,
            'json' => fake()->text,
            'expired' => fake()->optional()->datetime(),
            'participant_id' => \App\Models\Participant::factory(),
        ];
    }
}
