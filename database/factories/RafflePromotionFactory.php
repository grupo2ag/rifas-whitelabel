<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\RafflePromotion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RafflePromotion>
 */
final class RafflePromotionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = RafflePromotion::class;

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
            'quantity_numbers' => fake()->word,
            'ordem' => fake()->word,
            'discount' => fake()->word,
            'amount' => fake()->word,
            'raffle_id' => \App\Models\Raffle::factory(),
        ];
    }
}
