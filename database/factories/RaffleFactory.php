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
        $quantity = 100000;
        $price = 100;
        $total = $price * $quantity;

        return [
            'title' => fake()->jobTitle,
            'subtitle' => fake()->word,
            'pix_expired' => 5,//fake()->unixTime(new DateTime('+5 weeks')),
            'buyer_ranking' => rand(1,4),
            'link' => fake()->url,
            'price' => $price,
            'total' => $total,
            'status' => 'Ativo',
            'quantity' => $quantity,
            'numbers' => numbers_generate($quantity),
            'type' => 'automatico', //manual
            'highlight' => 1,
            'minimum_purchase' => 5,
            'maximum_purchase' => 1000,
            'visible' => 1,
            'user_id' => \App\Models\User::where('id', 2)->first()->id,
            'partial' => 1,
            'description' => fake()->text,
            'video' => null,
            'gateway_id' => 1,
        ];
    }
}
