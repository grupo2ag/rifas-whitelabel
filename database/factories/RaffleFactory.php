<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Raffle;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Raffle>
 */
final class RaffleFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Raffle::class;

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
        $quantity = random_int(1, 10);
        $price = 100;
        $total = $price * $quantity;

        return [
            'title' => fake()->title,
            'subtitle' => fake()->optional()->word,
            'pix_expired' => fake()->unixTime(new DateTime('+3 weeks')),
            'buyer_ranking' => rand(1,4),
            'link' => fake()->url,
            'price' => $price,
            'total' => $total,
            'status' => fake()->word,
            'quantity' => fake()->word,
            'numbers' => fake()->optional()->text,
            'type' => fake()->word,
            'highlight' => fake()->word,
            'minimum_purchase' => fake()->word,
            'maximum_purchase' => fake()->word,
            'visible' => fake()->word,
            'user_id' => \App\Models\User::factory(),
            'partial' => fake()->word,
            'description' => fake()->optional()->text,
            'video' => fake()->optional()->word,
            'gateway_id' => \App\Models\Gateway::factory(),
        ];
    }
}
