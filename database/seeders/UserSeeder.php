<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected static ?string $password = 'verdinho';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        // app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::factory()->create(['name' => 'access_admin']);

        Permission::factory()->create(['name' => 'user_access']);
        Permission::factory()->create(['name' => 'user_read']);
        Permission::factory()->create(['name' => 'user_create']);
        Permission::factory()->create(['name' => 'user_update']);
        Permission::factory()->create(['name' => 'user_delete']);

        Permission::factory()->create(['name' => 'role_access']);
        Permission::factory()->create(['name' => 'role_read']);
        Permission::factory()->create(['name' => 'role_create']);
        Permission::factory()->create(['name' => 'role_update']);
        Permission::factory()->create(['name' => 'role_delete']);

        Permission::factory()->create(['name' => 'permission_access']);
        Permission::factory()->create(['name' => 'permission_read']);
        Permission::factory()->create(['name' => 'permission_create']);
        Permission::factory()->create(['name' => 'permission_update']);
        Permission::factory()->create(['name' => 'permission_delete']);

        Permission::factory()->create(['name' => 'state_access']);
        Permission::factory()->create(['name' => 'state_read']);
        Permission::factory()->create(['name' => 'state_create']);
        Permission::factory()->create(['name' => 'state_update']);
        Permission::factory()->create(['name' => 'state_delete']);

        Permission::factory()->create(['name' => 'city_access']);
        Permission::factory()->create(['name' => 'city_read']);
        Permission::factory()->create(['name' => 'city_create']);
        Permission::factory()->create(['name' => 'city_update']);
        Permission::factory()->create(['name' => 'city_delete']);

        Permission::factory()->create(['name' => 'school_access']);
        Permission::factory()->create(['name' => 'school_read']);
        Permission::factory()->create(['name' => 'school_create']);
        Permission::factory()->create(['name' => 'school_update']);
        Permission::factory()->create(['name' => 'school_delete']);

        Permission::factory()->create(['name' => 'coordinator_access']);
        Permission::factory()->create(['name' => 'coordinator_read']);
        Permission::factory()->create(['name' => 'coordinator_create']);
        Permission::factory()->create(['name' => 'coordinator_update']);
        Permission::factory()->create(['name' => 'coordinator_delete']);

        Permission::factory()->create(['name' => 'school_class_access']);
        Permission::factory()->create(['name' => 'school_class_read']);
        Permission::factory()->create(['name' => 'school_class_create']);
        Permission::factory()->create(['name' => 'school_class_update']);
        Permission::factory()->create(['name' => 'school_class_delete']);

        Permission::factory()->create(['name' => 'student_access']);
        Permission::factory()->create(['name' => 'student_read']);
        Permission::factory()->create(['name' => 'student_create']);
        Permission::factory()->create(['name' => 'student_update']);
        Permission::factory()->create(['name' => 'student_delete']);

        Permission::factory()->create(['name' => 'swap_access']);
        Permission::factory()->create(['name' => 'swap_read']);
        Permission::factory()->create(['name' => 'swap_create']);
        Permission::factory()->create(['name' => 'swap_update']);
        Permission::factory()->create(['name' => 'swap_delete']);

        Permission::factory()->create(['name' => 'financial_access']);
        Permission::factory()->create(['name' => 'financial_read']);
        Permission::factory()->create(['name' => 'financial_create']);
        Permission::factory()->create(['name' => 'financial_update']);
        Permission::factory()->create(['name' => 'financial_delete']);

        Permission::factory()->create(['name' => 'movement_access']);
        Permission::factory()->create(['name' => 'movement_read']);
        Permission::factory()->create(['name' => 'movement_create']);
        Permission::factory()->create(['name' => 'movement_update']);
        Permission::factory()->create(['name' => 'movement_delete']);

        // Permission::factory()->create(['name' => 'sponsor_access']);
        // Permission::factory()->create(['name' => 'sponsor_read']);
        // Permission::factory()->create(['name' => 'sponsor_create']);
        // Permission::factory()->create(['name' => 'sponsor_update']);
        // Permission::factory()->create(['name' => 'sponsor_delete']);

        // create roles and assign existing permissions
        $developer = Role::factory()->create(['name' => 'Developer']);
        $developer->givePermissionTo('access_admin');
        $developer->givePermissionTo('user_access');
        $developer->givePermissionTo('user_read');
        $developer->givePermissionTo('user_create');
        $developer->givePermissionTo('user_update');
        $developer->givePermissionTo('user_delete');
        $developer->givePermissionTo('role_access');
        $developer->givePermissionTo('role_read');
        $developer->givePermissionTo('role_create');
        $developer->givePermissionTo('role_update');
        $developer->givePermissionTo('role_delete');
        $developer->givePermissionTo('permission_access');
        $developer->givePermissionTo('permission_read');
        $developer->givePermissionTo('permission_create');
        $developer->givePermissionTo('permission_update');
        $developer->givePermissionTo('permission_delete');
        $developer->givePermissionTo('state_access');
        $developer->givePermissionTo('state_read');
        $developer->givePermissionTo('state_create');
        $developer->givePermissionTo('state_update');
        $developer->givePermissionTo('state_delete');
        $developer->givePermissionTo('city_access');
        $developer->givePermissionTo('city_read');
        $developer->givePermissionTo('city_create');
        $developer->givePermissionTo('city_update');
        $developer->givePermissionTo('city_delete');
        $developer->givePermissionTo('school_access');
        $developer->givePermissionTo('school_read');
        $developer->givePermissionTo('school_create');
        $developer->givePermissionTo('school_update');
        $developer->givePermissionTo('school_delete');
        $developer->givePermissionTo('coordinator_access');
        $developer->givePermissionTo('coordinator_read');
        $developer->givePermissionTo('coordinator_create');
        $developer->givePermissionTo('coordinator_update');
        $developer->givePermissionTo('coordinator_delete');
        $developer->givePermissionTo('school_class_access');
        $developer->givePermissionTo('school_class_read');
        $developer->givePermissionTo('school_class_create');
        $developer->givePermissionTo('school_class_update');
        $developer->givePermissionTo('school_class_delete');
        $developer->givePermissionTo('student_access');
        $developer->givePermissionTo('student_read');
        $developer->givePermissionTo('student_create');
        $developer->givePermissionTo('student_update');
        $developer->givePermissionTo('student_delete');
        $developer->givePermissionTo('swap_access');
        $developer->givePermissionTo('swap_read');
        $developer->givePermissionTo('swap_create');
        $developer->givePermissionTo('swap_update');
        $developer->givePermissionTo('swap_delete');
        // $developer->givePermissionTo('sponsor_access');
        // $developer->givePermissionTo('sponsor_read');
        // $developer->givePermissionTo('sponsor_create');
        // $developer->givePermissionTo('sponsor_update');
        // $developer->givePermissionTo('sponsor_delete');
        $developer->givePermissionTo('financial_access');
        $developer->givePermissionTo('financial_read');
        $developer->givePermissionTo('financial_create');
        $developer->givePermissionTo('financial_update');
        $developer->givePermissionTo('financial_delete');
        $developer->givePermissionTo('movement_access');
        $developer->givePermissionTo('movement_read');
        $developer->givePermissionTo('movement_create');
        $developer->givePermissionTo('movement_update');
        $developer->givePermissionTo('movement_delete');


        $admin = Role::factory()->create(['name' => 'Admin']);
        $admin->givePermissionTo('access_admin');
        $admin->givePermissionTo('user_access');
        $admin->givePermissionTo('user_read');
        $admin->givePermissionTo('user_create');
        $admin->givePermissionTo('user_update');
        $admin->givePermissionTo('user_delete');
        $admin->givePermissionTo('city_access');
        $admin->givePermissionTo('state_access');
        $admin->givePermissionTo('state_read');
        $admin->givePermissionTo('state_create');
        $admin->givePermissionTo('state_update');
        $admin->givePermissionTo('state_delete');
        $admin->givePermissionTo('city_read');
        $admin->givePermissionTo('city_create');
        $admin->givePermissionTo('city_update');
        $admin->givePermissionTo('city_delete');
        $admin->givePermissionTo('school_access');
        $admin->givePermissionTo('school_read');
        $admin->givePermissionTo('school_create');
        $admin->givePermissionTo('school_update');
        $admin->givePermissionTo('school_delete');
        $admin->givePermissionTo('coordinator_access');
        $admin->givePermissionTo('coordinator_read');
        $admin->givePermissionTo('coordinator_create');
        $admin->givePermissionTo('coordinator_update');
        $admin->givePermissionTo('coordinator_delete');
        $admin->givePermissionTo('school_class_access');
        $admin->givePermissionTo('school_class_read');
        $admin->givePermissionTo('school_class_create');
        $admin->givePermissionTo('school_class_update');
        $admin->givePermissionTo('school_class_delete');
        $admin->givePermissionTo('student_access');
        $admin->givePermissionTo('student_read');
        $admin->givePermissionTo('student_create');
        $admin->givePermissionTo('student_update');
        $admin->givePermissionTo('student_delete');
        $admin->givePermissionTo('swap_access');
        $admin->givePermissionTo('swap_read');
        $admin->givePermissionTo('swap_create');
        $admin->givePermissionTo('swap_update');
        $admin->givePermissionTo('swap_delete');
        $admin->givePermissionTo('financial_access');
        $admin->givePermissionTo('financial_read');
        $admin->givePermissionTo('financial_create');
        $admin->givePermissionTo('financial_update');
        $admin->givePermissionTo('financial_delete');
        $admin->givePermissionTo('movement_access');
        $admin->givePermissionTo('movement_read');
        $admin->givePermissionTo('movement_create');
        $admin->givePermissionTo('movement_update');
        $admin->givePermissionTo('movement_delete');

        $coordinator = Role::factory()->create(['name' => 'Coordenador']);
        $coordinator->givePermissionTo('access_admin');
        $coordinator->givePermissionTo('school_access');
        $coordinator->givePermissionTo('school_read');
        // $coordinator->givePermissionTo('school_create');
        // $coordinator->givePermissionTo('school_update');
        // $coordinator->givePermissionTo('school_delete');
        $coordinator->givePermissionTo('school_class_access');
        $coordinator->givePermissionTo('school_class_read');
        // $coordinator->givePermissionTo('school_class_create');
        // $coordinator->givePermissionTo('school_class_update');
        // $coordinator->givePermissionTo('school_class_delete');
        $coordinator->givePermissionTo('student_access');
        $coordinator->givePermissionTo('student_read');
        // $coordinator->givePermissionTo('student_create');
        // $coordinator->givePermissionTo('student_update');
        // $coordinator->givePermissionTo('student_delete');
        $coordinator->givePermissionTo('swap_access');
        $coordinator->givePermissionTo('swap_read');
        $coordinator->givePermissionTo('swap_create');
        // $coordinator->givePermissionTo('swap_update');
        // $coordinator->givePermissionTo('swap_delete');
        $coordinator->givePermissionTo('financial_access');
        $coordinator->givePermissionTo('financial_read');
        // $coordinator->givePermissionTo('financial_create');
        // $coordinator->givePermissionTo('financial_update');
        // $coordinator->givePermissionTo('financial_delete');
        $coordinator->givePermissionTo('movement_access');
        $coordinator->givePermissionTo('movement_read');
        // $coordinator->givePermissionTo('movement_create');
        // $coordinator->givePermissionTo('movement_update');
        // $coordinator->givePermissionTo('movement_delete');

        // create demo users
        $userDeveloper = User::factory()->create(['name' => 'Developer', 'email' => 'developer@mail.com', 'password' => static::$password]);
        $userDeveloper->assignRole($developer);

        $userAdmin = User::factory()->create(['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => static::$password]);
        $userAdmin->assignRole($admin);

        // $userCoordinator = User::factory()->create(['name' => 'Coordenador 1', 'email' => 'coordenador@mail.com', 'password' => static::$password]);
        // $userCoordinator->assignRole($coordinator);

        // $userCoordinator = User::factory()->create(['name' => 'Coordenador 2', 'email' => 'coordenador2@mail.com', 'password' => static::$password]);
        // $userCoordinator->assignRole($coordinator);
    }
}
