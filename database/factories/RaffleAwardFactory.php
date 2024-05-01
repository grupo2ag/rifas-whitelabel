<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\RaffleAward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RaffleAward>
 */
final class RaffleAwardFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = RaffleAward::class;

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
            'ordem' => fake()->optional()->word,
            'descricao' => fake()->text,
            'winner_name' => fake()->optional()->text,
            'winner_image' => fake()->optional()->text,
            'winner_phone' => fake()->optional()->word,
            'number_award' => fake()->optional()->word,
            'raffle_id' => \App\Models\Raffle::factory(),
        ];
    }
}
