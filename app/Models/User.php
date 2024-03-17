<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessFilament(): bool
    {
        return $this->hasPermissionTo('access_admin');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // public function cities(): BelongsToMany
    // {
    //     return $this->belongsToMany(City::class, 'city_has_users');
    // }

    // public function city(): BelongsToMany
    // {
    //     return $this->belongsToMany(City::class, 'city_has_users');
    // }

    public function secretary(): ?HasOne
    {
        return $this->hasOne(City::class, 'manager_id');
    }

    public function manager(): ?HasOne
    {
        return $this->hasOne(School::class, 'manager_id');
    }

    public function coordinator(): ?HasOne
    {
        return $this->hasOne(School::class, 'coordinator_id');
    }
}
