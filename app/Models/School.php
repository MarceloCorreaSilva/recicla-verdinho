<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'coordinator_id',
        'name',
        'limit_per_swap',
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

    public function reportToYears()
    {
        $report = [];
        $reportAnual = [];
        $school = School::find($this->id);

        $school_classes = $school->school_classes()
            ->selectRaw('
                strftime("%Y", swaps.date) as year,
                strftime("%m", swaps.date) as month,
                strftime("%d", swaps.date) as day,
                strftime("%d/%m/%Y", swaps.date) as data,

                SUM(swaps.pet_bottles) as total_pet_bottles,
                SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(swaps.tetra_pak) as total_tetra_pak,
                SUM(swaps.aluminum_cans) as total_aluminum_cans,
                SUM(swaps.green_coin) as total_green_coin
            ')

            ->join('students', 'students.school_class_id', '=', 'school_classes.id')
            ->join('swaps', 'swaps.student_id', '=', 'students.id')
            ->orderBy('swaps.date', 'asc')

            ->groupBy('year', 'month', 'day')
            ->get();



        $school_classes->each(function ($item) use (&$report) {
            $report[intval($item->year)][intval($item->month)][intval($item->day)] = [
                'data' => $item->data,
                'pet_bottles' => $item->total_pet_bottles,
                'packaging_of_cleaning_materials' => $item->total_packaging_of_cleaning_materials,
                'tetra_pak' => $item->total_tetra_pak,
                'aluminum_cans' => $item->total_aluminum_cans,
                'green_coin' => $item->total_green_coin,
            ];
        });

        $school_classes->each(function ($item) use (&$reportAnual) {
            $reportAnual[intval($item->year)]['pet_bottles'] = 0;
            $reportAnual[intval($item->year)]['packaging_of_cleaning_materials'] = 0;
            $reportAnual[intval($item->year)]['tetra_pak'] = 0;
            $reportAnual[intval($item->year)]['aluminum_cans'] = 0;
            $reportAnual[intval($item->year)]['green_coin'] = 0;
        });

        $school_classes->each(function ($item) use (&$reportAnual) {
            $reportAnual[intval($item->year)] = [
                'pet_bottles' => $reportAnual[intval($item->year)]['pet_bottles'] + $item->total_pet_bottles,
                'packaging_of_cleaning_materials' => $reportAnual[intval($item->year)]['packaging_of_cleaning_materials'] + $item->total_packaging_of_cleaning_materials,
                'tetra_pak' => $reportAnual[intval($item->year)]['tetra_pak'] + $item->total_tetra_pak,
                'aluminum_cans' => $reportAnual[intval($item->year)]['aluminum_cans'] + $item->total_aluminum_cans,
                'green_coin' => $reportAnual[intval($item->year)]['green_coin'] + $item->total_green_coin,
            ];
        });

        return [
            'report' => $report,
            'reportAnual' => $reportAnual
        ];
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

    public function financial(): HasOne
    {
        return $this->hasOne(Financial::class);
    }
}
