<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_class_id',
        'registration',
        'name',
        'gender'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function school_class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function swaps(): HasMany
    {
        return $this->hasMany(Swap::class);
    }

    protected function itensCount(): Attribute
    {
        $total = 0;

        $swaps = $this->swaps()
            ->selectRaw('
                SUM(pet_bottles) as total_pet_bottles,
                SUM(packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(tetra_pak) as total_tetra_pak,
                SUM(aluminum_cans) as total_aluminum_cans
            ')
            ->get();

        $total = $swaps[0]['total_pet_bottles'] + $swaps[0]['total_packaging_of_cleaning_materials'] + $swaps[0]['total_tetra_pak'] + $swaps[0]['total_aluminum_cans'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }

    protected function greencoinsCount(): Attribute
    {
        $total = 0;

        $swaps = $this->swaps()
            ->selectRaw('
                SUM(green_coin) as total_green_coin
            ')
            ->get();

        $total = $swaps[0]['total_green_coin'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }
}
