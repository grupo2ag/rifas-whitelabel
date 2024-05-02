<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(config('app.env') === 'local'){
            $this->call([
                UserSeeder::class,
                GatewaySeeder::class,
                RaffleSeeder::class,
                RaffleAwardSeeder::class,
                RafflePromotionSeeder::class
            ]);
        }else{
            //Producao
            $this->call([
                GatewaySeeder::class
            ]);
        }

    }
}
