<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'coordinator_id',
        'name',
        'project_started',
        'project_completed',
        'active'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school_classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }
}
