<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user[0] = [
            'id' => 1,
            'name' => 'Figueiredo',
            'email' => 'rafael@l8.vc',
            'level' => 0,
            'domain' => 'rifa-whitelabel.test',
            'password' => Hash::make('123Qwe@#')
        ];

        $user[1] = [
            'id' => 2,
            'name' => 'Figueiredo',
            'email' => 'rafael@premiofacil.com.br',
            'level' => 1,
            'domain' => 'premiofacil.com.br',
            'password' => Hash::make('123Qwe@#')
        ];

        \App\Models\User::insert($user);
    }
}
