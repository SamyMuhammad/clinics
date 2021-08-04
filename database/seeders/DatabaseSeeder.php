<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            ClinicSeeder::class,
            RaysTypesSeeder::class,
            MedicalTestSeeder::class,
            CompanySeeder::class,
            DiscountSeeder::class,
        ]);
    }
}
