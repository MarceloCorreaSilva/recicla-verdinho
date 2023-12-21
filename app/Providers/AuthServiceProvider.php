<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\City;
use App\Models\Permission;
use App\Models\Role;
use App\Models\School;
use App\Models\State;
use App\Models\Student;
use App\Models\Swap;
use App\Models\User;
use App\Models\User as Coordinator;
use App\Policies\CityPolicy;
use App\Policies\CoordinatorPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SchoolPolicy;
use App\Policies\StatePolicy;
use App\Policies\StudentPolicy;
use App\Policies\SwapPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        State::class => StatePolicy::class,
        City::class => CityPolicy::class,
        School::class => SchoolPolicy::class,
        Coordinator::class => CoordinatorPolicy::class,
        Student::class => StudentPolicy::class,
        Swap::class => SwapPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
