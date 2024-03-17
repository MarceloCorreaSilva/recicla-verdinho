<?php

namespace App\Filament\Widgets;

use App\Models\City;
use App\Models\Financial;
use App\Models\School;
use App\Models\Student;
use App\Models\Swap;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class StatsOverview extends BaseWidget
{

    private function formatNumberToStat(string $value): string
    {
        return number_format(intval($value), 0, '.', '.');
    }

    protected function getCards(): array
    {
        // dd([
        //     'Developer' => Auth()->user()->hasRole('Developer'),
        //     'Admin' => Auth()->user()->hasRole('Admin'),
        //     'Secretario' => Auth()->user()->hasRole('Secretario'),
        //     'Gerente' => Auth()->user()->hasRole('Gerente'),
        //     'Coordenador' => Auth()->user()->hasRole('Coordenador'),
        // ]);

        if (auth()->user()->hasRole(['Developer', 'Admin'])) {
            return [
                Card::make(
                    'Municipios Participantes',
                    $this->formatNumberToStat(City::where('active', true)->count())
                ),

                Card::make(
                    'Escolas Participantes',
                    $this->formatNumberToStat(School::where('active', true)->count())
                ),

                Card::make(
                    'Alunos Atendidos',
                    $this->formatNumberToStat(Student::count())
                ),

                Card::make(
                    'Volumes Trocados',
                    $this->formatNumberToStat(Swap::totalSwaps())
                ),

                Card::make(
                    'Verdinhos Distribuídos',
                    $this->formatNumberToStat(Swap::totalGreenCoins())
                ),
            ];
        }

        if (auth()->user()->hasRole(['Secretario'])) {
            // $schools = auth()->user()->city->schools;
            $city = City::where('secretary_id', '=', auth()->user()->id)->first();
            $schools = $city->schools ?? null;
            $totalSchools = $schools->count() ?? 0;
            $totalStudents = 0;
            $totalSwaps = 0;
            $totalGreenCoins = 0;
            $totalBalance = 0;

            foreach ($schools ?? [] as $school) {
                $totalStudents += $school->students()->count();
                $totalBalance += $school->financial->balance;

                foreach ($school->students()->with('swaps')->get() as $student) {
                    foreach ($student->swaps as $swap) {
                        $totalSwaps += $swap->pet_bottles;
                        $totalSwaps += $swap->packaging_of_cleaning_materials;
                        $totalSwaps += $swap->tetra_pak;
                        $totalSwaps += $swap->aluminum_cans;
                        $totalGreenCoins += $swap->green_coin;
                    }
                }
            }

            // dd([
            //     'User' => auth()->user(),
            //     'Cidade' => $city,
            //     'Escolas' => $city->schools,
            //     'Total Escolas' => $totalSchools,
            //     'Alunos' => $totalStudents,
            //     'Trocas' => $totalSwaps,
            //     'Verdinhos' => $totalGreenCoins,
            //     'Saldo' => $totalBalance,
            // ]);
            return [
                Card::make('Escolas', $totalSchools),
                Card::make('Alunos Atendidos', $this->formatNumberToStat($totalStudents)),
                Card::make('Volumes Trocados', $this->formatNumberToStat($totalSwaps)),
                Card::make('Verdinhos Distribuídos', $this->formatNumberToStat($totalGreenCoins)),
                Card::make('Saldo Restante', $this->formatNumberToStat($totalBalance)),
            ];
        }

        if (auth()->user()->hasRole(['Gerente'])) {
            $schools = School::where('manager_id', '=', auth()->user()->id)->get();
            $totalSchools = $schools->count() ?? 0;
            $totalStudents = 0;
            $totalSwaps = 0;
            $totalGreenCoins = 0;
            $totalBalance = 0;

            foreach ($schools ?? [] as $school) {
                $totalStudents += $school->students()->count();
                $totalBalance += $school->financial->balance;

                foreach ($school->students()->with('swaps')->get() as $student) {
                    foreach ($student->swaps as $swap) {
                        $totalSwaps += $swap->pet_bottles;
                        $totalSwaps += $swap->packaging_of_cleaning_materials;
                        $totalSwaps += $swap->tetra_pak;
                        $totalSwaps += $swap->aluminum_cans;
                        $totalGreenCoins += $swap->green_coin;
                    }
                }
            }

            // dd([
            //     'Escolas' => $totalSchools,
            //     'Alunos' => $totalStudents,
            //     'Trocas' => $totalSwaps,
            //     'Verdinhos' => $totalGreenCoins,
            //     'Saldo' => $totalBalance,
            // ]);
            return [
                Card::make('Escolas', $totalSchools),
                Card::make('Alunos Atendidos', $this->formatNumberToStat($totalStudents)),
                Card::make('Volumes Trocados', $this->formatNumberToStat($totalSwaps)),
                Card::make('Verdinhos Distribuídos', $this->formatNumberToStat($totalGreenCoins)),
                Card::make('Saldo Restante', $this->formatNumberToStat($totalBalance)),
            ];
        }

        if (auth()->user()->hasRole(['Coordenador'])) {
            $schools = School::where('coordinator_id', '=', auth()->user()->id)->get();
            $totalSchools = $schools->count() ?? 0;
            $totalStudents = 0;
            $totalSwaps = 0;
            $totalGreenCoins = 0;
            $totalBalance = 0;

            foreach ($schools ?? [] as $school) {
                $totalStudents += $school->students()->count();
                $totalBalance += $school->financial->balance;

                foreach ($school->students()->with('swaps')->get() as $student) {
                    foreach ($student->swaps as $swap) {
                        $totalSwaps += $swap->pet_bottles;
                        $totalSwaps += $swap->packaging_of_cleaning_materials;
                        $totalSwaps += $swap->tetra_pak;
                        $totalSwaps += $swap->aluminum_cans;
                        $totalGreenCoins += $swap->green_coin;
                    }
                }
            }

            // dd([
            //     'Escolas' => $totalSchools,
            //     'Alunos' => $totalStudents,
            //     'Trocas' => $totalSwaps,
            //     'Verdinhos' => $totalGreenCoins,
            //     'Saldo' => $totalBalance,
            // ]);
            return [
                Card::make('Escolas', $totalSchools),
                Card::make('Alunos Atendidos', $this->formatNumberToStat($totalStudents)),
                Card::make('Volumes Trocados', $this->formatNumberToStat($totalSwaps)),
                Card::make('Verdinhos Distribuídos', $this->formatNumberToStat($totalGreenCoins)),
                Card::make('Saldo Restante', $this->formatNumberToStat($totalBalance)),
            ];
        }

        $totalSwaps = 0;
        $totalGreenCoins = 0;
        $totalBalance = 0;

        if (auth()->user()->hasRole('Coordenador')) {
            $swaps = Swap::selectRaw('
                schools.id,
                schools.name,
                SUM(swaps.pet_bottles) as total_pet_bottles,
                SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(swaps.tetra_pak) as total_tetra_pak,
                SUM(swaps.aluminum_cans) as total_aluminum_cans,
                SUM(swaps.green_coin) as total_green_coin
            ')
                ->join('students', 'students.id', '=', 'swaps.student_id')
                ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                ->where('schools.id', '=', auth()->user()->coordinator->id)

                ->get([
                    'schools.*',
                    'school_classes.*',
                    'students.*',
                    'swaps.*',
                ]);

            $totalSwaps = $swaps[0]['total_pet_bottles'] + $swaps[0]['total_packaging_of_cleaning_materials'] + $swaps[0]['total_tetra_pak'] + $swaps[0]['total_aluminum_cans'];
            $totalGreenCoins = !is_null($swaps[0]['total_green_coin']) ? $swaps[0]['total_green_coin'] : 0;

            // $financial = Financial::where('school_id', '=', $swaps[0]['id'])->get();
            $schools = School::where('coordinator_id', '=', auth()->user()->id)->get();

            foreach ($schools as $school) {
                $totalBalance += $school->financial->balance;
            }
            // dd(
            //     // auth()->user(),
            //     $schools->toArray(),
            //     $totalBalance
            // );
        }

        if (auth()->user()->hasRole('Gerente')) {
            $swaps = Swap::selectRaw('
                schools.id,
                schools.name,
                SUM(swaps.pet_bottles) as total_pet_bottles,
                SUM(swaps.packaging_of_cleaning_materials) as total_packaging_of_cleaning_materials,
                SUM(swaps.tetra_pak) as total_tetra_pak,
                SUM(swaps.aluminum_cans) as total_aluminum_cans,
                SUM(swaps.green_coin) as total_green_coin
            ')
                ->join('students', 'students.id', '=', 'swaps.student_id')
                ->join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                ->join('cities', 'cities.id', '=', 'schools.city_id')
                ->where('cities.manager_id', '=', auth()->user()->id)

                ->get([
                    'schools.*',
                    'school_classes.*',
                    'students.*',
                    'swaps.*',
                ]);

            $totalSwaps = $swaps[0]['total_pet_bottles'] + $swaps[0]['total_packaging_of_cleaning_materials'] + $swaps[0]['total_tetra_pak'] + $swaps[0]['total_aluminum_cans'];
            $totalGreenCoins = !is_null($swaps[0]['total_green_coin']) ? $swaps[0]['total_green_coin'] : 0;

            // dd(
            //     auth()->user()->manager->schools,
            //     $school,
            //     $swaps,
            //     $financial // $financial[0]['balance']
            // );

            foreach (auth()->user()->manager->schools as $school) {
                $totalBalance += $school->financial->balance;
            }
        }


        if (auth()->user()->hasRole(['Developer', 'Admin'])) {
            return [
                Card::make(
                    'Municipios Participantes',
                    $this->formatNumberToStat(City::where('active', true)->count())
                ),

                Card::make(
                    'Escolas Participantes',
                    $this->formatNumberToStat(School::where('active', true)->count())
                ),

                Card::make(
                    'Alunos Atendidos',
                    $this->formatNumberToStat(Student::count())
                ),

                Card::make(
                    'Volumes Trocados',
                    $this->formatNumberToStat(Swap::totalSwaps())
                ),

                Card::make(
                    'Verdinhos Distribuídos',
                    $this->formatNumberToStat(Swap::totalGreenCoins())
                ),
            ];
        } else if (auth()->user()->hasRole(['Gerente'])) {
            // dd(auth()->user());
            return [
                Card::make(
                    'Escolas',
                    auth()->user()->manager->schools->count()
                ),
                Card::make(
                    'Alunos Atendidos',
                    $this->formatNumberToStat(
                        Student::join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                            ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                            ->join('cities', 'cities.id', '=', 'schools.city_id')
                            ->where('cities.manager_id', '=', auth()->user()->id)
                            ->get()
                            ->count()
                    ),
                ),
                Card::make(
                    'Volumes Trocados',
                    $this->formatNumberToStat($totalSwaps)
                ),
                Card::make(
                    'Verdinhos Distribuídos',
                    $this->formatNumberToStat($totalGreenCoins)
                ),
                Card::make(
                    'Saldo Restante',
                    $this->formatNumberToStat($totalBalance)
                ),
            ];
        } else {
            return [
                Card::make(
                    'Alunos Atendidos',
                    $this->formatNumberToStat(
                        Student::join('school_classes', 'school_classes.id', '=', 'students.school_class_id')
                            ->join('schools', 'schools.id', '=', 'school_classes.school_id')
                            ->where('schools.id', '=', auth()->user()->coordinator->id)
                            ->get()
                            ->count()
                    ),
                ),
                Card::make(
                    'Volumes Trocados',
                    $this->formatNumberToStat($totalSwaps)
                ),

                Card::make(
                    'Verdinhos Distribuídos',
                    $this->formatNumberToStat($totalGreenCoins)
                ),

                Card::make(
                    'Saldo Restante',
                    $this->formatNumberToStat($totalBalance)
                ),
            ];
        }
    }
}
