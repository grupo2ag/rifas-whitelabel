<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Customer>
 */
final class CustomerFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Customer::class;

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    public function withFaker()
    {
        $faker = \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
        $faker->addProvider(new \Faker\Provider\pt_br\Address($faker));
        $faker->addProvider(new \Faker\Provider\pt_br\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\pt_br\Company($faker));
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
            'name' => fake()->name,
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail,
            'cpf' => $this->faker->cpf(false),
        ];
    }
}
