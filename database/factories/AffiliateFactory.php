<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Affiliate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Affiliate>
 */
final class AffiliateFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Affiliate::class;

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
            'name' => $this->faker->name,
            'phone' => fake()->phoneNumber,
            'email' => fake()->safeEmail,
            'document' => fake()->word,
            'pix_key' => fake()->word,
            'user_id' => fake()->word,
        ];
    }
}
