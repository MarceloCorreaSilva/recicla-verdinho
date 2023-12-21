<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_class_id',
        'name'
    ];

    public function school_class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function swaps(): HasMany
    {
        return $this->hasMany(Swap::class);
    }
}
