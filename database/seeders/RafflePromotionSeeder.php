<?php

namespace Database\Seeders;

use App\Models\Raffle;
use App\Models\RafflePromotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RafflePromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $raffles = Raffle::all();
        foreach ($raffles as $key => $raffle) {
            RafflePromotion::create([
                'order' => $key + 1,
                'quantity_numbers' => 100,
                'discount' => 1,
                'amount' => 99,
                'raffle_id' => $raffle->id
            ]);
        }
    }
}
