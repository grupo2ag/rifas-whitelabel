<?php

namespace Database\Seeders;

use App\Models\Raffle;
use App\Models\RaffleAward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaffleAwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $raffles = Raffle::all();
        foreach ($raffles as $key => $raffle) {
            RaffleAward::create([
                'order' => $key + 1,
                'description' => fake()->name(),
                'winner_name' => null,
                'winner_image' => null,
                'winner_phone' => null,
                'number_award' => null,
                'raffle_id' => $raffle->id
            ]);
        }
    }
}
