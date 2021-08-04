<?php

namespace Database\Seeders;

use Str;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Doctor User',
            'phone' => '00201401234567',
            'email' => 'user@email.com',
            'password' => bcrypt('123456'),
            'address' => 'Egypt, Cairo',
            'salary' => 6000,
            'contract_period' => '1 year',
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Technician User',
            'phone' => '00201401234552',
            'email' => 'tech@email.com',
            'password' => bcrypt('123456'),
            'job' => 'ray_technician',
            'address' => 'Egypt, Cairo',
            'salary' => 6000,
            'contract_period' => '1 year',
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Test Resposible User',
            'phone' => '00201401234513',
            'email' => 'test_responsible@email.com',
            'password' => bcrypt('123456'),
            'job' => 'test_responsible',
            'address' => 'Egypt, Cairo',
            'salary' => 6000,
            'contract_period' => '1 year',
            'remember_token' => Str::random(10)
        ]);
    }
}
