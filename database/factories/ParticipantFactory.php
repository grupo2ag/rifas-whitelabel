<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Participant>
 */
final class ParticipantFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Participant::class;

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
            'checked' => fake()->word,
            'msg_paid_sent' => fake()->optional()->word,
            'name' => fake()->name,
            'phone' => fake()->phoneNumber,
            'email' => fake()->optional()->safeEmail,
            'document' => fake()->optional()->word,
            'amount' => fake()->word,
            'numbers' => fake()->text,
            'paid' => fake()->optional()->word,
            'reserved' => fake()->optional()->word,
            'customer_id' => fake()->optional()->word,
            'raffle_id' => \App\Models\Raffle::factory(),
        ];
    }
}
