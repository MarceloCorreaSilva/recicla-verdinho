<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'state_id',
        'name',
        'secretary_id',
        'active'
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

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function secretary(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }

    protected function totalMaterials(): Attribute
    {
        $total = 0;

        $swaps = $this->schools()
            ->selectRaw('
                SUM(swaps.pet_bottles) as total_pet_bottles,
                SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(swaps.tetra_pak) as total_tetra_pak,
                SUM(swaps.aluminum_cans) as total_aluminum_cans,
                SUM(swaps.green_coin) as total_green_coin
            ')

            ->join('school_classes', 'school_classes.school_id', '=', 'schools.id')
            ->join('students', 'students.school_class_id', '=', 'school_classes.id')
            ->join('swaps', 'swaps.student_id', '=', 'students.id')
            ->get();

        // dd($swaps);

        $total = $swaps[0]['total_pet_bottles'] + $swaps[0]['total_packaging_of_cleaning_materials'] + $swaps[0]['total_tetra_pak'] + $swaps[0]['total_aluminum_cans'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }

    protected function totalGreenCoins(): Attribute
    {
        $total = 0;

        $swaps = $this->schools()
            ->selectRaw('
            SUM(swaps.pet_bottles) as total_pet_bottles,
            SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
            SUM(swaps.tetra_pak) as total_tetra_pak,
            SUM(swaps.aluminum_cans) as total_aluminum_cans,
            SUM(swaps.green_coin) as total_green_coin
        ')
            ->join('school_classes', 'school_classes.school_id', '=', 'schools.id')
            ->join('students', 'students.school_class_id', '=', 'school_classes.id')
            ->join('swaps', 'swaps.student_id', '=', 'students.id')
            ->get();

        $total = $swaps[0]['total_green_coin'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }
}
