<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'Super Admin', 'ar_name' => 'مدير الموقع', 'guard_name' => 'admin']);
        $adminsPermissions = Permission::where('guard_name', 'admin')->get()->pluck('id');
        $superAdmin->syncPermissions($adminsPermissions);
        Admin::first()->assignRole('Super Admin');

        $usersPermissions = Permission::where('guard_name', 'web')->get()->pluck('id');
        User::first()->givePermissionTo($usersPermissions);
        // User::find(2)->givePermissionTo($usersPermissions);
    }
}
