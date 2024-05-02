<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AffiliateGain;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\AffiliateGain>
 */
final class AffiliateGainFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = AffiliateGain::class;

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
            'amount' => fake()->optional()->word,
            'participant_id' => \App\Models\Participant::factory(),
            'raffle_id' => \App\Models\AffiliateRaffle::factory(),
            'affiliate_id' => fake()->word,
            'paied' => fake()->word,
        ];
    }
}
