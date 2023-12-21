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

        Permission::factory()->create(['name' => 'sponsor_access']);
        Permission::factory()->create(['name' => 'sponsor_read']);
        Permission::factory()->create(['name' => 'sponsor_create']);
        Permission::factory()->create(['name' => 'sponsor_update']);
        Permission::factory()->create(['name' => 'sponsor_delete']);

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
        $developer->givePermissionTo('sponsor_access');
        $developer->givePermissionTo('sponsor_read');
        $developer->givePermissionTo('sponsor_create');
        $developer->givePermissionTo('sponsor_update');
        $developer->givePermissionTo('sponsor_delete');

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
        // $admin->givePermissionTo('sponsor_access');
        // $admin->givePermissionTo('sponsor_read');
        // $admin->givePermissionTo('sponsor_create');
        // $admin->givePermissionTo('sponsor_update');
        // $admin->givePermissionTo('sponsor_delete');


        // $manager = Role::factory()->create(['name' => 'Manager']);
        // $manager->givePermissionTo('access_admin');
        // // $manager->givePermissionTo('city_access');
        // // $manager->givePermissionTo('city_read');
        // // $manager->givePermissionTo('city_create');
        // // $manager->givePermissionTo('city_update');
        // // $manager->givePermissionTo('city_delete');
        // $manager->givePermissionTo('school_access');
        // $manager->givePermissionTo('school_read');
        // $manager->givePermissionTo('school_create');
        // $manager->givePermissionTo('school_update');
        // $manager->givePermissionTo('school_delete');
        // $manager->givePermissionTo('school_class_access');
        // $manager->givePermissionTo('school_class_read');
        // // $manager->givePermissionTo('school_class_create');
        // // $manager->givePermissionTo('school_class_update');
        // // $manager->givePermissionTo('school_class_delete');
        // $manager->givePermissionTo('student_access');
        // $manager->givePermissionTo('student_read');
        // $manager->givePermissionTo('student_create');
        // $manager->givePermissionTo('student_update');
        // $manager->givePermissionTo('student_delete');
        // $manager->givePermissionTo('swap_access');
        // $manager->givePermissionTo('swap_read');
        // // $manager->givePermissionTo('swap_create');
        // // $manager->givePermissionTo('swap_update');
        // // $manager->givePermissionTo('swap_delete');
        // $manager->givePermissionTo('sponsor_access');
        // $manager->givePermissionTo('sponsor_read');
        // // $manager->givePermissionTo('sponsor_create');
        // // $manager->givePermissionTo('sponsor_update');
        // // $manager->givePermissionTo('sponsor_delete');

        $coordinator = Role::factory()->create(['name' => 'Coordinator']);
        $coordinator->givePermissionTo('access_admin');
        $coordinator->givePermissionTo('school_access');
        $coordinator->givePermissionTo('school_read');
        // $coordinator->givePermissionTo('school_create');
        // $coordinator->givePermissionTo('school_update');
        // $coordinator->givePermissionTo('school_delete');
        $coordinator->givePermissionTo('school_class_access');
        $coordinator->givePermissionTo('school_class_read');
        $coordinator->givePermissionTo('school_class_create');
        $coordinator->givePermissionTo('school_class_update');
        $coordinator->givePermissionTo('school_class_delete');
        $coordinator->givePermissionTo('student_access');
        $coordinator->givePermissionTo('student_read');
        $coordinator->givePermissionTo('student_create');
        $coordinator->givePermissionTo('student_update');
        $coordinator->givePermissionTo('student_delete');
        $coordinator->givePermissionTo('swap_access');
        $coordinator->givePermissionTo('swap_read');
        $coordinator->givePermissionTo('swap_create');
        $coordinator->givePermissionTo('swap_update');
        $coordinator->givePermissionTo('swap_delete');

        // create demo users
        $userDeveloper = User::factory()->create(['name' => 'Developer', 'email' => 'developer@mail.com', 'password' => static::$password]);
        $userDeveloper->assignRole($developer);

        $userAdmin = User::factory()->create(['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => static::$password]);
        $userAdmin->assignRole($admin);

        // $userManager = User::factory()->create(['name' => 'Manager', 'email' => 'manager@mail.com', 'password' => static::$password]);
        // $userManager->assignRole($manager);

        $userCoordinator = User::factory()->create(['name' => 'Coordenador', 'email' => 'coordenador@mail.com', 'password' => static::$password]);
        $userCoordinator->assignRole($coordinator);
    }
}
