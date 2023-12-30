<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function totalMaterials(): Attribute
    {
        $total = 0;

        $swaps = $this->school_classes()
            ->selectRaw('
                SUM(swaps.pet_bottles) as total_pet_bottles,
                SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(swaps.tetra_pak) as total_tetra_pak,
                SUM(swaps.aluminum_cans) as total_aluminum_cans,
                SUM(swaps.green_coin) as total_green_coin
            ')

            ->join('students', 'students.school_class_id', '=', 'school_classes.id')
            ->join('swaps', 'swaps.student_id', '=', 'students.id')
            ->get();

        $total = $swaps[0]['total_pet_bottles'] + $swaps[0]['total_packaging_of_cleaning_materials'] + $swaps[0]['total_tetra_pak'] + $swaps[0]['total_aluminum_cans'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }

    protected function totalGreenCoins(): Attribute
    {
        $total = 0;

        $swaps = $this->school_classes()
            ->selectRaw('
            SUM(swaps.pet_bottles) as total_pet_bottles,
            SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
            SUM(swaps.tetra_pak) as total_tetra_pak,
            SUM(swaps.aluminum_cans) as total_aluminum_cans,
            SUM(swaps.green_coin) as total_green_coin
        ')
            ->join('students', 'students.school_class_id', '=', 'school_classes.id')
            ->join('swaps', 'swaps.student_id', '=', 'students.id')
            ->get();

        $total = $swaps[0]['total_green_coin'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }

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
