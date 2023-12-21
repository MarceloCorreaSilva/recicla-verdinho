<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Swap extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'pet_bottles',
        'packaging_of_cleaning_materials',
        'tetra_pak',
        'aluminum_cans',
        'green_coin',
    ];

    protected function getTotalSwaps(): Attribute
    {
        $pet_bottles = static::getModel()->pet_bottles;
        $packaging_of_cleaning_materials = static::getModel()->packaging_of_cleaning_materials;
        $tetra_pak = static::getModel()->tetra_pak;
        $aluminum_cans = static::getModel()->aluminum_cans;

        $total = $pet_bottles + $packaging_of_cleaning_materials + $tetra_pak + $aluminum_cans;

        return Attribute::make(
            get: fn () => $total,
            set: fn (string $total) => $total,
        );
    }

    public static function totalSwaps()
    {
        $pet_bottles = static::getModel()::sum('pet_bottles');
        $packaging_of_cleaning_materials = static::getModel()::sum('packaging_of_cleaning_materials');
        $tetra_pak = static::getModel()::sum('tetra_pak');
        $aluminum_cans = static::getModel()::sum('aluminum_cans');

        return $pet_bottles + $packaging_of_cleaning_materials + $tetra_pak + $aluminum_cans;
    }

    public static function totalGreenCoins()
    {
        return static::getModel()::sum('green_coin');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
