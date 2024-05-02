<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\UserConfiguration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\UserConfiguration>
 */
final class UserConfigurationFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = UserConfiguration::class;

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
            'id' => fake()->word,
            'primary_color' => fake()->optional()->word,
            'logo' => fake()->optional()->text,
            'meta_description' => fake()->optional()->text,
            'meta_keywords' => fake()->optional()->text,
            'meta_image' => fake()->optional()->text,
            'favicon' => fake()->optional()->text,
            'site_title' => fake()->optional()->text,
            'site_subtitle' => fake()->optional()->text,
            'privacy' => fake()->optional()->text,
            'about_us' => fake()->optional()->text,
            'terms_conditions' => fake()->optional()->text,
            'facebook' => fake()->optional()->text,
            'instagram' => fake()->optional()->text,
            'twitter' => fake()->optional()->text,
            'youtube' => fake()->optional()->text,
            'google_analytics' => fake()->optional()->text,
            'facebook_pixel' => fake()->optional()->text,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
