<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view dashboard-admin']);
        Permission::create(['name' => 'view dashboard-superadmin']);

        //create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('view dashboard-admin');

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo('view dashboard-superadmin');

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole($adminRole);
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superAdmin@example.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole($superAdminRole);
    }
}
