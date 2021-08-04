<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Super Admin',
            'phone' => '00201401234567',
            'email' => 'admin@email.com',
            'password' => bcrypt('123456'),
            'address' => 'Egypt, Cairo',
            'remember_token' => Str::random(10)
        ]);
    }
}
