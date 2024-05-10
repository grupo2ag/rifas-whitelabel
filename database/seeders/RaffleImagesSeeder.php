<?php

namespace Database\Seeders;

use App\Models\Raffle;
use App\Models\RaffleImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaffleImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $raffles = Raffle::all();
        foreach ($raffles as $key => $raffle) {
            RaffleImage::create([
                'path' => fake()->name(),
                'highlight' => 0,
                'raffle_id' => $raffle->id
            ]);
        }
    }
}
