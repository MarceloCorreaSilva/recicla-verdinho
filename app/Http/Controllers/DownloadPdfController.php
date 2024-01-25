<?php

namespace App\Http\Controllers;

use App\Models\School;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadPdfController extends Controller
{
    function download(School $record)
    {
        $report = [];
        $reportAnual = [];
        $school = School::find($record->id);
        $school_classes = $school->school_classes()
            // ->with('school')
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

            // ->get(['school_classes.*', 'students.*', 'swaps.*']); // exclude extra details from friends table
            ->get();

        // dd($school_classes);

        // return view('school-pdf', ['school_classes' => $school_classes]);
        // var_dump($school_classes);

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
                // 'data' => $item->data,
                'pet_bottles' => $reportAnual[intval($item->year)]['pet_bottles'] + $item->total_pet_bottles,
                'packaging_of_cleaning_materials' => $reportAnual[intval($item->year)]['packaging_of_cleaning_materials'] + $item->total_packaging_of_cleaning_materials,
                'tetra_pak' => $reportAnual[intval($item->year)]['tetra_pak'] + $item->total_tetra_pak,
                'aluminum_cans' => $reportAnual[intval($item->year)]['aluminum_cans'] + $item->total_aluminum_cans,
                'green_coin' => $reportAnual[intval($item->year)]['green_coin'] + $item->total_green_coin,
            ];
        });


        // $months = $school_classes->pluck('month')->sortBy('month')->unique();

        // dd($report, $reportAnual);
        // return view('school-pdf', ['report' => $report]);

        $pdf = Pdf::loadView('school-pdf', ['school' => $school, 'report' => $report, 'reportAnual' => $reportAnual]);
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream();


        // $report = [];
        // $cards = Jobcard::select([
        //     'job_comp_code',
        //     \DB::raw("DATE_FORMAT(job_received_date, '%Y-%m') as month"),
        //     \DB::raw('COUNT(id) as invoices'),
        //     \DB::raw('SUM(job_invoice_amount) as amount')
        // ])
        //     ->groupBy('job_comp_code')
        //     ->groupBy('month')
        //     ->get();

        // $cards->each(function ($item) use (&$report) {
        //     $report[$item->month][$item->job_comp_code] = [
        //         'count' => $item->invoices,
        //         'amount' => $item->amount
        //     ];
        // });

        // $job_comp_codes = $cards->pluck('job_comp_code')->sortBy('job_comp_code')->unique();

        // return view('report', compact('report', 'job_comp_codes'));
    }
}
