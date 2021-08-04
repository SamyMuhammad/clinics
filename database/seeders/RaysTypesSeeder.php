<?php

namespace Database\Seeders;

use App\Models\RaysTypes;
use Illuminate\Database\Seeder;

class RaysTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RaysTypes::factory()
            ->count(10)
            ->create();
    }
}
