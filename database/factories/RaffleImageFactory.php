<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\RaffleImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RaffleImage>
 */
final class RaffleImageFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = RaffleImage::class;

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
            'path' => fake()->optional()->text,
            'raffle_id' => \App\Models\Raffle::factory(),
        ];
    }
}
