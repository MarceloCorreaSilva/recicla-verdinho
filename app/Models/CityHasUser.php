<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CityHasUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'city_has_users';

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
