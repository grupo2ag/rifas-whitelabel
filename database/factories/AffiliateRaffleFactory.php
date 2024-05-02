<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AffiliateRaffle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\AffiliateRaffle>
 */
final class AffiliateRaffleFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = AffiliateRaffle::class;

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
            'affiliate_id' => \App\Models\Affiliate::factory(),
            'raffle_id' => \App\Models\Raffle::factory(),
            'actived' => fake()->word,
            'type' => fake()->word,
            'value' => fake()->optional()->word,
        ];
    }
}
