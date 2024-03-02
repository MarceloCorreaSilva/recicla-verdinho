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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
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

    protected function totalMaterials(): Attribute
    {
        $total = 0;

        $school = Student::find($this->student_id)->school_class()->get();

        $swaps = School::find($school[0]['school_id'])
            ->school_classes()
            ->selectRaw('
                SUM(swaps.pet_bottles) as total_pet_bottles,
                SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(swaps.tetra_pak) as total_tetra_pak,
                SUM(swaps.aluminum_cans) as total_aluminum_cans,
                SUM(swaps.green_coin) as total_green_coin
            ')
            ->join('students', 'students.school_class_id', '=', 'school_classes.id')
            ->join('swaps', 'swaps.student_id', '=', 'students.id')
            ->where('swaps.date', '=', $this->date)
            ->get();;

        // dd($swaps);

        $total = $swaps[0]['total_pet_bottles'] + $swaps[0]['total_packaging_of_cleaning_materials'] + $swaps[0]['total_tetra_pak'] + $swaps[0]['total_aluminum_cans'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }

    protected function totalGreenCoinsSwap(): Attribute
    {
        $total = 0;

        $school = Student::find($this->student_id)->school_class()->get();

        $swaps = School::find($school[0]['school_id'])
            ->school_classes()
            ->selectRaw('
            SUM(swaps.pet_bottles) as total_pet_bottles,
            SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
            SUM(swaps.tetra_pak) as total_tetra_pak,
            SUM(swaps.aluminum_cans) as total_aluminum_cans,
            SUM(swaps.green_coin) as total_green_coin
        ')
            ->join('students', 'students.school_class_id', '=', 'school_classes.id')
            ->join('swaps', 'swaps.student_id', '=', 'students.id')
            ->where('swaps.date', '=', $this->date)
            ->get();;

        $total = $swaps[0]['total_green_coin'];

        return Attribute::make(
            get: fn () => number_format($total, 0, '', '.'),
            set: fn (int $total) => $total,
        );
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
