<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'ferco_clpm@hotmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$caXpB3QUwT0e/GaeesAVCOlysW9Ap/tL/Jv0rsWkBwyPSXdAbV8kW',
                'remember_token' => 'nrPg7ktwN2vWH1TSVKrUZyJMIRI4H797MRYeWxaIzAyTGEJLahBI0ekbhugF',
                'created_at' => '2026-03-12 19:41:24',
                'updated_at' => '2026-03-12 19:41:24',
            ],
        ]);
    }
}
